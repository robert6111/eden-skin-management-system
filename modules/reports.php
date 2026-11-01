<?php
require dirname(__DIR__) . '/includes/bootstrap.php';
require_permission('reports.view');
require dirname(__DIR__) . '/includes/reporting.php';

$filters = spa_report_filters();
$master = spa_report_master_data($filters);
$data = spa_report_data($filters);
$logoUrl = url('assets/img/eden_skin_logo.jpg');

if (isset($_GET['export'])) {
    if ($_GET['export'] === 'sales') {
        $rows = [];
        foreach ($data['sales'] as $r) {
            $rows[] = [$r['id'], $r['invoice_no'], $r['sale_date'], $r['customer'], $r['customer_phone'], $r['branch'], $r['total_amount'], $r['paid_amount'], $r['balance_amount'], $r['status']];
        }
        csv_download('spa_sales_report.csv', ['ID','Invoice','Date','Customer','Phone','Branch','Total','Paid','Balance','Status'], $rows);
    }
    if ($_GET['export'] === 'inventory') {
        $rows = [];
        foreach ($data['low_stock'] as $r) {
            $rows[] = [$r['branch'], $r['name'], $r['brand'], $r['qty'], $r['minimum_stock'], $r['expiry_date']];
        }
        csv_download('spa_low_stock_report.csv', ['Branch','Product','Brand','Quantity','Minimum Stock','Expiry Date'], $rows);
    }
}

