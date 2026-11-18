VOIDLOOT - Futuristic PC Game Discovery Website
================================================

REQUIREMENTS
- XAMPP (Apache, PHP 8+, MySQL/MariaDB)
- A modern browser
- Internet connection for remote cover art and Google Fonts

INSTALLATION
1. Extract this folder into C:\xampp\htdocs\voidloot
2. Open XAMPP Control Panel and start Apache and MySQL.
3. Visit http://localhost/phpmyadmin
4. Select Import and import database/voidloot.sql.
   WARNING: the SQL file drops and recreates the VOIDLOOT project tables.
   Back up existing VOIDLOOT data before importing it again.
5. If your MySQL credentials differ from XAMPP defaults, edit config.php.
6. Visit http://localhost/voidloot/

ADMIN
- URL: http://localhost/voidloot/admin/
- Default local password: ChangeThis-VOIDLOOT-2026!
- Change this password before publishing the site.
- You can override it with the VOIDLOOT_ADMIN_PASSWORD environment variable.

ADDING A GAME
- Add/edit games in the admin panel.
- Use direct image URLs for cover, banner and screenshots.
- Trailer field accepts a normal YouTube watch/share URL.
- Add download sources as one per line:
  Official publisher | https://publisher.example/game
- Only add official publisher sites, authorised retailers, or legitimate free/open-source project downloads.
- Requirements should be checked against the publisher's current specifications.

NOTES
- This starter uses remote image URLs rather than file uploads.
- It includes prepared SQL statements, HTML escaping, CSRF checks and a session-based admin login.
- Before public deployment, use HTTPS, set a strong unique admin password, configure database credentials,
  disable public error display, add rate limiting, and have the site security-reviewed.
- Sample requirements marked "Verify with publisher" are intentionally not guessed.
