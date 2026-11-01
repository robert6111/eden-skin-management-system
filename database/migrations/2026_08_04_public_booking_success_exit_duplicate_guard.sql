-- Public booking success-exit and database duplicate guard
-- Run this once only if you are updating an already installed database.

ALTER TABLE appointments
  ADD COLUMN IF NOT EXISTS public_booking_fingerprint VARCHAR(64) NULL AFTER appointment_no;

CREATE INDEX IF NOT EXISTS public_booking_fingerprint_idx
  ON appointments(public_booking_fingerprint);

CREATE TABLE IF NOT EXISTS public_booking_submissions (
 id INT AUTO_INCREMENT PRIMARY KEY,
 branch_id INT NOT NULL,
 submission_token VARCHAR(96) NOT NULL,
 booking_fingerprint VARCHAR(64) NOT NULL,
 customer_phone VARCHAR(40) NULL,
 appointment_id INT NULL,
 appointment_no VARCHAR(40) NULL,
 status ENUM('started','completed','failed') DEFAULT 'started',
 created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
 updated_at DATETIME NULL,
 UNIQUE KEY uniq_public_booking_token (submission_token),
 UNIQUE KEY uniq_public_booking_fingerprint (booking_fingerprint),
 INDEX idx_public_booking_branch (branch_id,created_at),
 FOREIGN KEY(branch_id) REFERENCES branches(id),
 FOREIGN KEY(appointment_id) REFERENCES appointments(id) ON DELETE SET NULL
) ENGINE=InnoDB;
