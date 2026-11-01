<?php
require dirname(__DIR__).'/includes/bootstrap.php';
require_permission('sales.view');

$bid = current_branch_id();
$id = (int)($_GET['id'] ?? 0);

$s = one('SELECT s.*, c.full_name customer, c.phone FROM sales s LEFT JOIN customers c ON c.id=s.customer_id WHERE s.id=? AND s.branch_id=?', [$id, $bid]);
if (!$s) {
    exit('Receipt not found');
}

$items = all('SELECT * FROM sale_items WHERE sale_id=?', [$id]);
$pays = all('SELECT * FROM payments WHERE sale_id=?', [$id]);

$businessName = setting('business_name', 'Eden Skin', $bid);
$businessAddress = setting('business_address', 'Tanzania', $bid);
$businessPhone = setting('business_phone', '', $bid);
$tin = setting('tin', '', $bid);
$vrn = setting('vrn', '', $bid);
$footer = setting('receipt_footer', 'Thank you. Karibu tena!', $bid);
$logoUrl = url('assets/img/eden_skin_logo.jpg');
$faviconUrl = url('assets/img/favicon.png');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receipt <?= e($s['invoice_no']) ?></title>
    <link rel="icon" type="image/png" href="<?= e($faviconUrl) ?>">
    <link rel="shortcut icon" type="image/png" href="<?= e($faviconUrl) ?>">
    <link rel="stylesheet" href="<?= url('assets/css/app.css') ?>">
    <style>
        body{background:#f4f6f8;color:#111827;font-family:Arial,Helvetica,sans-serif}
        .receipt{max-width:760px;margin:20px auto;background:white;padding:25px;border-radius:14px;box-shadow:0 10px 30px rgba(15,23,42,.10)}
        .receipt-logo-wrap{text-align:center;margin-bottom:10px}
        .receipt-logo{max-width:165px;max-height:165px;object-fit:contain;border-radius:10px}
        .receipt h1{text-align:center;margin:6px 0 4px;font-size:26px;letter-spacing:.5px}
        .business-line{text-align:center;color:#475569;margin:3px 0;font-size:14px}
        .receipt-head{display:flex;justify-content:space-between;gap:18px;margin:18px 0;align-items:flex-start}
        .receipt-box{background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;padding:12px;flex:1}
        table{width:100%;border-collapse:collapse;margin-top:10px}
        th,td{border-bottom:1px solid #e5e7eb;padding:10px;text-align:left;vertical-align:top}
        th{background:#f8fafc;font-weight:700}
        .text-right{text-align:right}
        .text-center{text-align:center}
        .totals{max-width:330px;margin-left:auto;margin-top:16px;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden}
        .totals div{display:flex;justify-content:space-between;padding:9px 12px;border-bottom:1px solid #e5e7eb}
        .totals div:last-child{border-bottom:0}
        .totals .grand{background:#111827;color:#fff;font-size:18px}
        .payments{margin-top:18px}
        .receipt-footer{text-align:center;margin-top:24px;font-weight:600;color:#6b4e16}
        .toolbar{display:flex;gap:10px;justify-content:center;margin-top:20px}
        .btn{display:inline-block;border:0;border-radius:8px;padding:10px 14px;text-decoration:none;background:#6d28d9;color:#fff;cursor:pointer;font-weight:700}
        .btn.light{background:#e5e7eb;color:#111827}
        @media print{
            @page{size:A4;margin:12mm}
            body{background:white!important;color:#000!important;font-size:12pt!important;line-height:1.35!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
            .receipt{box-shadow:none!important;margin:0 auto!important;border-radius:0!important;max-width:100%!important;padding:0!important;border:0!important}
            .no-print{display:none!important}
            .receipt-logo{max-width:105px!important;max-height:105px!important}
            .receipt h1{font-size:20pt!important;color:#000!important}
            .business-line,.receipt-footer,p,div,strong,span{color:#000!important}
            .receipt-head{gap:10px!important;margin:10px 0!important}
            .receipt-box{border:1px solid #111!important;background:#fff!important;border-radius:0!important}
            table{border-collapse:collapse!important;width:100%!important}
            th,td{border:1px solid #111!important;color:#000!important;background:#fff!important;padding:6px 7px!important;font-size:10.5pt!important;white-space:normal!important}
            th{font-weight:800!important;background:#f1f1f1!important}
            .totals{border:1px solid #111!important;border-radius:0!important}.totals div{border-bottom:1px solid #111!important}.totals .grand{background:#eaeaea!important;color:#000!important}
        }
    </style>
</head>
<body>
<div class="receipt">
    <div class="receipt-logo-wrap">
        <img class="receipt-logo" src="<?= e($logoUrl) ?>" alt="Business Logo">
    </div>

    <h1><?= e($businessName) ?></h1>
    <p class="business-line"><?= e($businessAddress) ?><?= $businessPhone ? ' • '.e($businessPhone) : '' ?></p>
    <?php if ($tin || $vrn): ?>
        <p class="business-line"><?= $tin ? '<strong>TIN:</strong> '.e($tin) : '' ?><?= ($tin && $vrn) ? ' • ' : '' ?><?= $vrn ? '<strong>VRN:</strong> '.e($vrn) : '' ?></p>
    <?php endif; ?>

    <hr>

    <div class="receipt-head">
        <div class="receipt-box">
            <strong>Invoice:</strong> <?= e($s['invoice_no']) ?><br>
            <strong>Date:</strong> <?= e($s['sale_date']) ?><br>
            <strong>Status:</strong> <?= e($s['status'] ?? '') ?>
        </div>
        <div class="receipt-box">
            <strong>Customer:</strong> <?= e($s['customer'] ?? 'Walk-in') ?><br>
            <?= e($s['phone'] ?? '') ?>
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th>Item</th>
            <th class="text-right">Qty</th>
            <th class="text-right">Unit</th>
            <th class="text-right">Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $it): ?>
            <tr>
                <td><?= e($it['description']) ?></td>
                <td class="text-right"><?= e($it['quantity']) ?></td>
                <td class="text-right"><?= money($it['unit_price']) ?></td>
                <td class="text-right"><?= money($it['line_total']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="totals">
        <div><span>Subtotal</span><strong><?= money($s['subtotal']) ?></strong></div>
        <div><span>Discount</span><strong><?= money($s['discount_amount']) ?></strong></div>
        <div><span>Tax</span><strong><?= money($s['tax_amount']) ?></strong></div>
        <div class="grand"><span>Total</span><strong><?= money($s['total_amount']) ?></strong></div>
        <div><span>Paid</span><strong><?= money($s['paid_amount']) ?></strong></div>
        <div><span>Balance</span><strong><?= money($s['balance_amount']) ?></strong></div>
    </div>

    <div class="payments">
        <h3>Payments</h3>
        <?php if (!$pays): ?>
            <p>No payment recorded.</p>
        <?php endif; ?>
        <?php foreach ($pays as $p): ?>
            <p><?= e($p['payment_method']) ?> — <?= money($p['amount']) ?> <?= e($p['reference_no']) ?></p>
        <?php endforeach; ?>
    </div>

    <p class="receipt-footer"><?= e($footer) ?></p>

    <div class="toolbar no-print">
        <button class="btn" onclick="window.print()">Print / Save as PDF</button>
        <a class="btn light" href="sale_view.php?id=<?= e($id) ?>">Back</a>
    </div>
</div>
<script>window.print();</script>
</body>
</html>
