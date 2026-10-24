# InvoiceMaker — Invoicing SaaS

A complete invoicing SaaS application built with Laravel 11, Livewire 3, and Tailwind CSS.
Businesses manage clients, products, invoices, estimates, expenses, and accounting in one
place, and clients get a secure portal with signed public invoice links and Stripe payments.

## Features

### Dashboard
- Financial overview: outstanding amounts, recurring revenue, expenses
- AI-powered insights on recent financial performance
- Recent invoices, expenses, and team activity

### Business Profile & Branding
- Company details, logo, address, contact information
- Custom brand colors (applied to public links, client portal, and PDF invoices)
- Payment terms defaults
- **B2B Network Sync:** opt in to "Accept Network Invoices" and invoices sent by another
  business on the platform automatically appear in your Expenses tab

### Team Management
- Invite members by email; roles: Owner, Admin, Viewer (viewers are read-only)
- Team members share the same business workspace, clients, and financial records

### Clients & Client Portal
- Client CRUD with billing addresses, VAT numbers, contact emails
- Secure client portal (signed magic links): invoice history, lifetime statement,
  bulk invoice downloads, outstanding balance
- Support tickets inside the portal, answered from the business dashboard

### Products & Services
- Product/service catalog with default prices and tax rates
- Stock management: invoicing a physical product deducts the billed quantity

### Invoicing Engine
- Multi-step invoice creation, auto-generated invoice numbers (per business)
- Tax calculations, discounts, multi-line items, invoice notes
- Status workflow: Draft → Sent → Paid → Overdue
- **Recurring invoices:** weekly, monthly, quarterly, or yearly auto-generation
- Professional PDF generation (DomPDF) with customizable templates
- **Public links:** signed links clients can open to view, download, approve (estimates),
  request revisions, and comment
- **Online payments (Stripe):** clients pay by card/Apple Pay from the public link;
  the invoice is marked paid automatically

### Estimates / Quotes
- Same flow as invoices, representing a quote
- Client approval via the public link converts an estimate into an invoice in one click

### Expenses
- Expense logging with categories, custom or auto-generated numbers
- Link expenses directly to an invoice; upload receipt images/PDFs (private storage,
  served through an auth-checked controller)
- Cash book entries created from paid invoices and expenses

### Accounting & Cash Book
- Complete cash-flow ledger (income from paid invoices, outbound expenses)
- AI health check on cash book health
- Exports to Excel/CSV/PDF for accountants
- **Bank reconciliation:** import a bank statement CSV, map columns, auto-match lines
  against unpaid invoices and unlinked expenses, import matches into the ledger
- Profitability and tax summary reports

### Templates Builder
- Drag-and-drop invoice layout builder; standard, minimalist, and modern layouts

### Security & Profile
- Two-factor authentication (authenticator app + single-use recovery codes)
- Interface language switch (13 locales)
- Authorization policies scoped to business + role; CSRF protection; password hashing
- Public invoice access only through signed links; sensitive uploads on private disk

## Technologies Used

- **Backend:** Laravel 11, PHP 8.3, Livewire 3, Alpine.js
- **Styling:** Tailwind CSS
- **PDF Generation:** DomPDF
- **Payments:** Stripe
- **Database:** MySQL (production)

## Installation (local development)

### Prerequisites
- PHP 8.3+
- Composer
- Node.js & NPM
- MySQL

### Setup Steps

1. Install dependencies:
```bash
composer install
npm install
```

2. Build assets:
```bash
npm run build
```

3. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Run migrations:
```bash
php artisan migrate
```

5. Link storage (for file uploads):
```bash
php artisan storage:link
```

6. Start development server:
```bash
php artisan serve
```

7. Visit http://localhost:8000

> Note: database seeders contain demo data for local development only.
> Never run `migrate:fresh --seed` on a production database.

## Scheduled Jobs (required in production)

