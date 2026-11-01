# Hotfix: Public Booking Refresh Duplicate Fix

This update fixes the case where refreshing the customer public booking page could submit the old booking again.

## What changed

- `public_booking.php` now uses a one-time booking token.
- Successful booking uses a direct `303` redirect back to the public booking page, preserving the same public host such as Ngrok instead of forcing `localhost`.
- The booking page creates a booking fingerprint from branch, phone, date, time, staff, and selected services.
- If the browser resends the same old form data, the system detects the previous booking and shows the existing appointment number instead of creating another appointment.
- A small appointment column, `public_booking_fingerprint`, is added for stronger duplicate protection.

## Existing installations

No manual database step is normally required because `public_booking.php` adds the column automatically when first used.

If you prefer to update the database manually, run:

`database/migrations/2026_08_04_public_booking_refresh_duplicate_fix.sql`

## Fresh installations

The main schema already includes the new field.
