<?php
/**
 * Stock-style reporting helpers for Salon & Spa system.
 * This file is intentionally self-contained and uses the existing PDO helpers.
 */
function spa_report_clean_int(mixed $value): string|int
{
    $v = filter_var($value, FILTER_VALIDATE_INT);
    return $v === false ? '' : (int)$v;
}

function spa_report_clean_float(mixed $value): string|float
{
    if ($value === '' || $value === null) return '';
    return is_numeric($value) ? (float)$value : '';
}

function spa_report_filters(): array
{
    $canAllBranches = can('branches.view_all');
    $branch = $canAllBranches ? spa_report_clean_int($_GET['branch_id'] ?? '') : (int)current_branch_id();

    $customer = spa_report_clean_int($_GET['customer_id'] ?? '');
    $saleId = spa_report_clean_int($_GET['sale_id'] ?? '');
    $itemFilter = trim((string)($_GET['item_filter'] ?? ''));
    if ($itemFilter !== '' && !preg_match('/^(service|product|package):\d+$/', $itemFilter)) {
        $itemFilter = '';
    }

    $customerType = $_GET['customer_type'] ?? 'all';
    if (!in_array($customerType, ['all', 'registered', 'walkin'], true)) $customerType = 'all';

    $groupBy = $_GET['group_by'] ?? 'daily';
    if (!in_array($groupBy, ['daily', 'monthly', 'yearly'], true)) $groupBy = 'daily';

    $sortBy = $_GET['sort_by'] ?? 'date_desc';
    if (!in_array($sortBy, ['date_desc', 'date_asc', 'total_desc', 'total_asc', 'customer_asc', 'branch_asc'], true)) $sortBy = 'date_desc';

    $limit = (string)($_GET['limit'] ?? '100');
    if (!in_array($limit, ['25', '50', '100', '200', '500', 'all'], true)) $limit = '100';

    $fromDate = trim((string)($_GET['from_date'] ?? ($_GET['from'] ?? '')));
    $toDate = trim((string)($_GET['to_date'] ?? ($_GET['to'] ?? '')));
    if ($fromDate !== '' && !valid_date($fromDate)) $fromDate = '';
    if ($toDate !== '' && !valid_date($toDate)) $toDate = '';

    return [
        'from_date' => $fromDate,
        'to_date' => $toDate,
        'branch_id' => $branch,
        'customer_id' => $customer,
        'sale_id' => $saleId,
        'item_filter' => $itemFilter,
        'search_customer' => trim((string)($_GET['search_customer'] ?? '')),
        'min_total' => spa_report_clean_float($_GET['min_total'] ?? ''),
        'max_total' => spa_report_clean_float($_GET['max_total'] ?? ''),
        'customer_type' => $customerType,
        'group_by' => $groupBy,
        'sort_by' => $sortBy,
        'limit' => $limit,
        'can_all_branches' => $canAllBranches,
    ];
}

function spa_report_sale_where(array $f): array
{
    $where = ' WHERE 1=1 ';
    $params = [];

    if ($f['sale_id'] !== '') {
        $where .= ' AND s.id = ? ';
        $params[] = (int)$f['sale_id'];
    }
    if ($f['from_date'] !== '') {
        $where .= ' AND DATE(s.sale_date) >= ? ';
        $params[] = $f['from_date'];
    }
    if ($f['to_date'] !== '') {
        $where .= ' AND DATE(s.sale_date) <= ? ';
        $params[] = $f['to_date'];
    }
    if ($f['branch_id'] !== '') {
        $where .= ' AND s.branch_id = ? ';
        $params[] = (int)$f['branch_id'];
    }
    if ($f['customer_id'] !== '') {
        $where .= ' AND s.customer_id = ? ';
        $params[] = (int)$f['customer_id'];
    }
    if ($f['item_filter'] !== '') {
        [$type, $id] = explode(':', $f['item_filter'], 2);
        $where .= ' AND EXISTS (SELECT 1 FROM sale_items si_filter WHERE si_filter.sale_id = s.id AND si_filter.item_type = ? AND si_filter.item_id = ?) ';
        $params[] = $type;
        $params[] = (int)$id;
    }
    if ($f['search_customer'] !== '') {
        $where .= ' AND (c.full_name LIKE ? OR c.phone LIKE ? OR c.email LIKE ? OR s.invoice_no LIKE ?) ';
        $term = '%' . $f['search_customer'] . '%';
        array_push($params, $term, $term, $term, $term);
    }
    if ($f['min_total'] !== '') {
        $where .= ' AND s.total_amount >= ? ';
        $params[] = (float)$f['min_total'];
    }
    if ($f['max_total'] !== '') {
        $where .= ' AND s.total_amount <= ? ';
        $params[] = (float)$f['max_total'];
    }
    if ($f['customer_type'] === 'registered') {
        $where .= ' AND s.customer_id IS NOT NULL ';
    }
    if ($f['customer_type'] === 'walkin') {
        $where .= ' AND s.customer_id IS NULL ';
    }
    $where .= ' AND s.status NOT IN ("cancelled") ';
    return [$where, $params];
}

