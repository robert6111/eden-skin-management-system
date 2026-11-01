<?php
require dirname(__DIR__) . '/includes/bootstrap.php';

require_permission('sales.view');

$bid = current_branch_id();

ensure_continuation_schema();

$id = (int) ($_GET['id'] ?? 0);

$sale = one(
    'SELECT s.*,
            c.customer_no,
            c.full_name AS customer,
            c.phone AS customer_phone,
            c.gender AS customer_gender,
            c.email AS customer_email,
            c.address AS customer_address,
            c.emergency_contact AS customer_emergency_contact,
            c.preferences AS customer_preferences
     FROM sales s
     LEFT JOIN customers c ON c.id = s.customer_id
     WHERE s.id = ? AND s.branch_id = ?',
    [$id, $bid]
);

if (!$sale) {
    http_response_code(404);
    exit('Sale not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();

    $action = $_POST['_action'] ?? '';

    if ($action === 'payment') {
        require_permission('sales.create');

        $amount = (float) ($_POST['amount'] ?? 0);

        if ($amount <= 0) {
            flash('error', 'Enter a payment amount.');
            redirect('modules/sale_view.php?id=' . $id);
        }

        if ($amount > (float) ($sale['balance_amount'] ?? 0) + 0.01) {
            flash('error', 'Payment cannot exceed balance.');
            redirect('modules/sale_view.php?id=' . $id);
        }

        $method = $_POST['payment_method'] ?? '';
        $giftId = null;

        db()->beginTransaction();

        try {
            if ($method === 'gift_card') {
                $code = trim($_POST['gift_code'] ?? '');

                $gc = one(
                    'SELECT * FROM gift_cards WHERE code = ? AND branch_id = ? AND status = "active"',
                    [$code, $bid]
                );

                if (!$gc) {
                    throw new RuntimeException('Gift card not found.');
                }

                if ((float) $gc['current_balance'] < $amount) {
                    throw new RuntimeException('Gift card balance is too low.');
                }

                $giftId = (int) $gc['id'];

                q(
                    'UPDATE gift_cards
                     SET current_balance = current_balance - ?,
                         status = IF(current_balance - ? <= 0, "used", "active")
                     WHERE id = ?',
                    [$amount, $amount, $giftId]
                );

                q(
                    'INSERT INTO gift_card_transactions
                     (gift_card_id, sale_id, amount, type, created_by, created_at)
                     VALUES (?, ?, ?, "redeem", ?, NOW())',
                    [$giftId, $id, $amount, $_SESSION['user_id']]
                );
            }

            q(
                'INSERT INTO payments
                 (branch_id, sale_id, payment_method, amount, reference_no, gift_card_id, received_by, payment_date, notes)
                 VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)',
                [
                    $bid,
                    $id,
                    $method,
                    $amount,
                    trim($_POST['reference_no'] ?? ''),
                    $giftId,
                    $_SESSION['user_id'],
                    'Balance payment'
                ]
            );

            q(
                'UPDATE sales SET paid_amount = paid_amount + ? WHERE id = ?',
                [$amount, $id]
            );

            sale_balance_and_status($id);

            audit('payment', 'sales', $id, ['amount' => $amount]);

            db()->commit();

            flash('success', 'Payment recorded.');
        } catch (Throwable $e) {
            db()->rollBack();
            flash('error', $e->getMessage());
        }

        redirect('modules/sale_view.php?id=' . $id);
    }

    if ($action === 'rating') {
        $rating = max(1, min(5, (int) ($_POST['rating'] ?? 0)));

        q(
            'INSERT INTO customer_ratings
             (branch_id, customer_id, sale_id, staff_id, rating, comments, created_at)
             VALUES (?, ?, ?, ?, ?, ?, NOW())',
            [
                $bid,
                $sale['customer_id'] ?: null,
                $id,
                (int) ($_POST['staff_id'] ?? 0) ?: null,
                $rating,
                trim($_POST['comments'] ?? '')
            ]
        );

        flash('success', 'Rating saved.');
        redirect('modules/sale_view.php?id=' . $id);
    }
}

/*
 * Force associative fetching here so the page reads the real sale_items
 * columns exactly as stored in the database.
 */
