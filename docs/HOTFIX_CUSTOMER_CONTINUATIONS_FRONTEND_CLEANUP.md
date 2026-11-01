# Customer Service Continuations + Frontend Cleanup

This update adds logic for recurring/continuation customers who must return after a few days for a second service, review, refill, wash-out, maintenance, or treatment continuation.

## What was added

- New module: `modules/continuations.php`
- New menu item: `Service Continuations`
- Services can now be marked as requiring a continuation visit.
- Each service can define:
  - whether continuation is required
  - number of days before the customer should return
  - continuation service to book
  - continuation note/message
- POS now automatically creates a continuation plan after payment for services that require it.
- Packages also create continuation plans for package services that require follow-up.
- Customer history now shows continuation plans.
- Sale view now shows any continuation visits created from that sale.
- Dashboard now shows continuation visits due today and overdue.
- Notifications cron now queues WhatsApp reminders for continuation visits due soon.

## Existing installations

The system can create the required columns/table automatically when the continuation pages or POS load.

If phpMyAdmin is preferred, run:

`database/migrations/2026_08_06_customer_service_continuations.sql`

## Frontend cleanup

The sidebar navigation now checks whether module files exist before displaying links. This prevents empty/broken gaps when modules have been removed from the frontend.

Only continuation logic and frontend navigation cleanup were changed.
