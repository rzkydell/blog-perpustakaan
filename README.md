# Library Blog CMS & API

A content management back end for a **library website**: staff write articles, news, events and library information in a Filament admin panel, and a public JSON API serves the published content to any front end (a website or a mobile app).

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![Filament](https://img.shields.io/badge/Filament-3.3-FDAE4B?style=flat-square)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat-square&logo=php&logoColor=white)
![Sanctum](https://img.shields.io/badge/Laravel%20Sanctum-API-FF2D20?style=flat-square&logo=laravel&logoColor=white)

## Features

**Admin panel** (`/admin`, Filament):

- **Articles** with banner image, rich-text content, category, tags, PDF attachment (upload or external link), draft/published status, publish date and view counter.
- **Categories** and **tags**.
- **News**, **events** (date, location, registration link, status) and **library information** pages (for example opening hours and contacts).
- **Dashboard widgets:** content totals, recent content and upcoming events.

**Public API** (read-only, published content only):

| Method | Endpoint | Description |
| --- | --- | --- |
| GET | `/api/articles` | Published articles with category and author. Filters: `?category=<slug>`, `?q=<search>` |
| GET | `/api/articles/{slug}` | One article with category, author and tags |
| GET | `/api/categories` | Categories with their published-article counts |
| GET | `/api/events` | Published events, newest first |
| GET | `/api/library-info` | Published library information |
| GET | `/api/user` | Current user (requires a Sanctum token) |

The root URL `/` redirects to the admin panel.

## Getting started

Requirements: PHP 8.2+, Composer, Node.js and npm.

```bash
git clone https://github.com/rzkydell/blog-perpustakaan.git
cd blog-perpustakaan
composer run setup        # install deps, create .env, generate key, migrate, build assets
php artisan db:seed       # admin account and sample content
php artisan storage:link  # serve uploaded banners and PDFs
composer run dev          # app server, queue, logs and Vite
```

Open http://localhost:8000/admin. The seeder creates a local admin account `admin@gmail.com` / `admin123`; change it before any real deployment. SQLite is the default database (see `.env`).

## Project structure

```text
app/
├── Filament/Resources/       # Article, Category, Tag, News, Event, LibraryInformation
├── Filament/Widgets/         # ContentStats, RecentContents, UpcomingEvents
├── Http/Controllers/API/     # ArticleController (public API)
└── Models/
database/migrations/          # Content tables
database/seeders/             # Admin user and sample content
routes/api.php                # Public API routes
```

## Author

**Rizky Delianngi** · [Portfolio](https://rzkydell.vercel.app) · [GitHub](https://github.com/rzkydell)

<details>
<summary>Ringkasan (Bahasa Indonesia)</summary>

Back end CMS untuk situs perpustakaan: panel admin Filament untuk artikel (dengan lampiran PDF), kategori, tag, berita, acara, dan informasi perpustakaan, serta API JSON publik yang hanya menampilkan konten berstatus *published*. Dibangun dengan Laravel 12 dan Filament 3.

</details>
