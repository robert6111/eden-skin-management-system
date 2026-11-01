# Eden Skin — Installation Guide

**Brand:** Eden Skin — Skin Beauty Aesthetics  
**Recommended local setup:** Windows 10/11 + XAMPP (Apache + MySQL/MariaDB)

## 1. Copy the system
1. Install XAMPP.
2. Copy the folder `salon_spa_management_system` into `C:\xampp\htdocs\`.
3. Confirm the final path is `C:\xampp\htdocs\salon_spa_management_system`.

## 2. Start the local server
1. Open XAMPP Control Panel.
2. Start **Apache**.
3. Start **MySQL**.

## 3. Run the clean installer
Open Chrome or Edge and visit:

`http://localhost/salon_spa_management_system/install.php`

Use the database values shown by the installer. On a normal fresh XAMPP installation:
- Host: `127.0.0.1`
- Port: `3306`
- User: `root`
- Password: blank unless XAMPP was secured manually
- Database: `salon_spa_tz`

Enter the owner name, phone number, username and a password of at least 8 characters. The installer creates the database, all current tables, the Eden Skin business record, the first Owner account, `config.php`, and `storage/installed.lock`.

## 4. Sign in
Open:

`http://localhost/salon_spa_management_system/`

Use the Owner username and password created during installation.

## 5. First-day setup
Before real sales are entered:
1. Open **Settings** and confirm phone, address and receipt footer.
2. Open **Staff** and add employees.
3. Open **Services** and confirm service names, duration and prices.
4. Open **Inventory** and replace sample stock with the salon's actual stock where necessary.
5. Open **Appointments → Send Booking Link** and test one customer booking.
6. Open **POS / Sales**, complete one test sale, view it and print the receipt.
7. Delete/cancel test business transactions before official use if they should not remain in reports.
8. Create and download the first backup.

## 6. Public booking / Ngrok
The local system works without internet. If a public booking link is required from outside the salon network, use a secure HTTPS tunnel or proper web hosting. If Ngrok is used, expose only while needed and keep XAMPP/Windows updated.

The public booking form uses a one-time submission token plus a database submission guard and redirects after a successful POST, reducing accidental duplicate appointments from refreshes/double submissions.

## 7. Important security notes
- Do not share the Owner password.
- Create separate user accounts for staff.
- Do not expose phpMyAdmin publicly.
- `storage`, `database`, `docs`, and `cron` are protected from normal web access.
- Scheduled scripts under `cron` are CLI-only.
- Automatic SMS/WhatsApp/email delivery is **not** included until a provider/API is configured. WhatsApp messages can be opened and sent manually from the Notifications screen.
