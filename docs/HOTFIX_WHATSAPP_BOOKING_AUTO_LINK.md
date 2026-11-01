# Hotfix: WhatsApp Booking Link Auto Network URL

This update copies the same WhatsApp redirect style used in the Bus Owner Control System:

1. Staff opens **Send Booking Link**.
2. Staff selects a customer or types a WhatsApp number.
3. The green button opens a PHP action first.
4. The PHP action logs the notification and redirects to `wa.me` with the booking message already filled.

The booking link no longer uses `localhost` when PHP can detect the computer/server network IP. This avoids manually replacing `localhost` with the IP address for same-network customer testing.

Files changed:

- `includes/functions.php`
- `modules/booking_link.php`
- `modules/settings.php`
- `database/seed.sql`
- `database/migrations/2026_08_04_whatsapp_booking_auto_link.sql`

For customers outside your salon Wi-Fi/network, host the system online or use a tunneling service. A local XAMPP computer cannot be reached from outside the network by WhatsApp link alone.
