# Hotfix: Refresh Duplicate Send Protection

Date: 2026-08-04

This update fixes the behaviour where refreshing the WhatsApp booking sender page could resend/log the same booking-link message again.

## Changed files

- `modules/booking_link.php`
- `public_booking.php`
- `assets/js/app.js`

## What changed

1. WhatsApp booking sending now uses `POST` and then a `303` redirect to WhatsApp.
   - The old `GET?action=send_whatsapp` URL is no longer used for sending.
   - Refreshing the booking-link page will not resend the message.
   - If an old action URL is refreshed, the system redirects back and shows a warning instead of sending again.

2. Public customer booking form now uses POST-Redirect-GET after successful booking.
   - Refreshing after a successful public booking will not create the appointment again.
   - Error messages preserve typed values but still redirect safely.

3. A global front-end guard was added to reduce accidental double-click duplicates.
   - Submit buttons temporarily disable while the request is processing.
   - Forms that open a new tab, like WhatsApp sending, automatically re-enable after the tab opens.

## Database migration

No database migration is required.
