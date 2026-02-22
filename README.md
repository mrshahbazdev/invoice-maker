# InvoiceMaker - Laravel Invoice SaaS MVP

A complete, production-ready Invoice Maker SaaS application built with Laravel 11, Livewire 3, and Tailwind CSS.

## Features

### Core Functionality
- ✅ User authentication (registration/login)
- ✅ Business profile management with logo upload
- ✅ Client management (CRUD + search + pagination)
- ✅ Product library (CRUD + search)
- ✅ Invoice creation with multi-step wizard
- ✅ Invoice status workflow (Draft → Sent → Paid → Overdue)
- ✅ Professional PDF generation with DomPDF
- ✅ Real-time dashboard with statistics
- ✅ Invoice template customization
- ✅ Payment tracking and recording
- ✅ Responsive design with Tailwind CSS

### Invoice Features
- Auto-generated invoice numbers (INV-2024-0001 format)
- Automatic tax calculations
- Discount support
- Multi-line items with quantity and pricing
- Payment tracking
- Invoice notes
- PDF export with professional templates

### Dashboard
- Total invoices count
- Total revenue
- Pending amounts
- Client count
- Recent invoices list
- Revenue chart by month

## Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM

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

4. Run migrations and seed data:
```bash
php artisan migrate:fresh --seed
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

## Demo Credentials

After running the database seeder, you can log in with:

- **Email:** demo@invoicemaker.com
- **Password:** password

The demo account includes:
- 1 business profile
- 10 sample clients
- 15 products
- 2 invoice templates
- 20 sample invoices with various statuses

## Project Structure

```
app/
├── Http/Controllers/
│   └── InvoiceController.php       # PDF generation endpoints
├── Livewire/                       # All Livewire components
│   ├── Dashboard.php
│   ├── Business/
│   │   └── Profile.php
│   ├── Clients/
│   │   ├── Index.php
│   │   ├── Create.php
│   │   └── Edit.php
│   ├── Products/
│   │   ├── Index.php
│   │   ├── Create.php
│   │   └── Edit.php
│   ├── Invoices/
│   │   ├── Index.php
│   │   ├── Create.php             # Multi-step form
│   │   ├── Edit.php
│   │   └── Show.php
│   └── Templates/
│       ├── Index.php
│       └── Builder.php
├── Models/                         # Eloquent models
│   ├── User.php
│   ├── Business.php
│   ├── Client.php
│   ├── Product.php
│   ├── Template.php
│   ├── Invoice.php
│   ├── InvoiceItem.php
│   └── Payment.php
├── Services/                       # Business logic
│   ├── InvoiceNumberService.php    # Generate invoice numbers
│   ├── InvoiceCalculationService.php # Calculate totals
│   └── PdfGenerationService.php    # Generate PDFs
└── Policies/                       # Authorization policies

database/
├── migrations/                     # Database schema
└── seeders/
    └── DatabaseSeeder.php          # Demo data

resources/views/
├── layouts/
│   ├── app.blade.php              # Main layout with sidebar
│   └── guest.blade.php             # Auth pages layout
├── components/
│   ├── sidebar.blade.php
│   └── stats-card.blade.php
├── livewire/                       # Component views
└── invoices/
    └── pdf.blade.php              # PDF template
```

## Database Schema

### Core Tables
- **users** - Laravel default auth with 2FA support
- **businesses** - Business profiles linked to users
- **clients** - Customer information
- **products** - Product/service catalog
- **templates** - Invoice customization options
- **invoices** - Main invoice records
- **invoice_items** - Line items for invoices
- **payments** - Payment records

## Technologies Used

- **Backend:** Laravel 11, PHP 8.2+
- **Frontend:** Livewire 3, Alpine.js
- **Styling:** Tailwind CSS
- **PDF Generation:** DomPDF
- **Image Processing:** Intervention Image
- **Database:** SQLite (default, easily switchable)

## Key Services

### InvoiceNumberService
Generates sequential invoice numbers in format: `INV-YYYY-NNNN`

### InvoiceCalculationService
Handles all invoice calculations:
- Subtotals
- Tax calculations
- Discounts
- Grand totals

### PdfGenerationService
Generates professional PDF invoices with customizable templates.

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

### Clear Cache
```bash
php artisan optimize:clear
php artisan view:clear
php artisan cache:clear
```

## Customization

### Adding New Invoice Status
Edit `Invoice.php` model and add to STATUS constants.

### Modifying PDF Template
Edit `resources/views/invoices/pdf.blade.php`

### Custom Styling
Modify `resources/css/app.css` and `tailwind.config.js`

## Security

- All routes protected by authentication middleware
- Authorization policies for all models
- CSRF protection enabled
- Password hashing (bcrypt)
- Input validation on all forms

## Production Deployment

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure a real database (MySQL/PostgreSQL)
4. Set up proper file storage (S3, etc.)
5. Configure mail settings
6. Run `php artisan config:cache`
7. Run `php artisan route:cache`
8. Run `npm run build` for production assets

## License

MIT License - feel free to use this project for personal or commercial purposes.

## Support

For issues or questions, please open an issue on the repository.