$saleItemStmt = q(
    "SELECT
        si.id,
        si.sale_id,
        si.item_type,
        si.item_id,
        CASE
            WHEN si.description IS NOT NULL AND si.description <> '' THEN si.description
            WHEN si.item_type = 'service' THEN svc.name
            WHEN si.item_type = 'product' THEN pr.name
            WHEN si.item_type = 'package' THEN pk.name
            ELSE CONCAT('Sale item #', si.id)
        END AS description,
        si.staff_id,
        COALESCE(st.full_name, '') AS staff,
        si.quantity,
        si.unit_price,
        si.discount_amount,
        si.line_total,
        si.refunded_quantity
     FROM sale_items si
     LEFT JOIN staff st ON st.id = si.staff_id
     LEFT JOIN services svc ON si.item_type = 'service' AND svc.id = si.item_id
     LEFT JOIN products pr ON si.item_type = 'product' AND pr.id = si.item_id
     LEFT JOIN packages pk ON si.item_type = 'package' AND pk.id = si.item_id
     WHERE si.sale_id = ?
     ORDER BY si.id",
    [$id]
);

$saleItems = $saleItemStmt->fetchAll(PDO::FETCH_ASSOC);

$usedProductStmt = q(
    "SELECT
        sm.id,
        sm.movement_type,
        p.name AS product_name,
        p.brand,
        p.unit,
        ABS(sm.quantity) AS quantity_used,
        sm.balance_after,
        sm.notes,
        sm.created_at
     FROM stock_movements sm
     JOIN products p ON p.id = sm.product_id
     WHERE sm.branch_id = ?
       AND sm.reference_type = 'sale'
       AND sm.reference_id = ?
       AND sm.movement_type IN ('sale', 'service_use')
     ORDER BY sm.id",
    [$bid, $id]
);

$usedProducts = $usedProductStmt->fetchAll(PDO::FETCH_ASSOC);

$continuations = all(
    'SELECT f.*,
            s.name service_name,
            COALESCE(cs.name, s.name) continuation_service
     FROM customer_service_continuations f
     JOIN services s ON s.id = f.service_id
     LEFT JOIN services cs ON cs.id = f.continuation_service_id
     WHERE f.sale_id = ?
     ORDER BY f.due_date',
    [$id]
);

$payments = all(
    'SELECT * FROM payments WHERE sale_id = ? ORDER BY id',
    [$id]
);

$title = 'Invoice ' . ($sale['invoice_no'] ?? '');
$subtitle = 'Receipt, payment balance, customer rating and refund entry point.';

include dirname(__DIR__) . '/includes/header.php';
?>

<div class="toolbar">
    <a class="btn" href="receipt.php?id=<?= e($id) ?>" target="_blank">Print Receipt</a>
    <a class="btn secondary" href="refunds.php?sale_id=<?= e($id) ?>">Request Refund</a>
    <a class="btn light" href="sales.php">Sales List</a>
</div>

