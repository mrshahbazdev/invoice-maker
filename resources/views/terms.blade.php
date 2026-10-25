<x-landing-layout>
    @section('title', __('Terms of Service') . ' - ' . \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker')))

    <div class="py-24 bg-page">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-card rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100">
                <h1 class="text-3xl sm:text-4xl font-black text-txmain mb-2 tracking-tight">
                    {{ __('Terms of Service') }}
                </h1>
                <p class="text-sm text-gray-500 mb-8">{{ __('Last updated') }}: {{ __('October 2026') }}</p>

                <div class="prose prose-gray max-w-none space-y-6 text-txmain">
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('The service') }}</h2>
                        <p>InvoiceMaker is a web-based invoicing service: you can manage businesses, clients, products, invoices, estimates, expenses and reports, send invoices to your clients, and accept payments through Stripe. Features may change over time as the service improves.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Accounts') }}</h2>
                        <p>You are responsible for keeping your login credentials secret and for everything done under your account. You must provide accurate information and keep it up to date. One account may manage multiple businesses as offered by your plan.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Plans and billing') }}</h2>
                        <p>Paid plans, where offered, are billed through Stripe under the terms shown at checkout. Taxes shown on invoices are your responsibility as the seller: tax rates and tax numbers you enter are your own declarations, and preset rates in the app are common standard rates only, not tax advice. Refunds for plan payments follow the policy stated at purchase; invoice payments from your clients are between you and your clients.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Your data and content') }}</h2>
                        <p>Your business, client and invoice data remains yours. You grant us only the right to store and process it to provide the service. You are responsible for the legality and accuracy of the invoices you issue and for complying with tax and record-keeping laws in your country.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Acceptable use') }}</h2>
                        <p>You must not use the service for unlawful purposes, to send spam, to impersonate others, to interfere with the service or other users, or to upload malicious content. We may suspend accounts that violate these terms.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Availability and liability') }}</h2>
                        <p>The service is provided "as is". We work to keep it available and backed up, but we do not guarantee uninterrupted operation. To the extent permitted by law, our liability is limited to the fees you paid for the service in the twelve months before the claim. Nothing in these terms limits liability that cannot legally be limited.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Termination') }}</h2>
                        <p>You may stop using the service at any time. We may suspend or terminate accounts that breach these terms or remain inactive under an unpaid plan. On termination you can export your data beforehand; legal retention duties may require us to keep invoice records for a defined period.</p>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold mb-2">{{ __('Changes and governing law') }}</h2>
                        <p>We may update these terms; the current version is always published on this page. These terms are governed by the laws applicable at the provider's registered location as stated in the Imprint.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>
