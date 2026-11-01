-- Customer service continuation / follow-up logic for recurring salon/spa services.
-- Run this once in phpMyAdmin for existing installations. Fresh installs already include it in schema.sql.

ALTER TABLE services ADD COLUMN IF NOT EXISTS continuation_required TINYINT(1) NOT NULL DEFAULT 0 AFTER status;
ALTER TABLE services ADD COLUMN IF NOT EXISTS continuation_after_days INT NOT NULL DEFAULT 0 AFTER continuation_required;
ALTER TABLE services ADD COLUMN IF NOT EXISTS continuation_service_id INT NULL AFTER continuation_after_days;
ALTER TABLE services ADD COLUMN IF NOT EXISTS continuation_message TEXT NULL AFTER continuation_service_id;

CREATE TABLE IF NOT EXISTS customer_service_continuations (
 id INT AUTO_INCREMENT PRIMARY KEY,
 branch_id INT NOT NULL,
 customer_id INT NOT NULL,
 sale_id INT NULL,
 sale_item_id INT NULL,
 service_id INT NOT NULL,
 continuation_service_id INT NULL,
 staff_id INT NULL,
 original_service_date DATE NOT NULL,
 due_date DATE NOT NULL,
 preferred_time TIME NULL,
 status ENUM('planned','reminded','booked','completed','cancelled','missed') DEFAULT 'planned',
 appointment_id INT NULL,
 reminder_sent_at DATETIME NULL,
 notes TEXT,
 created_by INT NULL,
 created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 updated_at DATETIME NULL,
 UNIQUE KEY uniq_continuation_sale_service (sale_item_id, service_id),
 INDEX continuation_due_idx (branch_id,due_date,status),
 INDEX continuation_customer_idx (customer_id,due_date),
 FOREIGN KEY(branch_id) REFERENCES branches(id),
 FOREIGN KEY(customer_id) REFERENCES customers(id) ON DELETE CASCADE,
 FOREIGN KEY(sale_id) REFERENCES sales(id) ON DELETE SET NULL,
 FOREIGN KEY(sale_item_id) REFERENCES sale_items(id) ON DELETE SET NULL,
 FOREIGN KEY(service_id) REFERENCES services(id),
 FOREIGN KEY(continuation_service_id) REFERENCES services(id) ON DELETE SET NULL,
 FOREIGN KEY(staff_id) REFERENCES staff(id) ON DELETE SET NULL,
 FOREIGN KEY(appointment_id) REFERENCES appointments(id) ON DELETE SET NULL,
 FOREIGN KEY(created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

UPDATE services SET continuation_required=1, continuation_after_days=14, continuation_message='Please come back after 14 days for continuation/review.'
WHERE continuation_required=0 AND branch_id IS NOT NULL AND name IN ('Hair Treatment','Facial');
UPDATE services SET continuation_required=1, continuation_after_days=21, continuation_message='Please come back after 21 days for maintenance/refill.'
WHERE continuation_required=0 AND branch_id IS NOT NULL AND name='Gel Nails';
