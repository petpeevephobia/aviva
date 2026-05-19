# Running the Aviva site locally (Laragon / Windows)

This project mixes:

1. **Static PHP/HTML site** — files under `www/` (e.g. `index.php`, `home.php`, `aviva.css`).
2. **Joomla 1.5 CMS** — under `www/aviva/` (see `www/aviva/configuration.php`).

---

## Prerequisites

- [Laragon](https://laragon.org/) (or another Apache + PHP + MySQL stack).
- **Apache** and **MySQL** started in Laragon.

---

## URLs that work

Laragon maps `C:\laragon\www\` to the web root. This project lives at:

`C:\laragon\www\aviva-site\`

**Use these in the browser** (confirmed working):

| Page | URL |
|------|-----|
| Splash / entry | `http://localhost/aviva-site/www/index.php` |
| Same over IP | `http://127.0.0.1/aviva-site/www/index.php` |
| “Home” (includes PHP `header.php`) | `http://localhost/aviva-site/www/home.php` |

**Note:** Opening only `http://localhost/aviva-site/` shows a **directory listing** (`.cursor/`, `backup/`, `www/`), not the site. Always include **`/www/`** in the path unless you change Apache’s document root (see below).

**Pretty hostname:** `http://aviva-site.test/` may point at the **project root** (`aviva-site\`), not `aviva-site\www\`. If `*.test` behaves badly (downloads, directory index), prefer **`localhost`** URLs above.

---

## Styling (yellow / cream background)

The main stylesheet is:

`www/aviva.css` (e.g. `background-color: #FFF9DB`).

If styles are missing, open:

`http://localhost/aviva-site/www/aviva.css`

You should see CSS text. Pages under `/www/` load it as `aviva.css` relative to that folder.

---

## `.htaccess` (Laragon vs old hosting)

The repo may include hosting-specific lines (e.g. LiteSpeed `AddHandler ... lsphp`) in `www/.htaccess`. Those are for the **old server**, not Laragon.

- If **`.php` files trigger a download** instead of rendering, remove or comment out any **`AddHandler ... lsphp`** line in `www/.htaccess`, then restart Apache.
- Keep a backup (e.g. `.htaccess_old`) before editing.

---

## Optional: Joomla (`www/aviva/`)

- **URL:** `http://localhost/aviva-site/www/aviva/`
- **Admin:** `http://localhost/aviva-site/www/aviva/administrator/`

### Database

1. Create a MySQL database (e.g. in phpMyAdmin).
2. Import:

   `backup/kp4s5b8_1.sql`

3. Edit **`www/aviva/configuration.php`** so `$host`, `$user`, `$password`, and `$db` match your local MySQL. Table prefix is `$dbprefix` (e.g. `jos_`).

### PHP version

This is **Joomla 1.5**. It is **not** compatible with **PHP 8.x**. For the Joomla part, use an old PHP in Laragon (e.g. **5.6**) if the site errors or stays blank. The simple static pages under `/www/` are more forgiving on modern PHP.

---

## Optional: shorter URLs (no `/aviva-site/www/`)

Point the site’s document root at **`...\aviva-site\www`** (Laragon virtual host / “document root” for this project), so `http://something.test/` maps directly to the `www` folder. Exact steps depend on your Laragon version (Apache vhost / menu “Document root”).

---

## Quick checklist

- [ ] Apache + MySQL running in Laragon.
- [ ] Open `http://localhost/aviva-site/www/index.php` — splash page, not a download.
- [ ] Open `http://localhost/aviva-site/www/home.php` — full home layout with nav.
- [ ] `http://localhost/aviva-site/www/aviva.css` returns CSS.
- [ ] (Joomla only) DB imported; `configuration.php` updated; old PHP if needed.

---

## Troubleshooting

| Symptom | Likely cause |
|--------|----------------|
| Directory listing at `localhost/aviva-site/` | Normal — use `/www/` or change document root. |
| Browser downloads `*.php` | Bad `AddHandler` in `www/.htaccess` or PHP not bound to Apache — fix `.htaccess` / Laragon PHP. |
| Joomla blank / errors | PHP too new for 1.5, or wrong DB settings in `configuration.php`. |
