# Hotfix: Visible WhatsApp Booking Link Sender

This update makes the customer WhatsApp booking-link sender clear and easy to find.

Changed areas only:

1. `modules/booking_link.php`
   - The first card is now **Send Booking Link to Customer WhatsApp**.
   - Staff can select a saved customer or type a WhatsApp number.
   - The green button says **Open WhatsApp and Send Booking Link**.
   - The normal **Open Booking Page** button remains available.

2. `includes/header.php`
   - Added a sidebar shortcut: **Send Booking Link**.

3. `modules/appointments.php`
   - Renamed the toolbar button to **Send WhatsApp Booking Link**.

4. `modules/customers.php`
   - Customers with phone numbers now show a **WhatsApp Booking Link** button.
   - It opens the booking-link page with the customer details pre-filled.

No database migration is required for this update.