$title = 'Sales Report';
$subtitle = 'Eden Skin — Skin Beauty Aesthetics';
include dirname(__DIR__) . '/includes/header.php';
?>
<style>
.stock-report .report-container{max-width:1250px;margin:auto;background:#fff;padding:22px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,.08)}
.stock-report .report-top-bar{display:flex;justify-content:space-between;align-items:center;gap:14px;margin-bottom:18px;flex-wrap:wrap}
.stock-report .report-brand{display:flex;gap:14px;align-items:center}
.stock-report .report-logo{width:76px;height:76px;border-radius:10px;object-fit:cover;border:1px solid #ead8a6;background:#fff}
.stock-report h1{margin:0;font-size:26px}.stock-report h2{margin-top:35px;border-left:4px solid #333;padding-left:10px;font-size:20px}.stock-report .muted{color:#666}
.stock-report .back-link,.stock-report .reset-btn{display:inline-block;text-decoration:none;background:#444;color:#fff;padding:8px 12px;border-radius:4px;font-size:14px}.stock-report .reset-btn{background:#777}
.stock-report .filter-box{background:#f1f1f1;padding:15px;border-radius:6px;margin-bottom:25px}.stock-report .filter-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:12px}.stock-report label{font-weight:bold;font-size:13px;display:block;margin-bottom:4px}.stock-report input,.stock-report select{width:100%;padding:7px;border:1px solid #bbb;border-radius:4px;box-sizing:border-box;background:#fff}.stock-report .filter-actions{margin-top:15px;display:flex;gap:10px;flex-wrap:wrap}.stock-report button,.stock-report .pdf-btn,.stock-report .csv-btn{padding:9px 15px;border:none;border-radius:4px;cursor:pointer;text-decoration:none;font-size:14px}.stock-report .filter-btn{background:#1f6feb;color:#fff}.stock-report .pdf-btn{background:#198754;color:#fff}.stock-report .csv-btn{background:#6f42c1;color:#fff}.stock-report .summary-cards{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:25px}.stock-report .report-card{background:#f8f9fa;border:1px solid #ddd;padding:15px;border-radius:6px}.stock-report .card-title{font-size:13px;color:#666}.stock-report .card-value{font-size:22px;font-weight:bold;margin-top:5px}.stock-report table{width:100%;border-collapse:collapse;margin-bottom:25px;background:#fff}.stock-report th,.stock-report td{padding:8px;border:1px solid #ccc;font-size:14px}.stock-report th{background:#f4f4f4;text-align:left}.stock-report .text-right{text-align:right}.stock-report .text-center{text-align:center}.stock-report .invoice-link{text-decoration:none;background:#333;color:white;padding:5px 9px;border-radius:4px;font-size:13px}.stock-report .grand-row th{background:#e8e8e8}.stock-report .report-grid-2{display:grid;grid-template-columns:repeat(2,1fr);gap:18px}.stock-report .empty{text-align:center;color:#777}@media(max-width:900px){.stock-report .filter-grid,.stock-report .summary-cards,.stock-report .report-grid-2{grid-template-columns:repeat(2,1fr)}}@media(max-width:600px){.stock-report .filter-grid,.stock-report .summary-cards,.stock-report .report-grid-2{grid-template-columns:1fr}.stock-report th,.stock-report td{padding:6px;font-size:12px}.stock-report .report-logo{width:60px;height:60px}}@media print{.topbar,.sidebar,.page-head,.filter-box,.filter-actions,.no-print{display:none!important}.layout{display:block}.content{padding:0}.stock-report .report-container{box-shadow:none;border-radius:0}.stock-report .report-logo{width:70px;height:70px}}
</style>
<div class="stock-report">
<div class="report-container">
    <div class="report-top-bar">
        <div class="report-brand">
            <img src="<?= e($logoUrl) ?>" class="report-logo" alt="Eden Skin">
            <div>
                <h1>Sales Report</h1>
                <div class="muted">Eden Skin — Skin Beauty Aesthetics</div>
                <div class="muted">Generated: <?= e(date('d M Y H:i')) ?></div>
            </div>
        </div>
        <a class="back-link no-print" href="<?= e(url('dashboard.php')) ?>">← Go Back</a>
    </div>

    <div class="filter-box no-print">
        <form method="GET">
            <div class="filter-grid">
                <div><label>Sale ID</label><input type="number" name="sale_id" value="<?= e($filters['sale_id']) ?>" placeholder="Example: 15"></div>
                <div><label>From Date</label><input type="date" name="from_date" value="<?= e($filters['from_date']) ?>"></div>
                <div><label>To Date</label><input type="date" name="to_date" value="<?= e($filters['to_date']) ?>"></div>
                <div><label>Branch</label><select name="branch_id" <?= $filters['can_all_branches'] ? '' : 'disabled' ?>><option value="">All Branches</option><?php foreach ($master['branches'] as $b): ?><option value="<?= e($b['id']) ?>"<?= selected($filters['branch_id'], $b['id']) ?>><?= e($b['name']) ?></option><?php endforeach; ?></select><?php if(!$filters['can_all_branches']): ?><input type="hidden" name="branch_id" value="<?= e((int)current_branch_id()) ?>"><?php endif; ?></div>
                <div><label>Customer</label><select name="customer_id"><option value="">All Customers</option><?php foreach ($master['customers'] as $c): ?><option value="<?= e($c['id']) ?>"<?= selected($filters['customer_id'], $c['id']) ?>><?= e($c['full_name']) ?><?= $c['phone'] ? ' — '.e($c['phone']) : '' ?></option><?php endforeach; ?></select></div>
                <div><label>Search Customer / Invoice</label><input type="text" name="search_customer" value="<?= e($filters['search_customer']) ?>" placeholder="Name, phone, email, invoice"></div>
                <div><label>Service / Product / Package</label><select name="item_filter"><option value="">All Items</option><?php foreach ($master['items'] as $it): ?><option value="<?= e($it['value']) ?>"<?= selected($filters['item_filter'], $it['value']) ?>><?= e($it['label']) ?></option><?php endforeach; ?></select></div>
                <div><label>Customer Type</label><select name="customer_type"><option value="all"<?= selected($filters['customer_type'],'all') ?>>All</option><option value="registered"<?= selected($filters['customer_type'],'registered') ?>>Registered Customers</option><option value="walkin"<?= selected($filters['customer_type'],'walkin') ?>>Walk-in Customers</option></select></div>
                <div><label>Min Total</label><input type="number" step="0.01" name="min_total" value="<?= e($filters['min_total']) ?>" placeholder="0.00"></div>
                <div><label>Max Total</label><input type="number" step="0.01" name="max_total" value="<?= e($filters['max_total']) ?>" placeholder="100000.00"></div>
                <div><label>View</label><select name="group_by"><option value="daily"<?= selected($filters['group_by'],'daily') ?>>Daily</option><option value="monthly"<?= selected($filters['group_by'],'monthly') ?>>Monthly</option><option value="yearly"<?= selected($filters['group_by'],'yearly') ?>>Yearly</option></select></div>
                <div><label>Sort By</label><select name="sort_by"><option value="date_desc"<?= selected($filters['sort_by'],'date_desc') ?>>Newest First</option><option value="date_asc"<?= selected($filters['sort_by'],'date_asc') ?>>Oldest First</option><option value="total_desc"<?= selected($filters['sort_by'],'total_desc') ?>>Highest Total</option><option value="total_asc"<?= selected($filters['sort_by'],'total_asc') ?>>Lowest Total</option><option value="customer_asc"<?= selected($filters['sort_by'],'customer_asc') ?>>Customer A-Z</option><option value="branch_asc"<?= selected($filters['sort_by'],'branch_asc') ?>>Branch A-Z</option></select></div>
                <div><label>Records Limit</label><select name="limit"><option value="25"<?= selected($filters['limit'],'25') ?>>25</option><option value="50"<?= selected($filters['limit'],'50') ?>>50</option><option value="100"<?= selected($filters['limit'],'100') ?>>100</option><option value="200"<?= selected($filters['limit'],'200') ?>>200</option><option value="500"<?= selected($filters['limit'],'500') ?>>500</option><option value="all"<?= selected($filters['limit'],'all') ?>>All</option></select></div>
            </div>
            <div class="filter-actions">
                <button class="filter-btn" type="submit">Filter</button>
                <button class="pdf-btn" type="submit" formaction="reports_pdf.php" formmethod="GET" formtarget="_blank">Export PDF</button>
                <a class="csv-btn" href="?<?= e(spa_report_current_query(['export'=>'sales'])) ?>">Export Sales CSV</a>
                <a class="csv-btn" href="?<?= e(spa_report_current_query(['export'=>'inventory'])) ?>">Export Low Stock CSV</a>
                <a class="reset-btn" href="reports.php">Reset</a>
            </div>
        </form>
    </div>

    <h2>Sales List</h2>
    <table>
        <tr><th>ID</th><th>Invoice</th><th>Date</th><th>Customer</th><th>Phone</th><th>Branch</th><th class="text-right">Total</th><th class="text-right">Paid</th><th class="text-right">Balance</th><th>Status</th><th class="text-center no-print">Receipt</th></tr>
        <?php $grand = 0; ?>
        <?php if ($data['sales']): foreach ($data['sales'] as $row): $grand += (float)$row['total_amount']; ?>
            <tr><td>#<?= e($row['id']) ?></td><td><?= e($row['invoice_no']) ?></td><td><?= e($row['sale_date']) ?></td><td><?= e($row['customer']) ?></td><td><?= e($row['customer_phone']) ?></td><td><?= e($row['branch']) ?></td><td class="text-right"><?= number_format((float)$row['total_amount'],2) ?></td><td class="text-right"><?= number_format((float)$row['paid_amount'],2) ?></td><td class="text-right"><?= number_format((float)$row['balance_amount'],2) ?></td><td><?= e($row['status']) ?></td><td class="text-center no-print"><a class="invoice-link" href="receipt.php?id=<?= e($row['id']) ?>" target="_blank">PDF</a></td></tr>
        <?php endforeach; ?>
            <tr class="grand-row"><th colspan="6">Grand Total</th><th class="text-right"><?= number_format($grand,2) ?></th><th colspan="4"></th></tr>
        <?php else: ?>
            <tr><td colspan="11" class="empty">No sales found for the selected filters.</td></tr>
        <?php endif; ?>
    </table>

    <div class="summary-cards">
        <div class="report-card"><div class="card-title">Displayed Sales</div><div class="card-value"><?= number_format($data['sales_count']) ?></div></div>
        <div class="report-card"><div class="card-title">Displayed Total</div><div class="card-value"><?= number_format($data['displayed_total'],2) ?></div></div>
        <div class="report-card"><div class="card-title">Revenue</div><div class="card-value"><?= number_format($data['totals']['revenue'],2) ?></div></div>
        <div class="report-card"><div class="card-title">Profit</div><div class="card-value"><?= number_format($data['totals']['profit'],2) ?></div></div>
        <div class="report-card"><div class="card-title">Paid</div><div class="card-value"><?= number_format($data['totals']['paid'],2) ?></div></div>
        <div class="report-card"><div class="card-title">Balance</div><div class="card-value"><?= number_format($data['totals']['balance'],2) ?></div></div>
        <div class="report-card"><div class="card-title">Expenses</div><div class="card-value"><?= number_format($data['totals']['expenses'],2) ?></div></div>
        <div class="report-card"><div class="card-title">New Customers</div><div class="card-value"><?= number_format($data['totals']['new_customers']) ?></div></div>
    </div>

    <h2><?= e(ucfirst($filters['group_by'])) ?> Sales Summary</h2>
    <table><tr><th>Period</th><th class="text-center">Sales Count</th><th class="text-right">Total Amount</th></tr><?php if($data['summary']): foreach($data['summary'] as $s): ?><tr><td><?= e($s['period']) ?></td><td class="text-center"><?= number_format((int)$s['sales_count']) ?></td><td class="text-right"><?= number_format((float)$s['amount'],2) ?></td></tr><?php endforeach; else: ?><tr><td colspan="3" class="empty">No summary data found.</td></tr><?php endif; ?></table>

    <div class="report-grid-2">
        <div><h2>Best Selling Services & Packages</h2><table><tr><th>Service / Package</th><th class="text-center">Qty Sold</th><th class="text-right">Revenue</th></tr><?php if($data['top_services']): foreach($data['top_services'] as $p): ?><tr><td><?= e($p['name']) ?></td><td class="text-center"><?= number_format((float)$p['qty'],2) ?></td><td class="text-right"><?= number_format((float)$p['revenue'],2) ?></td></tr><?php endforeach; else: ?><tr><td colspan="3" class="empty">No service data found.</td></tr><?php endif; ?></table></div>
        <div><h2>Best Selling Products</h2><table><tr><th>Product</th><th class="text-center">Qty Sold</th><th class="text-right">Revenue</th></tr><?php if($data['top_products']): foreach($data['top_products'] as $p): ?><tr><td><?= e($p['name']) ?></td><td class="text-center"><?= number_format((float)$p['qty'],2) ?></td><td class="text-right"><?= number_format((float)$p['revenue'],2) ?></td></tr><?php endforeach; else: ?><tr><td colspan="3" class="empty">No product data found.</td></tr><?php endif; ?></table></div>
    </div>

    <h2>Sales by Branch</h2>
    <table><tr><th>Branch</th><th class="text-center">Sales Count</th><th class="text-right">Total Sales</th></tr><?php if($data['sales_by_branch']): foreach($data['sales_by_branch'] as $w): ?><tr><td><?= e($w['name']) ?></td><td class="text-center"><?= number_format((int)$w['sales_count']) ?></td><td class="text-right"><?= number_format((float)$w['total_sales'],2) ?></td></tr><?php endforeach; else: ?><tr><td colspan="3" class="empty">No branch data found.</td></tr><?php endif; ?></table>

    <div class="report-grid-2">
        <div><h2>Payments by Method</h2><table><tr><th>Payment Method</th><th class="text-right">Amount</th></tr><?php if($data['payments_by_method']): foreach($data['payments_by_method'] as $p): ?><tr><td><?= e(ucwords(str_replace('_',' ', $p['payment_method']))) ?></td><td class="text-right"><?= number_format((float)$p['amount'],2) ?></td></tr><?php endforeach; else: ?><tr><td colspan="2" class="empty">No payment data found.</td></tr><?php endif; ?></table></div>
        <div><h2>Expenses by Category</h2><table><tr><th>Category</th><th class="text-right">Amount</th></tr><?php if($data['expenses_by_category']): foreach($data['expenses_by_category'] as $x): ?><tr><td><?= e($x['category']) ?></td><td class="text-right"><?= number_format((float)$x['amount'],2) ?></td></tr><?php endforeach; else: ?><tr><td colspan="2" class="empty">No expense data found.</td></tr><?php endif; ?></table></div>
    </div>

    <h2>Low Stock Products</h2>
    <table><tr><th>Branch</th><th>Product</th><th>Brand</th><th class="text-center">Quantity</th><th class="text-center">Minimum</th><th>Expiry</th></tr><?php if($data['low_stock']): foreach($data['low_stock'] as $l): ?><tr><td><?= e($l['branch']) ?></td><td><?= e($l['name']) ?></td><td><?= e($l['brand']) ?></td><td class="text-center"><?= number_format((float)$l['qty'],2) ?></td><td class="text-center"><?= number_format((float)$l['minimum_stock'],2) ?></td><td><?= e($l['expiry_date']) ?></td></tr><?php endforeach; else: ?><tr><td colspan="6" class="empty">No low-stock products found.</td></tr><?php endif; ?></table>

    <div class="report-grid-2">
        <div><h2>Recent Stock Movements</h2><table><tr><th>Date</th><th>Product</th><th>Type</th><th class="text-center">Qty</th><th class="text-center">Balance</th></tr><?php if($data['stock_movements']): foreach($data['stock_movements'] as $m): ?><tr><td><?= e($m['created_at']) ?></td><td><?= e($m['product']) ?></td><td><?= e($m['movement_type']) ?></td><td class="text-center"><?= number_format((float)$m['quantity'],2) ?></td><td class="text-center"><?= number_format((float)$m['balance_after'],2) ?></td></tr><?php endforeach; else: ?><tr><td colspan="5" class="empty">No stock movements found.</td></tr><?php endif; ?></table></div>
        <div><h2>Staff Performance</h2><table><tr><th>Staff</th><th>Role</th><th class="text-center">Sales</th><th class="text-right">Commission</th></tr><?php if($data['staff_performance']): foreach($data['staff_performance'] as $st): ?><tr><td><?= e($st['full_name']) ?></td><td><?= e($st['role_title']) ?></td><td class="text-center"><?= number_format((int)$st['sales_count']) ?></td><td class="text-right"><?= number_format((float)$st['commission'],2) ?></td></tr><?php endforeach; else: ?><tr><td colspan="4" class="empty">No staff data found.</td></tr><?php endif; ?></table></div>
    </div>
</div>
</div>
<?php include dirname(__DIR__) . '/includes/footer.php'; ?>
