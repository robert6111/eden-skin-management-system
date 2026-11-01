<?php require __DIR__.'/includes/bootstrap.php'; require_permission('dashboard.view');
$bid=current_branch_id(); ensure_continuation_schema(); $today=today();
$k=[
 'appointments'=>(int)scalar('SELECT COUNT(*) FROM appointments WHERE branch_id=? AND appointment_date=?',[$bid,$today]),
 'walkins'=>(int)scalar('SELECT COUNT(*) FROM queues WHERE branch_id=? AND queue_date=?',[$bid,$today]),
 'ongoing'=>(int)scalar('SELECT COUNT(*) FROM queues WHERE branch_id=? AND queue_date=? AND status="in_service"',[$bid,$today]),
 'completed'=>(int)scalar('SELECT COUNT(*) FROM sales WHERE branch_id=? AND DATE(sale_date)=? AND status NOT IN("cancelled")',[$bid,$today]),
 'revenue'=>(float)scalar('SELECT COALESCE(SUM(total_amount),0) FROM sales WHERE branch_id=? AND DATE(sale_date)=? AND status NOT IN("cancelled","refunded")',[$bid,$today]),
 'pending'=>(float)scalar('SELECT COALESCE(SUM(balance_amount),0) FROM sales WHERE branch_id=? AND DATE(sale_date)=? AND balance_amount>0',[$bid,$today]),
 'cash'=>(float)scalar('SELECT COALESCE(SUM(amount),0) FROM payments WHERE branch_id=? AND DATE(payment_date)=? AND payment_method="cash"',[$bid,$today]),
 'mobile'=>(float)scalar('SELECT COALESCE(SUM(amount),0) FROM payments WHERE branch_id=? AND DATE(payment_date)=? AND payment_method IN("mpesa","airtel_money","tigo_pesa","halopesa")',[$bid,$today]),
 'card'=>(float)scalar('SELECT COALESCE(SUM(amount),0) FROM payments WHERE branch_id=? AND DATE(payment_date)=? AND payment_method="card"',[$bid,$today]),
 'expenses'=>(float)scalar('SELECT COALESCE(SUM(amount),0) FROM expenses WHERE branch_id=? AND expense_date=?',[$bid,$today]),
 'low'=>(int)scalar('SELECT COUNT(*) FROM stock_levels sl JOIN products p ON p.id=sl.product_id WHERE sl.branch_id=? AND sl.quantity<=p.minimum_stock AND p.status="active"',[$bid]),
 'present'=>(int)scalar('SELECT COUNT(*) FROM attendance WHERE branch_id=? AND attendance_date=? AND status IN("present","late")',[$bid,$today]),
 'absent'=>(int)scalar('SELECT COUNT(*) FROM attendance WHERE branch_id=? AND attendance_date=? AND status="absent"',[$bid,$today])
]; $k['profit']=$k['revenue']-$k['expenses'];
$contCounts=continuation_due_counts($bid);
$days=[];$values=[];for($i=6;$i>=0;$i--){$d=date('Y-m-d',strtotime("-$i days"));$days[]=date('D',strtotime($d));$values[]=(float)scalar('SELECT COALESCE(SUM(total_amount),0) FROM sales WHERE branch_id=? AND DATE(sale_date)=? AND status NOT IN("cancelled","refunded")',[$bid,$d]);}$max=max($values?:[1])?:1;
$popular=all('SELECT si.description, SUM(si.quantity) qty, SUM(si.line_total) amount FROM sale_items si JOIN sales s ON s.id=si.sale_id WHERE s.branch_id=? AND si.item_type="service" AND s.sale_date>=DATE_SUB(NOW(),INTERVAL 30 DAY) GROUP BY si.description ORDER BY qty DESC LIMIT 5',[$bid]);
$staffPerf=all('SELECT st.full_name,COUNT(DISTINCT c.sale_id) sales,COALESCE(SUM(c.commission_amount),0) commission FROM staff st LEFT JOIN commissions c ON c.staff_id=st.id AND c.created_at>=DATE_FORMAT(NOW(),"%Y-%m-01") WHERE st.branch_id=? AND st.status="active" GROUP BY st.id ORDER BY sales DESC LIMIT 5',[$bid]);
$activity=all('SELECT sa.*,u.username FROM system_activities sa LEFT JOIN users u ON u.id=sa.user_id WHERE sa.branch_id=? ORDER BY sa.id DESC LIMIT 10',[$bid]);
$title='Dashboard'; $subtitle="Today's business at a glance"; include __DIR__.'/includes/header.php';
?>
<div class="grid cols-4">
<?php $cards=[['Today\'s Appointments',$k['appointments']],['Walk-in Customers',$k['walkins']],['Ongoing Services',$k['ongoing']],['Completed Services',$k['completed']],['Today\'s Revenue',money($k['revenue'])],['Pending Payments',money($k['pending'])],['Cash Collected',money($k['cash'])],['Mobile Money',money($k['mobile'])],['Card Payments',money($k['card'])],['Expenses Today',money($k['expenses'])],['Profit Today',money($k['profit'])],['Products Running Low',$k['low']],['Continuations Today',$contCounts['today']],['Overdue Continuations',$contCounts['overdue']],['Staff Present',$k['present']],['Staff Absent',$k['absent']]]; foreach($cards as [$l,$v]):?><div class="card kpi"><small><?=e($l)?></small><strong><?=e($v)?></strong></div><?php endforeach;?></div>
<div class="grid cols-2" style="margin-top:16px"><section class="card"><h2>Daily Sales — Last 7 Days</h2><div class="chart"><?php foreach($values as $i=>$v):?><div class="bar" style="height:<?=max(3,round($v/$max*100))?>%" title="<?=money($v)?>"><span><?=e($days[$i])?></span></div><?php endforeach;?></div></section><section class="card"><h2>Popular Services — 30 Days</h2><ul class="stat-list"><?php foreach($popular as $r):?><li><span><?=e($r['description'])?></span><strong><?=e($r['qty'])?> • <?=money($r['amount'])?></strong></li><?php endforeach;?><?php if(!$popular):?><li>No sales yet</li><?php endif;?></ul></section></div>
<div class="grid cols-2" style="margin-top:16px"><section class="card"><h2>Staff Performance — This Month</h2><div class="table-wrap"><table><thead><tr><th>Staff</th><th>Sales</th><th>Commission</th></tr></thead><tbody><?php foreach($staffPerf as $r):?><tr><td><?=e($r['full_name'])?></td><td><?=e($r['sales'])?></td><td><?=money($r['commission'])?></td></tr><?php endforeach;?></tbody></table></div></section><section class="card"><h2>Live System Activity</h2><ul class="stat-list"><?php foreach($activity as $r):?><li><span><?=e($r['message'])?></span><small><?=date('H:i',strtotime($r['created_at']))?></small></li><?php endforeach;?><?php if(!$activity):?><li>No activity yet.</li><?php endif;?></ul></section></div>
<?php include __DIR__.'/includes/footer.php'; ?>
