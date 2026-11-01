# Hotfix: Queue, Services/Appointments, and Customer Booking Link

This package fixes the queue error and the appointment-service saving error from the previous ZIP, and adds a public customer booking link.

## What was fixed

1. Queue module now uses the correct database fields:
   - `checked_in_at`
   - `called_at`
   - `service_started_at`
   - `completed_at`

2. Queue records now support:
   - selected service
   - appointment check-in link
   - No Show status

3. Appointment services now save required service price and duration correctly.

4. A public customer booking page was added:
   - Staff can open **Appointments → Customer Booking Link**
   - Copy the link or send it by WhatsApp
   - Customers can book without logging in
   - Bookings appear in the Appointments module with source `website`

## If you already installed the previous ZIP

Copy these new files over your existing system folder, then run this SQL once in phpMyAdmin:

`database/migrations/2026_08_04_fix_queue_and_public_booking.sql`

## If this is a fresh installation

You do not need to run the migration. Just install normally using `install.php`.

## Localhost note

If your booking link shows `localhost`, it will only work on the same computer. For customers to book from phones, host the system online or replace `localhost` with the computer/server IP address on the same Wi‑Fi network.
