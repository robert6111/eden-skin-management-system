# Eden Skin — Backup & Restore Guide

Backups protect customer, appointment, sales, stock and staff records. Create them regularly and keep a copy outside the salon computer.

## Create a manual backup
1. Sign in as an Owner/authorized administrator.
2. Open **Administration → Backup & Restore**.
3. Click **Create Manual Backup**.
4. Click **Download** beside the newest backup.
5. Save the `.sql` file to a USB drive, external drive or secure cloud folder.

Recommended routine:
- Daily when the salon is busy.
- Always before a major system update.
- Keep more than one recent backup.
- Keep at least one copy away from the salon computer.

## Restore from a backup already in the system
1. Open **Backup & Restore**.
2. Identify the correct backup by date/time.
3. Click **Restore**.
4. Confirm the warning.
5. Sign in again and verify Customers, Appointments, Sales and Inventory.

Restoring can replace newer records with the contents of the selected backup. Create a fresh backup before restoring whenever possible.

## Restore after a computer failure
If XAMPP or the computer is replaced:
1. Install a clean Eden Skin copy using the Installation Guide.
2. Restore the saved `.sql` database through phpMyAdmin or place a trusted backup into the protected backup workflow for restoration.
3. Verify the business data before resuming sales.

## Automatic backup task (optional)
The file `cron/backup.php` is CLI-only. On Windows Task Scheduler, call it with the XAMPP PHP executable, for example:

`C:\xampp\php\php.exe C:\xampp\htdocs\salon_spa_management_system\cron\backup.php`

Do not run the cron URL through a browser or public tunnel.