function spa_report_order_sql(string $sortBy): string
{
    return match ($sortBy) {
        'date_asc' => 's.sale_date ASC',
        'total_desc' => 's.total_amount DESC',
        'total_asc' => 's.total_amount ASC',
        'customer_asc' => 'customer ASC',
        'branch_asc' => 'branch ASC',
        default => 's.sale_date DESC',
    };
}

function spa_report_group_format(string $groupBy): string
{
    return match ($groupBy) {
        'monthly' => '%Y-%m',
        'yearly' => '%Y',
        default => '%Y-%m-%d',
    };
}

function spa_report_master_data(array $f): array
{
    $branches = $f['can_all_branches']
        ? all('SELECT id, name FROM branches ORDER BY name ASC')
        : all('SELECT id, name FROM branches WHERE id=?', [(int)current_branch_id()]);

    $branchParams = [];
    $branchSql = '';
    if ($f['branch_id'] !== '') {
        $branchSql = ' WHERE branch_id = ? ';
        $branchParams[] = (int)$f['branch_id'];
    } elseif (!$f['can_all_branches']) {
        $branchSql = ' WHERE branch_id = ? ';
        $branchParams[] = (int)current_branch_id();
    }

    $customers = all('SELECT id, full_name, phone FROM customers ' . $branchSql . ' ORDER BY full_name ASC LIMIT 1000', $branchParams);

    $items = [];
    foreach (all('SELECT id, name FROM services ' . $branchSql . ' ORDER BY name ASC', $branchParams) as $r) {
        $items[] = ['value' => 'service:' . $r['id'], 'label' => $r['name'] . ' (Service)'];
    }
    foreach (all('SELECT id, name FROM products ' . $branchSql . ' ORDER BY name ASC', $branchParams) as $r) {
        $items[] = ['value' => 'product:' . $r['id'], 'label' => $r['name'] . ' (Product)'];
    }
    foreach (all('SELECT id, name FROM packages ' . $branchSql . ' ORDER BY name ASC', $branchParams) as $r) {
        $items[] = ['value' => 'package:' . $r['id'], 'label' => $r['name'] . ' (Package)'];
    }

    return compact('branches', 'customers', 'items');
}

