# Eden Skin — Skin Beauty Aesthetics

Customer-ready Salon & Spa Management System built with PHP and MySQL/MariaDB.

## Requirements
- Windows 10/11 with XAMPP, or equivalent PHP 8.1+ and MySQL/MariaDB environment
- Recent Chrome, Edge or Firefox

## Install
1. Copy this folder to `C:\xampp\htdocs\salon_spa_management_system`.
2. Start Apache and MySQL.
3. Open `http://localhost/salon_spa_management_system/install.php`.
4. Create the Owner account.
5. Sign in and complete the first-day setup.

Full instructions: `docs/INSTALLATION.md`  
Backups: `docs/BACKUP_GUIDE.md`  
Staff guide: `docs/USER_GUIDE.md`  
Handover checklist: `docs/PRODUCTION_CHECKLIST.md`

## Release notes
- Fresh installer: no developer `config.php` and no `installed.lock` are shipped.
- Database schema is consolidated into `database/schema.sql`; no separate migration sequence is required for a fresh installation.
- Developer database dumps are not included.
- Public booking uses a one-time submission token, database guard and POST/Redirect/GET flow to reduce duplicate bookings.
- `cron`, `database`, `docs`, and `storage` are denied from direct Apache access; cron scripts are CLI-only.
- WhatsApp messages can be opened/sent manually. Automatic SMS/WhatsApp/email sending requires an external provider/API and is not falsely marked as delivered.
