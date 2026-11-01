# Staff Add/Edit Hotfix

This hotfix changes only `modules/staff.php`.

Fixed:
- Staff edit link no longer opens a broken/not-found route.
- Staff save/update uses a clean stable action path instead of the browser's current script path.
- Save errors are caught and shown as readable messages instead of a broken page.
- Add/edit form layout is cleaned so the Save Staff Member button stays inside the staff form.
- Staff list, fields, permissions, branch restrictions, salary, commission defaults, status, audit logging and delete logic are preserved.

No database migration is required.