function spa_report_data(array $f): array
{
    [$where, $params] = spa_report_sale_where($f);
    $orderBy = spa_report_order_sql($f['sort_by']);
    $limitSql = $f['limit'] === 'all' ? '' : ' LIMIT ' . (int)$f['limit'];

    $sales = all(
        "SELECT s.id, s.invoice_no, s.sale_date, COALESCE(c.full_name, 'Walk-in') AS customer,
                COALESCE(c.phone, '-') AS customer_phone, b.name AS branch,
                s.total_amount, s.paid_amount, s.balance_amount, s.status
         FROM sales s
         LEFT JOIN customers c ON c.id = s.customer_id
         JOIN branches b ON b.id = s.branch_id
         $where
         ORDER BY $orderBy
         $limitSql",
        $params
    );

    $groupFormat = spa_report_group_format($f['group_by']);
    $summary = all(
        "SELECT DATE_FORMAT(s.sale_date, '$groupFormat') AS period, COUNT(s.id) AS sales_count,
                COALESCE(SUM(s.total_amount),0) AS amount
         FROM sales s
         LEFT JOIN customers c ON c.id = s.customer_id
         JOIN branches b ON b.id = s.branch_id
         $where
         GROUP BY period
         ORDER BY period DESC",
        $params
    );

    $topProducts = all(
        "SELECT si.description AS name, COALESCE(SUM(si.quantity),0) AS qty,
                COALESCE(SUM(si.line_total),0) AS revenue
         FROM sale_items si
         JOIN sales s ON s.id = si.sale_id
         LEFT JOIN customers c ON c.id = s.customer_id
         JOIN branches b ON b.id = s.branch_id
         $where AND si.item_type = 'product'
         GROUP BY si.description
         ORDER BY qty DESC, revenue DESC
         LIMIT 10",
        $params
    );

    $topServices = all(
        "SELECT si.description AS name, COALESCE(SUM(si.quantity),0) AS qty,
                COALESCE(SUM(si.line_total),0) AS revenue
         FROM sale_items si
         JOIN sales s ON s.id = si.sale_id
         LEFT JOIN customers c ON c.id = s.customer_id
         JOIN branches b ON b.id = s.branch_id
         $where AND si.item_type IN ('service','package')
         GROUP BY si.description
         ORDER BY qty DESC, revenue DESC
         LIMIT 10",
        $params
    );

    $salesByBranch = all(
        "SELECT b.name, COUNT(s.id) AS sales_count, COALESCE(SUM(s.total_amount),0) AS total_sales
         FROM sales s
         LEFT JOIN customers c ON c.id = s.customer_id
         JOIN branches b ON b.id = s.branch_id
         $where
         GROUP BY b.id, b.name
         ORDER BY total_sales DESC",
        $params
    );

    $paymentsByMethod = all(
        "SELECT p.payment_method, COALESCE(SUM(p.amount),0) AS amount
         FROM payments p
         JOIN sales s ON s.id = p.sale_id
         LEFT JOIN customers c ON c.id = s.customer_id
         JOIN branches b ON b.id = s.branch_id
         $where
         GROUP BY p.payment_method
         ORDER BY amount DESC",
        $params
    );

    $revenue = (float)scalar(
        "SELECT COALESCE(SUM(s.total_amount),0)
         FROM sales s LEFT JOIN customers c ON c.id=s.customer_id JOIN branches b ON b.id=s.branch_id
         $where",
        $params
    );
    $paid = (float)scalar(
        "SELECT COALESCE(SUM(s.paid_amount),0)
         FROM sales s LEFT JOIN customers c ON c.id=s.customer_id JOIN branches b ON b.id=s.branch_id
         $where",
        $params
    );
    $balance = (float)scalar(
        "SELECT COALESCE(SUM(s.balance_amount),0)
         FROM sales s LEFT JOIN customers c ON c.id=s.customer_id JOIN branches b ON b.id=s.branch_id
         $where",
        $params
    );

    $expenseWhere = ' WHERE 1=1 ';
    $expenseParams = [];
    if ($f['from_date'] !== '') { $expenseWhere .= ' AND expense_date >= ? '; $expenseParams[] = $f['from_date']; }
    if ($f['to_date'] !== '') { $expenseWhere .= ' AND expense_date <= ? '; $expenseParams[] = $f['to_date']; }
    if ($f['branch_id'] !== '') { $expenseWhere .= ' AND branch_id = ? '; $expenseParams[] = (int)$f['branch_id']; }
    elseif (!$f['can_all_branches']) { $expenseWhere .= ' AND branch_id = ? '; $expenseParams[] = (int)current_branch_id(); }

    $expenses = (float)scalar("SELECT COALESCE(SUM(amount),0) FROM expenses $expenseWhere", $expenseParams);
    $expensesByCategory = all(
        "SELECT category, COALESCE(SUM(amount),0) AS amount
         FROM expenses $expenseWhere GROUP BY category ORDER BY amount DESC LIMIT 10",
        $expenseParams
    );

    $stockWhere = ' WHERE p.track_stock = 1 ';
    $stockParams = [];
    if ($f['branch_id'] !== '') { $stockWhere .= ' AND p.branch_id = ? '; $stockParams[] = (int)$f['branch_id']; }
    elseif (!$f['can_all_branches']) { $stockWhere .= ' AND p.branch_id = ? '; $stockParams[] = (int)current_branch_id(); }

    $lowStock = all(
        "SELECT p.name, p.brand, b.name AS branch, COALESCE(sl.quantity,0) AS qty, p.minimum_stock, p.expiry_date
         FROM products p
         JOIN branches b ON b.id = p.branch_id
         LEFT JOIN stock_levels sl ON sl.product_id = p.id AND sl.branch_id = p.branch_id
         $stockWhere AND COALESCE(sl.quantity,0) <= p.minimum_stock
         ORDER BY b.name, p.name
         LIMIT 20",
        $stockParams
    );

    $stockMovements = all(
        "SELECT sm.created_at, p.name AS product, b.name AS branch, sm.movement_type, sm.quantity, sm.balance_after, sm.reference_type, sm.notes
         FROM stock_movements sm
         JOIN products p ON p.id = sm.product_id
         JOIN branches b ON b.id = sm.branch_id
         WHERE 1=1 " .
         ($f['from_date'] !== '' ? ' AND DATE(sm.created_at) >= ? ' : '') .
         ($f['to_date'] !== '' ? ' AND DATE(sm.created_at) <= ? ' : '') .
         ($f['branch_id'] !== '' ? ' AND sm.branch_id = ? ' : (!$f['can_all_branches'] ? ' AND sm.branch_id = ? ' : '')) .
         " ORDER BY sm.created_at DESC LIMIT 20",
        array_values(array_filter([
            $f['from_date'] !== '' ? $f['from_date'] : null,
            $f['to_date'] !== '' ? $f['to_date'] : null,
            $f['branch_id'] !== '' ? (int)$f['branch_id'] : (!$f['can_all_branches'] ? (int)current_branch_id() : null),
        ], fn($v) => $v !== null))
    );

    $staffWhere = ' WHERE 1=1 ';
    $staffParams = [];
    if ($f['from_date'] !== '') { $staffWhere .= ' AND DATE(c.created_at) >= ? '; $staffParams[] = $f['from_date']; }
    if ($f['to_date'] !== '') { $staffWhere .= ' AND DATE(c.created_at) <= ? '; $staffParams[] = $f['to_date']; }
    if ($f['branch_id'] !== '') { $staffWhere .= ' AND st.branch_id = ? '; $staffParams[] = (int)$f['branch_id']; }
    elseif (!$f['can_all_branches']) { $staffWhere .= ' AND st.branch_id = ? '; $staffParams[] = (int)current_branch_id(); }

    $staffPerformance = all(
        "SELECT st.full_name, st.role_title, COUNT(DISTINCT c.sale_id) AS sales_count,
                COALESCE(SUM(c.base_amount),0) AS service_sales,
                COALESCE(SUM(c.commission_amount),0) AS commission
         FROM staff st
         LEFT JOIN commissions c ON c.staff_id = st.id
         $staffWhere
         GROUP BY st.id, st.full_name, st.role_title
         ORDER BY commission DESC, service_sales DESC
         LIMIT 20",
        $staffParams
    );

    $newCustomersWhere = ' WHERE 1=1 ';
    $newCustomerParams = [];
    if ($f['from_date'] !== '') { $newCustomersWhere .= ' AND DATE(created_at) >= ? '; $newCustomerParams[] = $f['from_date']; }
    if ($f['to_date'] !== '') { $newCustomersWhere .= ' AND DATE(created_at) <= ? '; $newCustomerParams[] = $f['to_date']; }
    if ($f['branch_id'] !== '') { $newCustomersWhere .= ' AND branch_id = ? '; $newCustomerParams[] = (int)$f['branch_id']; }
    elseif (!$f['can_all_branches']) { $newCustomersWhere .= ' AND branch_id = ? '; $newCustomerParams[] = (int)current_branch_id(); }
    $newCustomers = (int)scalar("SELECT COUNT(*) FROM customers $newCustomersWhere", $newCustomerParams);

    return [
        'sales' => $sales,
        'sales_count' => count($sales),
        'displayed_total' => array_sum(array_map(fn($r) => (float)$r['total_amount'], $sales)),
        'summary' => $summary,
        'top_products' => $topProducts,
        'top_services' => $topServices,
        'sales_by_branch' => $salesByBranch,
        'payments_by_method' => $paymentsByMethod,
        'expenses_by_category' => $expensesByCategory,
        'low_stock' => $lowStock,
        'stock_movements' => $stockMovements,
        'staff_performance' => $staffPerformance,
        'totals' => [
            'revenue' => $revenue,
            'paid' => $paid,
            'balance' => $balance,
            'expenses' => $expenses,
            'profit' => $revenue - $expenses,
            'new_customers' => $newCustomers,
        ],
    ];
}

function spa_report_current_query(array $overrides = []): string
{
    $q = $_GET;
    foreach ($overrides as $k => $v) {
        if ($v === null) unset($q[$k]); else $q[$k] = $v;
    }
    return http_build_query($q);
}
