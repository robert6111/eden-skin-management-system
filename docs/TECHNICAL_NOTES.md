# Technical Notes

- Stack: Plain PHP 8+, MySQL/MariaDB, HTML/CSS/JavaScript.
- Target: Windows XAMPP without Composer, Node, Laravel, or internet dependency.
- Security: password hashing, CSRF tokens, prepared statements, role permissions, audit log, session timeout, branch scoping and installer lock.
- Database: 64 tables covering operations, finance, inventory, HR, marketing, branches, audit and settings.
- Receipts/reports: print-ready; browser can save as PDF.
- Uploads: documents are stored under `storage/uploads` and downloaded through permission-checked `modules/download.php`.

## Default modules
The side navigation automatically shows modules based on the signed-in user's permissions.
