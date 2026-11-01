-- Prevent public booking duplicates when the browser refreshes/retries old form data.
-- The updated public_booking.php can also add this column automatically, but this migration is safe to run manually in phpMyAdmin.
ALTER TABLE appointments ADD COLUMN IF NOT EXISTS public_booking_fingerprint VARCHAR(64) NULL AFTER appointment_no;
ALTER TABLE appointments ADD INDEX IF NOT EXISTS public_booking_fingerprint_idx(public_booking_fingerprint);
