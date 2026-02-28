<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Livewire\Dashboard;
use App\Livewire\Business\Profile as BusinessProfile;
use App\Livewire\Profile\Show as UserProfileShow;
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
use App\Livewire\Expenses\Show as ExpensesShow;
use App\Livewire\Settings\Team as SettingsTeam;
use App\Livewire\Settings\EmailTemplates as SettingsEmailTemplates;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PublicInvoiceController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\CashBookExportController;
use App\Http\Controllers\DocumentationController;
use App\Livewire\Accounting\Categories\Index as CategoriesIndex;
use App\Livewire\Accounting\CashBook\Index as CashBookIndex;
use App\Livewire\Accounting\Reconciliation;

// Public Invoice View
Route::get('/v/{invoice}', [PublicInvoiceController::class, 'show'])->name('invoices.public.show');
Route::get('/v/{invoice}/download', [PublicInvoiceController::class, 'download'])->name('invoices.public.download');
Route::post('/v/{invoice}/approve', [PublicInvoiceController::class, 'approve'])->name('invoices.public.approve');
Route::post('/v/{invoice}/revision', [PublicInvoiceController::class, 'requestRevision'])->name('invoices.public.revision');
Route::post('/v/{invoice}/comment', [PublicInvoiceController::class, 'addComment'])->name('invoices.public.comment');

// Client Portal Routes (Signed for first-time login/registration)
Route::get('/v/{invoice}/save', [ClientPortalController::class, 'showRegistrationForm'])->name('client.register')->middleware('signed');
Route::post('/v/{invoice}/save', [ClientPortalController::class, 'register'])->name('client.register.post')->middleware('signed');

// Secure Client Portal Dashboard
Route::get('/portal/{client}', [ClientPortalController::class, 'index'])->name('client.portal')->middleware('signed');

// Stripe Payments
Route::get('/v/{invoice}/pay', [StripeController::class, 'createCheckoutSession'])->name('invoices.pay');

Route::get('/', function () {
    return view('welcome');
});

// Public Blog Routes
Route::get('/blog', \App\Livewire\Blog\Index::class)->name('public.blog.index');
Route::get('/blog/{slug}', \App\Livewire\Blog\Show::class)->name('public.blog.show');

// Public Documentation Routes (SEO logic included)
// We default to /docs leading to /docs/en
Route::redirect('/docs', '/docs/en');
Route::get('/docs/{lang}', [DocumentationController::class, 'index'])->name('docs.index');
Route::get('/docs/{lang}/{slug}', [DocumentationController::class, 'show'])->name('docs.show');

