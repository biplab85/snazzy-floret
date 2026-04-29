# Snazzy Floret

Premium WooCommerce website for **Snazzy Floret**, a Dhaka-based clothing brand specializing in family matching dresses, mother-daughter combos, panjabi sets, and customized travel/party/office wear.

- **Brand:** Snazzy Floret (Dhaka, Bangladesh)
- **Facebook:** https://www.facebook.com/snazzyfloret (82K followers)
- **Instagram:** @snazzyfloret
- **Email:** snazzyfloret@gmail.com
- **Phone:** 01621-008533

## Tech Stack

| Layer        | Version              |
|--------------|----------------------|
| WordPress    | 6.9.4                |
| WooCommerce  | 10.6.2               |
| PHP          | 8.4                  |
| MySQL        | 8.4                  |
| Theme        | Custom child theme (`snazzy-floret-theme`) |
| WP-CLI       | 2.12.0               |
| Local server | WampServer (Windows) |

No headless architecture, no page builders. All customization lives in the child theme via PHP, hooks/filters, and custom CSS/JS.

## Project Structure

```
snazzy-floret/
├── wp-admin/                       WordPress core (do not modify)
├── wp-includes/                    WordPress core (do not modify)
├── wp-content/
│   ├── plugins/                    WooCommerce + supporting plugins
│   ├── themes/snazzy-floret-theme/ Custom child theme - all frontend work
│   └── uploads/                    Media library
├── db/snazzy_floret.sql            Database dump
├── snazzy-floret-products.csv      Product import data
├── CLAUDE.md                       Full development guide
└── wp-config.php                   Site configuration
```

The custom child theme is where all design and feature work happens. See `CLAUDE.md` for the complete architecture, design system, and feature task list.

## Local Development

```bash
URL:      http://localhost/sklentr/snazzy-floret/
Admin:    http://localhost/sklentr/snazzy-floret/wp-admin/
Database: snazzy_floret  (user: root, no password)
```

### Setup

1. Clone into your WampServer `www/sklentr/` directory.
2. Create a MySQL database named `snazzy_floret`.
3. Import the dump: `wp db import db/snazzy_floret.sql --path=.`
4. Update `wp-config.php` with your local DB credentials and fresh salt keys (https://api.wordpress.org/secret-key/1.1/salt/).
5. Visit the site URL to verify.

### Useful WP-CLI commands

```bash
wp plugin list
wp theme activate snazzy-floret-theme
wp cache flush
wp db export backup.sql
```

## Design

- **Fonts:** Playfair Display (headings), Inter (body) — these are the only fonts allowed.
- **Palette:** rich black, warm gold/bronze, soft gold accents on a warm off-white background.
- **Currency:** BDT (Bangladeshi Taka, ৳).
- **Reference:** [Figma](https://www.figma.com/design/MCOqwRfRqUc1hu5fy56xAF/Snazzy-Floret-Website).

Full design tokens, spacing scale, and UI guidelines are in `CLAUDE.md`.

## Security

- Customers are restricted to `/my-account/`; only administrators may access `/wp-admin/`.
- New registrations get the `customer` role only.
- All forms use nonces; all output is escaped.
- See `CLAUDE.md` Section 6 for the full security checklist.

## Contributing

This repository follows the rules in `CLAUDE.md`:

- Never modify WordPress or WooCommerce core files.
- All customization through the child theme: hooks, filters, and template overrides.
- No page builders, no plugin bloat — minimal, custom code only.
- Function prefix `sf_`, text domain `snazzy-floret`.

## License

Proprietary. All rights reserved by Snazzy Floret.