Reminders, scheduled sends, recurring invoices, late fees, and the daily backup all run
through Laravel's scheduler. Add this cron line on the server (hosting panel or crontab):

```
* * * * * /usr/local/bin/php /home/customer/www/invoice.allocore.de/public_html/artisan schedule:run >> /dev/null 2>&1
```

(Adjust the PHP path and app path to your server.)

## Backup & Restore

Backups run daily through the scheduler (`app:backup` command) and are stored privately in
`storage/app/backups/` (never web-accessible), with a 7-day rotation.

Each backup produces two files:
- `db-YYYYMMDD-HHMMSS.sql.gz` — full database dump
- `files-YYYYMMDD-HHMMSS.tar.gz` — storage archive (uploads, receipts, signatures)

To create a backup manually:
```bash
php artisan app:backup
```

To restore, **always test into a scratch database first**:
```bash
# Database (replace placeholders with values from .env)
gunzip -c storage/app/backups/db-<stamp>.sql.gz | mysql -h <db-host> -u <db-user> -p <database>

# Files
tar -xzf storage/app/backups/files-<stamp>.tar.gz -C storage/app
```

Off-server snapshots (hosting panel) are a separate layer — confirm in the hosting panel
that they cover this app's directory and database.

## Production Deployment

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` (never enable debug output on production — error pages must
   never expose SQL or submitted form data)
3. Configure a real database (MySQL) and mail settings
4. Set up the scheduler cron line (see above)
5. Verify backups run and test a restore
6. Run `php artisan config:cache`
7. Run `php artisan route:cache`
8. Run `npm run build` for production assets

## Project Structure

```
app/
├── Http/Controllers/          # Web, API, public invoice, Stripe, portal controllers
├── Livewire/                  # All Livewire components
│   ├── Dashboard.php
│   ├── Business/              # Business profile
│   ├── Clients/               # Client CRUD + portal
│   ├── Products/              # Product catalog
│   ├── Invoices/              # Invoice CRUD, show, index
│   ├── Estimates/             # Estimate CRUD
│   ├── Templates/             # Template index + builder
│   ├── Expenses/              # Expenses, categories, cash book
│   ├── Accounting/            # Cash book, reconciliation
│   ├── Reports/               # Profitability, tax summary
│   ├── ClientPortal/          # Client dashboard, settings, tickets
│   ├── Settings/              # Team management
│   ├── Profile/               # User profile, 2FA, AI settings
│   └── Admin/                 # Super-admin: users, businesses, plans, support
├── Models/                    # Eloquent models (User, Business, Client, Product,
│                              #   Template, Invoice, InvoiceItem, Payment, Expense, ...)
├── Services/                  # InvoiceNumberService, InvoiceCalculationService,
│                              #   PdfGenerationService, mail + Stripe services
├── Policies/                  # Authorization policies (business + role scoped)
└── Console/Commands/          # Recurring, reminders, scheduled sends, late fees, backup

database/
├── migrations/                # Database schema
└── seeders/                   # Demo data (development only)

resources/views/
├── layouts/                   # app + guest layouts
├── components/                # Sidebar, stats cards
├── livewire/                  # Component views
├── errors/                    # Branded 403 / 404 / 500 pages
└── invoices/                  # PDF + public invoice templates
```

## Security Notes

- All business routes require authentication + business membership
- Authorization policies scope every resource to the user's business and role
  (owners/admins write, viewers read only)
- Public invoice access only through signed links (signature enforced in controllers)
- Sensitive uploads (receipts, signatures, ticket attachments) live on private disk and
  are served through an auth- and ownership-checked controller
- CSRF protection enabled; only the Stripe webhook is excluded (it verifies the
  Stripe signature itself)
- Password hashing (bcrypt); API tokens via Sanctum with expiry

## License

MIT License — feel free to use this project for personal or commercial purposes.

## Support

For issues or questions, please open an issue on the repository.
