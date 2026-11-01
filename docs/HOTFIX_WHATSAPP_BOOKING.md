# Hotfix: Send Booking Link to Customer WhatsApp

This update modifies the booking feature without changing the rest of the system.

## Added

1. **Appointments → Customer Booking Link** now has a second section called **Send Booking Link to Customer WhatsApp**.
2. Staff can:
   - select an existing customer, or
   - type a WhatsApp number manually.
3. The system opens WhatsApp with the booking link already written and addressed to that customer number.
4. Appointment confirmations created by staff are saved in the Notifications outbox as **WhatsApp** messages.
5. Public website bookings also create **WhatsApp** confirmation notifications.
6. The Notifications module now shows an **Open WhatsApp** button for WhatsApp messages.

## Important note

This uses WhatsApp click-to-chat, which works immediately on Windows/XAMPP without paid setup. Fully automatic WhatsApp sending requires a WhatsApp Business API provider. The outbox remains provider-ready for that future integration.

## Files changed

- `modules/booking_link.php`
- `modules/appointments.php`
- `public_booking.php`
- `modules/notifications.php`
- `includes/functions.php`

## Database changes

No database changes are required. Existing installations can copy these files over the old files.
