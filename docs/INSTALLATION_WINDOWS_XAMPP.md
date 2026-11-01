# Windows XAMPP Installation

1. Install XAMPP and start **Apache** and **MySQL**.
2. Copy the folder `salon_spa_management_system` into `C:\xampp\htdocs\`.
3. Open `http://localhost/salon_spa_management_system/install.php`.
4. Use these default XAMPP values unless you changed them:
   - Host: `127.0.0.1`
   - Port: `3306`
   - Database: `salon_spa_tz`
   - User: `root`
   - Password: leave blank
5. Enter your business name, branch name, owner name, username and password.
6. After installation, sign in at `http://localhost/salon_spa_management_system/login.php`.

The installer creates the database, seed data, roles, permissions, sample services/products, and locks itself using `storage/installed.lock`.

## Scheduling backups and reminders
Use Windows Task Scheduler and run:

```bat
C:\xampp\php\php.exe C:\xampp\htdocs\salon_spa_management_system\cron\backup.php
C:\xampp\php\php.exe C:\xampp\htdocs\salon_spa_management_system\cron\send_notifications.php
```
