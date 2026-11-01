SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS businesses (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(150) NOT NULL,
 phone VARCHAR(30), email VARCHAR(120), address VARCHAR(255), tin VARCHAR(50), vrn VARCHAR(50), logo VARCHAR(255),
 currency VARCHAR(10) DEFAULT 'TZS', timezone VARCHAR(60) DEFAULT 'Africa/Dar_es_Salaam', created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS branches (
 id INT AUTO_INCREMENT PRIMARY KEY, business_id INT NOT NULL, name VARCHAR(120) NOT NULL, code VARCHAR(20) NOT NULL UNIQUE,
 phone VARCHAR(30), email VARCHAR(120), address VARCHAR(255), opening_time TIME DEFAULT '08:00:00', closing_time TIME DEFAULT '20:00:00', status ENUM('active','inactive') DEFAULT 'active', created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY (business_id) REFERENCES businesses(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS roles (
 id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(80) NOT NULL UNIQUE, description VARCHAR(255), is_system TINYINT(1) DEFAULT 0, created_at DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS permissions (
 id INT AUTO_INCREMENT PRIMARY KEY, code VARCHAR(100) NOT NULL UNIQUE, name VARCHAR(120) NOT NULL, module VARCHAR(80) NOT NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS role_permissions (
 role_id INT NOT NULL, permission_id INT NOT NULL, PRIMARY KEY(role_id,permission_id),
 FOREIGN KEY(role_id) REFERENCES roles(id) ON DELETE CASCADE, FOREIGN KEY(permission_id) REFERENCES permissions(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS staff (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, employee_no VARCHAR(30) UNIQUE, photo VARCHAR(255), full_name VARCHAR(150) NOT NULL,
 phone VARCHAR(30), email VARCHAR(120), gender ENUM('Male','Female','Other') DEFAULT 'Female', date_of_birth DATE, address VARCHAR(255), role_title VARCHAR(100),
 salary DECIMAL(14,2) DEFAULT 0, default_commission_type ENUM('percentage','fixed') DEFAULT 'percentage', default_commission_value DECIMAL(10,2) DEFAULT 0,
 employment_date DATE, emergency_contact VARCHAR(120), status ENUM('active','inactive','terminated') DEFAULT 'active', created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME NULL,
 FOREIGN KEY(branch_id) REFERENCES branches(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS users (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, staff_id INT NULL, role_id INT NOT NULL, username VARCHAR(80) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL, status ENUM('active','inactive','locked') DEFAULT 'active', last_login_at DATETIME NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE SET NULL, FOREIGN KEY(role_id) REFERENCES roles(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS attendance (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, staff_id INT NOT NULL, attendance_date DATE NOT NULL, clock_in DATETIME NULL, clock_out DATETIME NULL,
 status ENUM('present','late','absent','leave','off') DEFAULT 'present', notes VARCHAR(255), created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY uniq_staff_date(staff_id,attendance_date), FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(staff_id) REFERENCES staff(id), FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS leave_requests (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, staff_id INT NOT NULL, leave_type VARCHAR(60), start_date DATE, end_date DATE, reason TEXT,
 status ENUM('pending','approved','rejected') DEFAULT 'pending', approved_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(staff_id) REFERENCES staff(id), FOREIGN KEY(approved_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS customers (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, customer_no VARCHAR(30) UNIQUE, full_name VARCHAR(150) NOT NULL, phone VARCHAR(30), gender ENUM('Male','Female','Other') NULL,
 date_of_birth DATE NULL, email VARCHAR(120), address VARCHAR(255), emergency_contact VARCHAR(120), preferences TEXT, status ENUM('active','inactive') DEFAULT 'active', created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME NULL,
 INDEX(phone), FOREIGN KEY(branch_id) REFERENCES branches(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS customer_notes (
 id INT AUTO_INCREMENT PRIMARY KEY, customer_id INT NOT NULL, user_id INT NULL, note TEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE CASCADE, FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS visits (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, customer_id INT NULL, visit_date DATETIME DEFAULT CURRENT_TIMESTAMP, visit_type ENUM('appointment','walk_in') DEFAULT 'walk_in', status ENUM('waiting','in_service','completed','cancelled') DEFAULT 'waiting', notes TEXT,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS service_categories (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255), status ENUM('active','inactive') DEFAULT 'active', created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS services (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, category_id INT NULL, name VARCHAR(150) NOT NULL, description TEXT, duration_minutes INT DEFAULT 30,
 price DECIMAL(14,2) NOT NULL DEFAULT 0, commission_type ENUM('none','percentage','fixed') DEFAULT 'percentage', commission_value DECIMAL(10,2) DEFAULT 0,
 status ENUM('active','inactive') DEFAULT 'active', continuation_required TINYINT(1) NOT NULL DEFAULT 0, continuation_after_days INT NOT NULL DEFAULT 0, continuation_service_id INT NULL, continuation_message TEXT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME NULL,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(category_id) REFERENCES service_categories(id) ON DELETE SET NULL, FOREIGN KEY(continuation_service_id) REFERENCES services(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS product_categories (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(255), status ENUM('active','inactive') DEFAULT 'active',
 FOREIGN KEY(branch_id) REFERENCES branches(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS suppliers (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, name VARCHAR(150) NOT NULL, phone VARCHAR(30), email VARCHAR(120), address VARCHAR(255), opening_balance DECIMAL(14,2) DEFAULT 0, status ENUM('active','inactive') DEFAULT 'active', created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS products (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, category_id INT NULL, supplier_id INT NULL, barcode VARCHAR(80), name VARCHAR(150) NOT NULL, brand VARCHAR(100), unit VARCHAR(30) DEFAULT 'piece',
 buying_price DECIMAL(14,2) DEFAULT 0, selling_price DECIMAL(14,2) DEFAULT 0, minimum_stock DECIMAL(12,2) DEFAULT 0, expiry_date DATE NULL, track_stock TINYINT(1) DEFAULT 1, status ENUM('active','inactive') DEFAULT 'active', created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY uniq_branch_barcode(branch_id,barcode), FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(category_id) REFERENCES product_categories(id) ON DELETE SET NULL, FOREIGN KEY(supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS stock_levels (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, product_id INT NOT NULL, quantity DECIMAL(12,2) DEFAULT 0, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 UNIQUE KEY uniq_branch_product(branch_id,product_id), FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS service_products (
 service_id INT NOT NULL, product_id INT NOT NULL, quantity_used DECIMAL(12,3) NOT NULL DEFAULT 1,
 PRIMARY KEY(service_id,product_id), FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE CASCADE, FOREIGN KEY(product_id) REFERENCES products(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS packages (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, name VARCHAR(150) NOT NULL, description TEXT, regular_price DECIMAL(14,2) DEFAULT 0, package_price DECIMAL(14,2) NOT NULL,
 validity_days INT DEFAULT 0, status ENUM('active','inactive') DEFAULT 'active', created_at DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(branch_id) REFERENCES branches(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS package_services (
 package_id INT NOT NULL, service_id INT NOT NULL, quantity INT DEFAULT 1, PRIMARY KEY(package_id,service_id),
 FOREIGN KEY(package_id) REFERENCES packages(id) ON DELETE CASCADE, FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS appointments (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, customer_id INT NULL, appointment_no VARCHAR(40) UNIQUE, public_booking_fingerprint VARCHAR(64) NULL, appointment_date DATE NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL,
 staff_id INT NULL, status ENUM('booked','confirmed','checked_in','in_progress','completed','cancelled','no_show') DEFAULT 'booked', source ENUM('phone','walk_in','whatsapp','website','other') DEFAULT 'phone', notes TEXT, created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 INDEX appointment_lookup(branch_id,appointment_date,staff_id), INDEX public_booking_fingerprint_idx(public_booking_fingerprint), FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE SET NULL, FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE SET NULL, FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS appointment_services (
 id INT AUTO_INCREMENT PRIMARY KEY, appointment_id INT NOT NULL, service_id INT NOT NULL, price DECIMAL(14,2) NOT NULL, duration_minutes INT NOT NULL, staff_id INT NULL,
 FOREIGN KEY(appointment_id) REFERENCES appointments(id) ON DELETE CASCADE, FOREIGN KEY(service_id) REFERENCES services(id), FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS public_booking_submissions (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, submission_token VARCHAR(96) NOT NULL, booking_fingerprint VARCHAR(64) NOT NULL, customer_phone VARCHAR(40) NULL, appointment_id INT NULL, appointment_no VARCHAR(40) NULL, status ENUM('started','completed','failed') DEFAULT 'started', created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME NULL,
 UNIQUE KEY uniq_public_booking_token(submission_token), UNIQUE KEY uniq_public_booking_fingerprint(booking_fingerprint), INDEX idx_public_booking_branch(branch_id,created_at),
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(appointment_id) REFERENCES appointments(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS queues (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, visit_id INT NULL, appointment_id INT NULL, customer_id INT NULL, queue_date DATE NOT NULL, queue_number INT NOT NULL, service_id INT NULL, staff_id INT NULL,
 status ENUM('waiting','called','in_service','completed','cancelled','no_show') DEFAULT 'waiting', checked_in_at DATETIME DEFAULT CURRENT_TIMESTAMP, called_at DATETIME NULL, service_started_at DATETIME NULL, completed_at DATETIME NULL, notes VARCHAR(255),
 UNIQUE KEY uniq_queue(branch_id,queue_date,queue_number), FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(visit_id) REFERENCES visits(id) ON DELETE SET NULL, FOREIGN KEY(appointment_id) REFERENCES appointments(id) ON DELETE SET NULL, FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE SET NULL, FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE SET NULL, FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS memberships (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, name VARCHAR(100) NOT NULL, price DECIMAL(14,2) DEFAULT 0, duration_days INT DEFAULT 365, discount_percent DECIMAL(5,2) DEFAULT 0, priority_booking TINYINT(1) DEFAULT 0, free_services_text TEXT, birthday_gift VARCHAR(255), status ENUM('active','inactive') DEFAULT 'active', FOREIGN KEY(branch_id) REFERENCES branches(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS customer_memberships (
 id INT AUTO_INCREMENT PRIMARY KEY, customer_id INT NOT NULL, membership_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, amount_paid DECIMAL(14,2) DEFAULT 0, status ENUM('active','expired','cancelled') DEFAULT 'active', created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(customer_id) REFERENCES customers(id), FOREIGN KEY(membership_id) REFERENCES memberships(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS loyalty_accounts (
 id INT AUTO_INCREMENT PRIMARY KEY, customer_id INT NOT NULL UNIQUE, points_balance INT DEFAULT 0, lifetime_points INT DEFAULT 0, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS loyalty_transactions (
 id INT AUTO_INCREMENT PRIMARY KEY, account_id INT NOT NULL, sale_id INT NULL, transaction_type ENUM('earn','redeem','adjustment','refund') NOT NULL, points INT NOT NULL, description VARCHAR(255), created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(account_id) REFERENCES loyalty_accounts(id), FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS gift_cards (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, code VARCHAR(40) NOT NULL UNIQUE, customer_id INT NULL, initial_balance DECIMAL(14,2) NOT NULL, current_balance DECIMAL(14,2) NOT NULL, expiry_date DATE NULL, status ENUM('active','used','expired','cancelled') DEFAULT 'active', created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS gift_card_transactions (
 id INT AUTO_INCREMENT PRIMARY KEY, gift_card_id INT NOT NULL, sale_id INT NULL, amount DECIMAL(14,2) NOT NULL, type ENUM('issue','redeem','refund','adjustment') NOT NULL, created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(gift_card_id) REFERENCES gift_cards(id), FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS promotions (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, name VARCHAR(150) NOT NULL, code VARCHAR(40), discount_type ENUM('percentage','fixed','bogo') DEFAULT 'percentage', discount_value DECIMAL(14,2) DEFAULT 0, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL,
 day_of_week VARCHAR(50), start_time TIME NULL, end_time TIME NULL, min_spend DECIMAL(14,2) DEFAULT 0, customer_scope ENUM('all','specific','members','new','returning') DEFAULT 'all', status ENUM('active','inactive') DEFAULT 'active', FOREIGN KEY(branch_id) REFERENCES branches(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS promotion_services (
 promotion_id INT NOT NULL, service_id INT NOT NULL, PRIMARY KEY(promotion_id,service_id), FOREIGN KEY(promotion_id) REFERENCES promotions(id) ON DELETE CASCADE, FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS promotion_customers (
 promotion_id INT NOT NULL, customer_id INT NOT NULL, PRIMARY KEY(promotion_id,customer_id), FOREIGN KEY(promotion_id) REFERENCES promotions(id) ON DELETE CASCADE, FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS purchases (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, purchase_no VARCHAR(40) UNIQUE, supplier_id INT NULL, invoice_number VARCHAR(80), purchase_date DATE NOT NULL, subtotal DECIMAL(14,2) DEFAULT 0, paid_amount DECIMAL(14,2) DEFAULT 0, payment_status ENUM('unpaid','partial','paid') DEFAULT 'unpaid', status ENUM('draft','received','cancelled') DEFAULT 'received', received_by INT NULL, notes TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(supplier_id) REFERENCES suppliers(id) ON DELETE SET NULL, FOREIGN KEY(received_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS purchase_items (
 id INT AUTO_INCREMENT PRIMARY KEY, purchase_id INT NOT NULL, product_id INT NOT NULL, quantity DECIMAL(12,2) NOT NULL, unit_cost DECIMAL(14,2) NOT NULL, line_total DECIMAL(14,2) NOT NULL,
 FOREIGN KEY(purchase_id) REFERENCES purchases(id) ON DELETE CASCADE, FOREIGN KEY(product_id) REFERENCES products(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS stock_movements (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, product_id INT NOT NULL, movement_type ENUM('opening','purchase','sale','service_use','adjustment','transfer_in','transfer_out','refund','internal_use') NOT NULL, quantity DECIMAL(12,3) NOT NULL, balance_after DECIMAL(12,3) NOT NULL, reference_type VARCHAR(50), reference_id INT NULL, notes VARCHAR(255), created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(product_id) REFERENCES products(id), FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS stock_adjustments (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, adjustment_no VARCHAR(40) UNIQUE, reason ENUM('damage','expired','lost','correction','internal_use','opening') NOT NULL, notes TEXT, created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS stock_adjustment_items (
 id INT AUTO_INCREMENT PRIMARY KEY, adjustment_id INT NOT NULL, product_id INT NOT NULL, quantity_change DECIMAL(12,3) NOT NULL, FOREIGN KEY(adjustment_id) REFERENCES stock_adjustments(id) ON DELETE CASCADE, FOREIGN KEY(product_id) REFERENCES products(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS stock_transfers (
 id INT AUTO_INCREMENT PRIMARY KEY, transfer_no VARCHAR(40) UNIQUE, from_branch_id INT NOT NULL, to_branch_id INT NOT NULL, status ENUM('draft','sent','received','cancelled') DEFAULT 'received', transfer_date DATE NOT NULL, notes TEXT, created_by INT NULL, received_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(from_branch_id) REFERENCES branches(id), FOREIGN KEY(to_branch_id) REFERENCES branches(id), FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL, FOREIGN KEY(received_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS stock_transfer_items (
 id INT AUTO_INCREMENT PRIMARY KEY, transfer_id INT NOT NULL, product_id INT NOT NULL, quantity DECIMAL(12,3) NOT NULL, FOREIGN KEY(transfer_id) REFERENCES stock_transfers(id) ON DELETE CASCADE, FOREIGN KEY(product_id) REFERENCES products(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS sales (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, invoice_no VARCHAR(40) NOT NULL UNIQUE, customer_id INT NULL, appointment_id INT NULL, queue_id INT NULL, sale_date DATETIME DEFAULT CURRENT_TIMESTAMP,
 subtotal DECIMAL(14,2) DEFAULT 0, discount_amount DECIMAL(14,2) DEFAULT 0, tax_amount DECIMAL(14,2) DEFAULT 0, total_amount DECIMAL(14,2) DEFAULT 0, paid_amount DECIMAL(14,2) DEFAULT 0, balance_amount DECIMAL(14,2) DEFAULT 0,
 status ENUM('draft','partial','paid','refunded','partially_refunded','cancelled') DEFAULT 'paid', promotion_id INT NULL, membership_discount DECIMAL(14,2) DEFAULT 0, loyalty_points_redeemed INT DEFAULT 0, notes TEXT, created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 INDEX sale_date_idx(branch_id,sale_date), FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE SET NULL, FOREIGN KEY(appointment_id) REFERENCES appointments(id) ON DELETE SET NULL, FOREIGN KEY(queue_id) REFERENCES queues(id) ON DELETE SET NULL, FOREIGN KEY(promotion_id) REFERENCES promotions(id) ON DELETE SET NULL, FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS sale_items (
 id INT AUTO_INCREMENT PRIMARY KEY, sale_id INT NOT NULL, item_type ENUM('service','product','package') NOT NULL, item_id INT NOT NULL, description VARCHAR(180) NOT NULL, staff_id INT NULL, quantity DECIMAL(12,2) DEFAULT 1, unit_price DECIMAL(14,2) NOT NULL, discount_amount DECIMAL(14,2) DEFAULT 0, line_total DECIMAL(14,2) NOT NULL, refunded_quantity DECIMAL(12,2) DEFAULT 0,
 FOREIGN KEY(sale_id) REFERENCES sales(id) ON DELETE CASCADE, FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS customer_service_continuations (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, customer_id INT NOT NULL, sale_id INT NULL, sale_item_id INT NULL, service_id INT NOT NULL, continuation_service_id INT NULL, staff_id INT NULL,
 original_service_date DATE NOT NULL, due_date DATE NOT NULL, preferred_time TIME NULL, status ENUM('planned','reminded','booked','completed','cancelled','missed') DEFAULT 'planned', appointment_id INT NULL, reminder_sent_at DATETIME NULL, notes TEXT, created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME NULL,
 UNIQUE KEY uniq_continuation_sale_service (sale_item_id, service_id), INDEX continuation_due_idx (branch_id,due_date,status), INDEX continuation_customer_idx (customer_id,due_date),
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE CASCADE, FOREIGN KEY(sale_id) REFERENCES sales(id) ON DELETE SET NULL, FOREIGN KEY(sale_item_id) REFERENCES sale_items(id) ON DELETE SET NULL, FOREIGN KEY(service_id) REFERENCES services(id), FOREIGN KEY(continuation_service_id) REFERENCES services(id) ON DELETE SET NULL, FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE SET NULL, FOREIGN KEY(appointment_id) REFERENCES appointments(id) ON DELETE SET NULL, FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS payments (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, sale_id INT NOT NULL, payment_method ENUM('cash','mpesa','airtel_money','tigo_pesa','halopesa','bank','card','gift_card','other') NOT NULL, amount DECIMAL(14,2) NOT NULL, reference_no VARCHAR(100), gift_card_id INT NULL, received_by INT NULL, payment_date DATETIME DEFAULT CURRENT_TIMESTAMP, notes VARCHAR(255),
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(sale_id) REFERENCES sales(id), FOREIGN KEY(gift_card_id) REFERENCES gift_cards(id) ON DELETE SET NULL, FOREIGN KEY(received_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS expenses (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, expense_date DATE NOT NULL, category VARCHAR(100) NOT NULL, description VARCHAR(255), amount DECIMAL(14,2) NOT NULL, payment_method VARCHAR(50), reference_no VARCHAR(100), attachment VARCHAR(255), created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS commission_rules (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, staff_id INT NULL, service_id INT NULL, commission_type ENUM('percentage','fixed') NOT NULL, commission_value DECIMAL(10,2) NOT NULL, status ENUM('active','inactive') DEFAULT 'active',
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE CASCADE, FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE CASCADE
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS commissions (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, sale_id INT NOT NULL, sale_item_id INT NOT NULL, staff_id INT NOT NULL, service_id INT NULL, base_amount DECIMAL(14,2) NOT NULL, commission_type ENUM('percentage','fixed') NOT NULL, commission_value DECIMAL(10,2) NOT NULL, commission_amount DECIMAL(14,2) NOT NULL, status ENUM('unpaid','included','paid','reversed') DEFAULT 'unpaid', created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(sale_id) REFERENCES sales(id), FOREIGN KEY(sale_item_id) REFERENCES sale_items(id), FOREIGN KEY(staff_id) REFERENCES staff(id), FOREIGN KEY(service_id) REFERENCES services(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS payroll_runs (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, period_start DATE NOT NULL, period_end DATE NOT NULL, status ENUM('draft','approved','paid') DEFAULT 'draft', approved_by INT NULL, paid_at DATETIME NULL, notes TEXT, created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(approved_by) REFERENCES users(id) ON DELETE SET NULL, FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS payroll_items (
 id INT AUTO_INCREMENT PRIMARY KEY, payroll_run_id INT NOT NULL, staff_id INT NOT NULL, basic_salary DECIMAL(14,2) DEFAULT 0, commission_amount DECIMAL(14,2) DEFAULT 0, bonus DECIMAL(14,2) DEFAULT 0, deductions DECIMAL(14,2) DEFAULT 0, advance_amount DECIMAL(14,2) DEFAULT 0, net_salary DECIMAL(14,2) DEFAULT 0, payment_method VARCHAR(50), payment_reference VARCHAR(100),
 FOREIGN KEY(payroll_run_id) REFERENCES payroll_runs(id) ON DELETE CASCADE, FOREIGN KEY(staff_id) REFERENCES staff(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS equipment (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, asset_no VARCHAR(40) UNIQUE, name VARCHAR(150) NOT NULL, category VARCHAR(100), purchase_date DATE NULL, purchase_cost DECIMAL(14,2) DEFAULT 0, warranty_expiry DATE NULL, next_maintenance_date DATE NULL, location VARCHAR(100), status ENUM('working','maintenance','broken','retired') DEFAULT 'working', notes TEXT,
 FOREIGN KEY(branch_id) REFERENCES branches(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS maintenance_logs (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, equipment_id INT NOT NULL, issue TEXT NOT NULL, technician VARCHAR(150), cost DECIMAL(14,2) DEFAULT 0, reported_date DATE NOT NULL, completion_date DATE NULL, next_due_date DATE NULL, status ENUM('reported','in_progress','completed') DEFAULT 'reported', notes TEXT, created_by INT NULL,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(equipment_id) REFERENCES equipment(id), FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS refunds (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, refund_no VARCHAR(40) UNIQUE, sale_id INT NOT NULL, refund_type ENUM('partial','full') DEFAULT 'partial', requested_amount DECIMAL(14,2) NOT NULL, approved_amount DECIMAL(14,2) DEFAULT 0, reason TEXT NOT NULL, status ENUM('pending','approved','rejected','completed') DEFAULT 'pending', payment_method VARCHAR(50), approved_by INT NULL, requested_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, completed_at DATETIME NULL,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(sale_id) REFERENCES sales(id), FOREIGN KEY(approved_by) REFERENCES users(id) ON DELETE SET NULL, FOREIGN KEY(requested_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS refund_items (
 id INT AUTO_INCREMENT PRIMARY KEY, refund_id INT NOT NULL, sale_item_id INT NOT NULL, quantity DECIMAL(12,2) NOT NULL, amount DECIMAL(14,2) NOT NULL, restock TINYINT(1) DEFAULT 0, FOREIGN KEY(refund_id) REFERENCES refunds(id) ON DELETE CASCADE, FOREIGN KEY(sale_item_id) REFERENCES sale_items(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS notifications (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, customer_id INT NULL, type ENUM('sms','whatsapp','email','system') DEFAULT 'system', recipient VARCHAR(150), subject VARCHAR(180), message TEXT NOT NULL, status ENUM('queued','sent','failed','cancelled') DEFAULT 'queued', scheduled_at DATETIME NULL, sent_at DATETIME NULL, provider_response TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS message_templates (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, name VARCHAR(120) NOT NULL, event_key VARCHAR(80), channel ENUM('sms','whatsapp','email') DEFAULT 'sms', subject VARCHAR(180), body TEXT NOT NULL, status ENUM('active','inactive') DEFAULT 'active', FOREIGN KEY(branch_id) REFERENCES branches(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS customer_ratings (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, customer_id INT NULL, sale_id INT NULL, staff_id INT NULL, rating TINYINT NOT NULL, comments TEXT, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE SET NULL, FOREIGN KEY(sale_id) REFERENCES sales(id) ON DELETE SET NULL, FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS documents (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, entity_type ENUM('staff','supplier','equipment','purchase','expense','customer','other') NOT NULL, entity_id INT NULL, title VARCHAR(180) NOT NULL, file_path VARCHAR(255) NOT NULL, original_name VARCHAR(255), mime_type VARCHAR(100), uploaded_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(uploaded_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS audit_logs (
 id BIGINT AUTO_INCREMENT PRIMARY KEY, user_id INT NULL, branch_id INT NULL, action VARCHAR(100) NOT NULL, entity_type VARCHAR(80), entity_id INT NULL, details JSON NULL, ip_address VARCHAR(45), user_agent VARCHAR(255), created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 INDEX audit_date(created_at), FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL, FOREIGN KEY(branch_id) REFERENCES branches(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS system_activities (
 id BIGINT AUTO_INCREMENT PRIMARY KEY, branch_id INT NULL, user_id INT NULL, activity_type VARCHAR(50), message VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 INDEX activity_date(branch_id,created_at), FOREIGN KEY(branch_id) REFERENCES branches(id) ON DELETE SET NULL, FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS settings (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NULL, setting_key VARCHAR(100) NOT NULL, setting_value TEXT, setting_group VARCHAR(80) DEFAULT 'general', updated_by INT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 UNIQUE KEY uniq_setting(branch_id,setting_key), FOREIGN KEY(branch_id) REFERENCES branches(id) ON DELETE CASCADE, FOREIGN KEY(updated_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS backups (
 id INT AUTO_INCREMENT PRIMARY KEY, file_name VARCHAR(255) NOT NULL, file_size BIGINT DEFAULT 0, backup_type ENUM('manual','automatic') DEFAULT 'manual', status ENUM('completed','failed') DEFAULT 'completed', notes TEXT, created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS supplier_payments (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, supplier_id INT NOT NULL, purchase_id INT NULL, amount DECIMAL(14,2) NOT NULL, payment_method VARCHAR(50), reference_no VARCHAR(100), payment_date DATE NOT NULL, created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(supplier_id) REFERENCES suppliers(id), FOREIGN KEY(purchase_id) REFERENCES purchases(id) ON DELETE SET NULL, FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS cash_sessions (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, user_id INT NOT NULL, opened_at DATETIME NOT NULL, opening_float DECIMAL(14,2) DEFAULT 0, closed_at DATETIME NULL, expected_cash DECIMAL(14,2) DEFAULT 0, actual_cash DECIMAL(14,2) DEFAULT 0, variance DECIMAL(14,2) DEFAULT 0, status ENUM('open','closed') DEFAULT 'open', notes TEXT,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(user_id) REFERENCES users(id)
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS stock_counts (
 id INT AUTO_INCREMENT PRIMARY KEY, branch_id INT NOT NULL, count_no VARCHAR(40) UNIQUE, count_date DATE NOT NULL, status ENUM('draft','completed') DEFAULT 'draft', notes TEXT, created_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(branch_id) REFERENCES branches(id), FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS stock_count_items (
 id INT AUTO_INCREMENT PRIMARY KEY, stock_count_id INT NOT NULL, product_id INT NOT NULL, system_quantity DECIMAL(12,3) DEFAULT 0, counted_quantity DECIMAL(12,3) DEFAULT 0, variance DECIMAL(12,3) DEFAULT 0,
 FOREIGN KEY(stock_count_id) REFERENCES stock_counts(id) ON DELETE CASCADE, FOREIGN KEY(product_id) REFERENCES products(id)
) ENGINE=InnoDB;
SET FOREIGN_KEY_CHECKS=1;
