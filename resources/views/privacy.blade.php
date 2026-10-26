<x-landing-layout>
    @section('title', __('Privacy Policy') . ' - ' . \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker')))

    <div class="py-24 bg-page">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-card rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100">
                <h1 class="text-3xl sm:text-4xl font-black text-txmain mb-2 tracking-tight">
                    {{ __('Privacy Policy') }}
                </h1>
                <p class="text-sm text-gray-500 mb-8">{{ __('Last updated') }}: {{ __('October 2026') }}</p>

                <div class="prose prose-gray max-w-none space-y-6 text-txmain">
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Overview') }}</h2>
                        <p>This Privacy Policy explains what data InvoiceMaker collects when you use our invoicing service, how we use it, and which rights you have. The provider details are stated in the Imprint. If you do not agree with this policy, please do not use the service.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Data we collect') }}</h2>
                        <p><strong>Account data:</strong> name, email address, password (stored hashed, never in plain text), and language preference. <strong>Business data:</strong> business name, address, tax number, currency, timezone, bank details you enter for display on invoices, and logo. <strong>Client and invoice data:</strong> the clients, products, invoices, estimates, expenses and messages you create — this data belongs to you and is processed only to provide the service. <strong>Payment data:</strong> payments are processed by Stripe; we never store full card numbers on our servers. <strong>Technical data:</strong> server logs (IP address, browser, pages visited) for security and troubleshooting, and strictly necessary cookies for login sessions.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('How we use your data') }}</h2>
                        <p>We use your data to operate your account, generate and deliver invoices and emails you request, process payments through Stripe, provide support, and keep the service secure. We do not sell your personal data and we do not use your invoice content for advertising.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Sharing') }}</h2>
                        <p>Data is shared only with service providers needed to run the service: Stripe (payments), your own configured email provider for sending invoices, and our hosting provider. Invoice recipients only see the invoice data you choose to share with them through a signed link or email.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Retention and security') }}</h2>
                        <p>Your data is kept while your account is active. You can ask us to delete your account and associated data on our <a href="{{ route('account.delete-request') }}" class="text-orange-600 hover:underline">delete-account page</a>; legal retention duties (for example tax records) may require us to keep invoice data for a defined period even after deletion. Access is protected by authentication, two-factor authentication options, and encrypted connections (HTTPS).</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('International transfers') }}</h2>
                        <p>Depending on your location and your own settings (for example your email provider or Stripe region), data may be processed outside your country. By using the service you consent to such transfers as needed to provide the service.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Your rights') }}</h2>
                        <p>Under laws such as the GDPR you have the right to access, correct, export, restrict, or delete your personal data, and to object to processing. To exercise these rights, contact us through the in-app support section. You also have the right to complain to your local data protection authority.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Cookies') }}</h2>
                        <p>We use only cookies required for the service to work: session cookies that keep you logged in, a language preference cookie, and security cookies. We do not use advertising trackers.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Changes') }}</h2>
                        <p>We may update this policy from time to time. The current version is always published on this page, and material changes will be announced in the app.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>
