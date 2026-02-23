<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Livewire\Dashboard;
use App\Livewire\Business\Profile;
use App\Http\Controllers\StripeController;
use App\Livewire\Clients\Index as ClientsIndex;
use App\Livewire\Clients\Create as ClientsCreate;
use App\Livewire\Clients\Edit as ClientsEdit;
use App\Livewire\Products\Index as ProductsIndex;
use App\Livewire\Products\Create as ProductsCreate;
use App\Livewire\Products\Edit as ProductsEdit;
use App\Livewire\Invoices\Index as InvoicesIndex;
use App\Livewire\Invoices\Create as InvoicesCreate;
use App\Livewire\Invoices\Edit as InvoicesEdit;
use App\Livewire\Invoices\Show as InvoicesShow;
use App\Livewire\Estimates\Index as EstimatesIndex;
use App\Livewire\Estimates\Create as EstimatesCreate;
use App\Livewire\Estimates\Edit as EstimatesEdit;
use App\Livewire\Templates\Index as TemplatesIndex;
use App\Livewire\Templates\Builder as TemplatesBuilder;
use App\Livewire\Expenses\Index as ExpensesIndex;
use App\Livewire\Expenses\Create as ExpensesCreate;
use App\Livewire\Expenses\Edit as ExpensesEdit;
use App\Livewire\Settings\Team as SettingsTeam;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PublicInvoiceController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\CashBookExportController;
use App\Livewire\Accounting\Categories\Index as CategoriesIndex;
use App\Livewire\Accounting\CashBook\Index as CashBookIndex;

// Public Invoice View
Route::get('/v/{invoice}', [PublicInvoiceController::class, 'show'])->name('invoices.public.show');
Route::get('/v/{invoice}/download', [PublicInvoiceController::class, 'download'])->name('invoices.public.download');
Route::post('/v/{invoice}/approve', [PublicInvoiceController::class, 'approve'])->name('invoices.public.approve');
Route::post('/v/{invoice}/revision', [PublicInvoiceController::class, 'requestRevision'])->name('invoices.public.revision');
Route::post('/v/{invoice}/comment', [PublicInvoiceController::class, 'addComment'])->name('invoices.public.comment');

// Client Portal Routes (Signed for first-time login/registration)
Route::get('/v/{invoice}/save', [ClientPortalController::class, 'showRegistrationForm'])->name('client.register')->middleware('signed');
Route::post('/v/{invoice}/save', [ClientPortalController::class, 'register'])->name('client.register.post')->middleware('signed');

// Stripe Payments
Route::get('/v/{invoice}/pay', [StripeController::class, 'createCheckoutSession'])->name('invoices.pay');

Route::get('/', function () {
    if (auth()->check() && auth()->user()->role === 'client') {
        return redirect()->route('client.dashboard');
    }
    return redirect()->route('dashboard');
})->middleware(['auth', 'verified']);

Route::middleware(['auth', 'business.member'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::prefix('business')->group(function () {
        Route::get('/profile', Profile::class)->name('business.profile');
        Route::get('/stripe/return', [StripeController::class, 'handleReturn'])->name('stripe.return');
    });

    Route::prefix('clients')->group(function () {
        Route::get('/', ClientsIndex::class)->name('clients.index');
        Route::get('/create', ClientsCreate::class)->name('clients.create');
        Route::get('/{client}/edit', ClientsEdit::class)->name('clients.edit');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', ProductsIndex::class)->name('products.index');
        Route::get('/create', ProductsCreate::class)->name('products.create');
        Route::get('/{product}/edit', ProductsEdit::class)->name('products.edit');
    });

    Route::prefix('invoices')->group(function () {
        Route::get('/', InvoicesIndex::class)->name('invoices.index');
        Route::get('/create', InvoicesCreate::class)->name('invoices.create');
        Route::get('/{invoice}/edit', InvoicesEdit::class)->name('invoices.edit');
        Route::get('/{invoice}', InvoicesShow::class)->name('invoices.show');
        Route::get('/{invoice}/download', [InvoiceController::class, 'downloadPdf'])->name('invoices.download');
        Route::get('/{invoice}/preview', [InvoiceController::class, 'previewPdf'])->name('invoices.preview');
    });

    Route::prefix('estimates')->group(function () {
        Route::get('/', EstimatesIndex::class)->name('estimates.index');
        Route::get('/create', EstimatesCreate::class)->name('estimates.create');
        Route::get('/{estimate}/edit', EstimatesEdit::class)->name('estimates.edit');
        Route::get('/{invoice}', InvoicesShow::class)->name('estimates.show');
    });

    Route::prefix('templates')->group(function () {
        Route::get('/', TemplatesIndex::class)->name('templates.index');
        Route::get('/{template}/edit', TemplatesBuilder::class)->name('templates.edit');
    });

    // Team Settings
    Route::get('/settings/team', SettingsTeam::class)->name('settings.team');

    Route::prefix('expenses')->group(function () {
        Route::get('/', ExpensesIndex::class)->name('expenses.index');
        Route::get('/create', ExpensesCreate::class)->name('expenses.create');
        Route::get('/{expense}/edit', ExpensesEdit::class)->name('expenses.edit');
        Route::get('/export/csv', [CashBookExportController::class, 'exportCsv'])->name('expenses.export');
        Route::get('/categories', CategoriesIndex::class)->name('expenses.categories');
        Route::get('/cash-book', CashBookIndex::class)->name('accounting.cash-book');
    });
});

require __DIR__ . '/auth.php';

Route::post('/webhooks/stripe', [StripeController::class, 'handleWebhook'])->name('stripe.webhook');

// Invitation Accept (Public/Guest)
Route::get('/invitations/accept/{token}', [InvitationController::class, 'accept'])->name('invitations.accept');

Route::middleware(['auth'])->group(function () {
    Route::get('/client/dashboard', [ClientPortalController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/client/settings', App\Livewire\ClientPortal\Settings::class)->name('client.settings');
    Route::get('/client/invoices/download-all', [ClientPortalController::class, 'downloadAllInvoices'])->name('client.invoices.download-all');
    Route::get('/client/statement', [ClientPortalController::class, 'downloadStatement'])->name('client.statement');
});

Route::get('language/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');