Route::middleware(['auth', 'business.member'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', UserProfileShow::class)->name('profile.show');

    Route::prefix('business')->group(function () {
        Route::get('/profile', BusinessProfile::class)->name('business.profile');
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
    // Email Templates
    Route::get('/settings/email-templates', SettingsEmailTemplates::class)->name('settings.email-templates');

    Route::prefix('expenses')->group(function () {
        Route::get('/', ExpensesIndex::class)->name('expenses.index');
        Route::get('/create', ExpensesCreate::class)->name('expenses.create');
        Route::get('/{expense}/edit', ExpensesEdit::class)->name('expenses.edit');
        Route::get('/export/csv', [CashBookExportController::class, 'exportCsv'])->name('expenses.export');
        Route::get('/export/excel', [CashBookExportController::class, 'exportExcel'])->name('accounting.cash-book.export.excel');
        Route::get('/export/pdf', [CashBookExportController::class, 'exportPdf'])->name('accounting.cash-book.export.pdf');
        Route::get('/categories', CategoriesIndex::class)->name('expenses.categories');
        Route::get('/cash-book', CashBookIndex::class)->name('accounting.cash-book');
        Route::get('/reconciliation', Reconciliation::class)->name('accounting.reconciliation');
        Route::get('/profitability', \App\Livewire\Reports\Profitability::class)->name('reports.profitability');
        Route::get('/profitability/export', [App\Http\Controllers\ProfitabilityExportController::class, 'exportExcel'])->name('reports.profitability.export');
        Route::get('/{expense}', ExpensesShow::class)->name('expenses.show');
    });

    Route::prefix('reports')->group(function () {
        Route::get('/', \App\Livewire\Admin\Reports\Index::class)->name('reports.index');
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

    // Client Tickets
    Route::prefix('client/tickets')->name('client.tickets.')->group(function () {
        Route::get('/', \App\Livewire\Client\Tickets\Index::class)->name('index');
        Route::get('/create', \App\Livewire\Client\Tickets\Create::class)->name('create');
        Route::get('/{ticket}', \App\Livewire\Client\Tickets\Show::class)->name('show');
    });

    // Impersonation
    Route::post('/impersonate/leave', [\App\Http\Controllers\ImpersonateController::class, 'leave'])->name('impersonate.leave');
});

// Super Admin Routes
Route::middleware(['auth', 'is_super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('/users', \App\Livewire\Admin\Users\Index::class)->name('users.index');
    Route::get('/businesses', \App\Livewire\Admin\Businesses\Index::class)->name('businesses.index');
    Route::get('/plans', \App\Livewire\Admin\Plans\Index::class)->name('plans.index');
    Route::get('/settings/general', \App\Livewire\Admin\Settings\General::class)->name('settings.general');
    Route::get('/settings/seo', \App\Livewire\Admin\Settings\Seo::class)->name('settings.seo');
    Route::get('/settings/ai', \App\Livewire\Admin\Settings\Ai::class)->name('settings.ai');
    Route::get('/settings/themes', \App\Livewire\Admin\Settings\Themes::class)->name('settings.themes');
    Route::get('/settings/languages', \App\Livewire\Admin\Settings\Languages::class)->name('settings.languages');

    Route::prefix('blog')->name('blog.')->group(function () {
        Route::get('/categories', \App\Livewire\Admin\Blog\Categories::class)->name('categories');
        Route::get('/', \App\Livewire\Admin\Blog\Index::class)->name('index');
        Route::get('/create', \App\Livewire\Admin\Blog\Create::class)->name('create');
        Route::get('/{post}/edit', \App\Livewire\Admin\Blog\Edit::class)->name('edit');
    });

    Route::prefix('support')->name('support.')->group(function () {
        Route::get('/', \App\Livewire\Admin\Support\Index::class)->name('index');
        Route::get('/{ticket}', \App\Livewire\Admin\Support\Show::class)->name('show');
    });
});

Route::get('/pay/{invoice:uuid}', [\App\Http\Controllers\PaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/pay/{invoice:uuid}/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');

Route::get('language/{locale}', [App\Http\Controllers\LanguageController::class, 'switch'])->name('language.switch');

// External Cron Job API
Route::get('/api/cron/{token}', function ($token) {
    $expectedToken = config('app.cron_token', env('CRON_TOKEN', 'secret-cron-token'));
    if ($token !== $expectedToken) {
        abort(403, 'Unauthorized cron request');
    }

    // Run critical daily commands directly instead of relying on schedule:run
    // which requires the ping to hit the exact start of the minute.
    \Illuminate\Support\Facades\Artisan::call('app:process-recurring-invoices');
    $out1 = \Illuminate\Support\Facades\Artisan::output();

    \Illuminate\Support\Facades\Artisan::call('invoices:send-reminders');
    $out2 = \Illuminate\Support\Facades\Artisan::output();

    \Illuminate\Support\Facades\Artisan::call('invoices:send-scheduled');
    $out3 = \Illuminate\Support\Facades\Artisan::output();

    return response()->json([
        'status' => 'success',
        'message' => 'Scheduled tasks executed successfully.',
        'output' => trim($out1 . "\n" . $out2 . "\n" . $out3)
    ]);
})->name('api.cron');
