# Hotfix: Public Booking Success Exit + Duplicate Guard

This update changes only the public customer booking flow.

## What changed

- After a successful public booking, the customer is taken to a success-only page.
- The booking form disappears after success.
- The success page tells the customer they can safely close the page.
- Refreshing the success page cannot submit the booking again.
- A database-level duplicate guard was added with `public_booking_submissions`.
- The guard uses both the one-time form token and the booking fingerprint.

## Updated files

- `public_booking.php`
- `public_booking_done.php`
- `database/schema.sql`
- `database/migrations/2026_08_04_public_booking_success_exit_duplicate_guard.sql`

## Updating an existing installation

Copy the new files over your current system, then run this migration once in phpMyAdmin:

`database/migrations/2026_08_04_public_booking_success_exit_duplicate_guard.sql`

Fresh installations do not need manual migration.