<section class="card">
    <div class="grid cols-3">
        <div>
            <strong>Customer</strong><br>
            <?= e($sale['customer'] ?? 'Walk-in') ?><br>
            <?= e($sale['customer_phone'] ?? '') ?>
        </div>

        <div>
            <strong>Invoice</strong><br>
            <?= e($sale['invoice_no'] ?? '') ?><br>
            <?= e($sale['sale_date'] ?? '') ?>
        </div>

        <div>
            <strong>Status</strong><br>
            <span class="badge green"><?= e($sale['status'] ?? '') ?></span>
        </div>
    </div>

    <?php if (!empty($sale['customer_id'])): ?>
        <h3>Customer Details</h3>
        <div class="grid cols-3">
            <div><strong>Customer No.</strong><br><?= e($sale['customer_no'] ?? '') ?></div>
            <div><strong>Gender</strong><br><?= e($sale['customer_gender'] ?? '') ?></div>
            <div><strong>Email</strong><br><?= e($sale['customer_email'] ?? '') ?></div>
            <div><strong>Address</strong><br><?= e($sale['customer_address'] ?? '') ?></div>
            <div><strong>Emergency Contact</strong><br><?= e($sale['customer_emergency_contact'] ?? '') ?></div>
            <div><strong>Preferences</strong><br><?= e($sale['customer_preferences'] ?? '') ?></div>
        </div>
    <?php endif; ?>

    <h3>Items Sold / Services Provided</h3>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Staff</th>
                    <th>Qty</th>
                    <th>Unit</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Refunded Qty</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!$saleItems): ?>
                    <tr><td colspan="8">No sale items found for this invoice.</td></tr>
                <?php endif; ?>

                <?php foreach ($saleItems as $it): ?>
                    <tr>
                        <td><?= e($it['item_type'] ?? '') ?></td>
                        <td><?= e($it['description'] ?? '') ?></td>
                        <td><?= e($it['staff'] ?? '') ?></td>
                        <td><?= e($it['quantity'] ?? 0) ?></td>
                        <td><?= money($it['unit_price'] ?? 0) ?></td>
                        <td><?= money($it['discount_amount'] ?? 0) ?></td>
                        <td><?= money($it['line_total'] ?? 0) ?></td>
                        <td><?= e($it['refunded_quantity'] ?? 0) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($usedProducts): ?>
        <h3>Products / Inventory Used</h3>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Movement</th>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Qty Used</th>
                        <th>Unit</th>
                        <th>Balance After</th>
                        <th>Notes</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($usedProducts as $p): ?>
                        <tr>
                            <td><?= e($p['movement_type'] ?? '') ?></td>
                            <td><?= e($p['product_name'] ?? '') ?></td>
                            <td><?= e($p['brand'] ?? '') ?></td>
                            <td><?= e($p['quantity_used'] ?? 0) ?></td>
                            <td><?= e($p['unit'] ?? '') ?></td>
                            <td><?= e($p['balance_after'] ?? 0) ?></td>
                            <td><?= e($p['notes'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <?php if ($continuations): ?>
        <h3>Planned Service Continuations</h3>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Due Date</th>
                        <th>Original Service</th>
                        <th>Continuation</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($continuations as $f): ?>
                        <tr>
                            <td><?= e($f['due_date'] ?? '') ?></td>
                            <td><?= e($f['service_name'] ?? '') ?></td>
                            <td><?= e($f['continuation_service'] ?? '') ?></td>
                            <td>
                                <span class="<?= e(continuation_badge($f['status'] ?? 'planned')) ?>">
                                    <?= e($f['status'] ?? 'planned') ?>
                                </span>
                            </td>
                            <td>
                                <a class="btn small secondary"
                                   href="continuations.php?status=all&from=<?= e($f['due_date'] ?? '') ?>&to=<?= e($f['due_date'] ?? '') ?>">
                                    Open
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <div class="totals" style="max-width:360px;margin-left:auto">
        <div>
            <span>Subtotal</span>
            <strong><?= money($sale['subtotal'] ?? 0) ?></strong>
        </div>

        <div>
            <span>Discount</span>
            <strong><?= money($sale['discount_amount'] ?? 0) ?></strong>
        </div>

        <div>
            <span>Tax</span>
            <strong><?= money($sale['tax_amount'] ?? 0) ?></strong>
        </div>

        <div class="grand">
            <span>Total</span>
            <strong><?= money($sale['total_amount'] ?? 0) ?></strong>
        </div>

        <div>
            <span>Paid</span>
            <strong><?= money($sale['paid_amount'] ?? 0) ?></strong>
        </div>

        <div>
            <span>Balance</span>
            <strong><?= money($sale['balance_amount'] ?? 0) ?></strong>
        </div>
    </div>
</section>

<div class="grid cols-2" style="margin-top:16px">
    <section class="card">
        <h2>Payments</h2>

        <table>
            <thead>
                <tr>
                    <th>Method</th>
                    <th>Amount</th>
                    <th>Reference</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($payments as $p): ?>
                    <tr>
                        <td><?= e($p['payment_method'] ?? '') ?></td>
                        <td><?= money($p['amount'] ?? 0) ?></td>
                        <td><?= e($p['reference_no'] ?? '') ?></td>
                        <td><?= e($p['payment_date'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ((float) ($sale['balance_amount'] ?? 0) > 0): ?>
            <h3>Collect Balance</h3>

            <form method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="_action" value="payment">

                <div class="form-grid">
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number"
                               step="0.01"
                               name="amount"
                               max="<?= e($sale['balance_amount'] ?? 0) ?>"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Method</label>
                        <select name="payment_method">
                            <?php foreach (payment_methods() as $m => $l): ?>
                                <option value="<?= e($m) ?>"><?= e($l) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Reference</label>
                        <input name="reference_no">
                    </div>

                    <div class="form-group">
                        <label>Gift Card Code</label>
                        <input name="gift_code">
                    </div>
                </div>

                <button class="btn">Save Payment</button>
            </form>
        <?php endif; ?>
    </section>

    <section class="card">
        <h2>Customer Rating</h2>

        <form method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_action" value="rating">

            <div class="form-grid">
                <div class="form-group">
                    <label>Rating 1–5</label>
                    <input type="number" min="1" max="5" name="rating" required>
                </div>

                <div class="form-group">
                    <label>Staff</label>
                    <select name="staff_id">
                        <option value="">General</option>
                        <?php foreach (staff_options() as $sid => $l): ?>
                            <option value="<?= e($sid) ?>"><?= e($l) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group full">
                    <label>Comments</label>
                    <textarea name="comments"></textarea>
                </div>
            </div>

            <button class="btn">Save Rating</button>
        </form>
    </section>
</div>

<?php include dirname(__DIR__) . '/includes/footer.php'; ?>