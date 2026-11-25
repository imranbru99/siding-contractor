# Northclad Siding

Production-ready Laravel 13 + Filament 3 website, ERP, and AI toolkit for a Twin Cities siding contractor. Public marketing site, knowledge base, WhatsApp CTA, and a full admin ERP for cladding jobs, inventory, invoices, scheduling, and AI assistants.

## ✨ Features

- 🏠 Premium public site with hero, services, about, ERP dashboard preview, and contact form
- 🛠️ Service detail pages for fiber cement, vinyl, wood, metal accents, storm repair, and multifamily cladding
- 📚 Blog / field notes with seeded siding articles
- 💬 Floating WhatsApp button + public AI chatbot (OpenAI / Gemini / FAQ demo fallback)
- 🧾 Filament ERP at `/admin` — customers, jobs, inventory, invoices, payments, appointments
- 👥 Roles: Admin, Manager, Staff (Spatie Permission + role column)
- 📊 Reports dashboard with stats and charts
- ⚙️ Company settings page + AI content / automation / troubleshooting tools
- 📖 Knowledge base: common issues, guides, admin manual, troubleshooting
- 🌱 Realistic demo seeders for Minnesota homeowners and siding jobs

## 🧰 Tech Stack

- Laravel 13
- Filament 3
- Livewire + Alpine.js + Tailwind (Filament)
- MySQL or SQLite (demo)
- Spatie Laravel Permission
- OpenAI / Gemini via Laravel Http client (FAQ demo fallback when keys empty)

## 🚀 Installation

```bash
git clone https://github.com/imranbru99/siding-contractor.git
cd siding-contractor
composer install
copy .env.example .env   # Windows
php artisan key:generate
# SQLite demo is ready — or configure MySQL in .env
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Admin panel: `http://localhost:8000/admin`  
Public site: `http://localhost:8000`

### Demo credentials

- Email: `admin@example.com`
- Password: `password`

Optional AI keys in `.env`: `OPENAI_API_KEY`, `GEMINI_API_KEY`.

## 🖼️ Screenshots / Visual Dashboard

![Fiber cement clad suburban home](https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&w=1200&q=80)

![Board-and-batten exterior elevation](https://images.unsplash.com/photo-1480074568708-e7b720bb3f09?auto=format&fit=crop&w=1200&q=80)

![Modern lap siding residence](https://images.unsplash.com/photo-1583608205776-bfd36c7a4c7a?auto=format&fit=crop&w=1200&q=80)

![Twin Cities style home facade](https://images.unsplash.com/photo-1430285561322-7808604715df?auto=format&fit=crop&w=1200&q=80)

## 🌐 Live Demo

Placeholder — deploy to your preferred host (Forge, Vapor, shared PHP) and update this section with the production URL.

## 🔍 SEO-optimized GitHub description suggestion

```
Northclad Siding — Laravel 13 + Filament 3 siding contractor website & ERP with AI chatbot, jobs, inventory, invoices, and Twin Cities demo data.
```

---

## 🤝 Let's Connect & Collaborate
I am open to Senior Remote Full-Stack Roles, AI Platform Architecture Contracts, and Enterprise Technical Advisory.
Timezone: UTC+6 (Dhaka / Rangpur, Bangladesh) — Flexible overlap with US, UK, and European business hours.
Delivery Mode: Async-ready, Slack, Discord, Jira, GitHub, and production-first accountability.

| Channel | Address / Handle | Quick Action |
|---------|------------------|--------------|
| 🌐 Primary Portfolio | imrandev.bd | Visit Site ↗ |
| 📦 Packagist Packages | packagist.org/packages/imrandevbd/ | View Packages ↗ |
| 💼 LinkedIn Profile | linkedin.com/in/imranbru99 | Connect ↗ |
| 🐙 GitHub Profile | github.com/imranbru99 | Follow ↗ |
| 💬 WhatsApp Direct | +880 1576-918420 | Chat Now ↗ |
| 📧 Direct Email | me@imrandev.bd | Send Email ↗ |
| 🐦 X (Twitter) | @imrandev_bd | Follow ↗ |
| 📺 YouTube Tech | @ImranDevBD | Subscribe ↗ |
