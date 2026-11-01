# Hotfix: Stock-style Reports + Eden Skin Branding

Changed areas only:

- `modules/reports.php`
- `modules/reports_pdf.php`
- `includes/reporting.php`
- `includes/fpdf/`
- `assets/img/eden_skin_logo.jpg`
- `assets/img/favicon.png`
- favicon links in page headers

Purpose:

- Reworked the Salon & Spa Reports module to follow the uploaded Stock Inventory system reporting style: filter box, grid filters, sales list, PDF export, summary cards, daily/monthly/yearly summaries, best-selling items, and branch reports.
- Adapted the reporting queries to the Salon & Spa database tables.
- Added the uploaded Eden Skin image to the report header and browser favicon.

No database migration is required.
