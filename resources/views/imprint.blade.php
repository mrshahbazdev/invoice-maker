<x-landing-layout>
    @section('title', __('Imprint & Legal Notice') . ' - ' . \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker')))

    <div class="py-24 bg-page">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-card rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100">
                <h1 class="text-3xl sm:text-4xl font-black text-txmain mb-6 tracking-tight">
                    {{ __('Imprint / Impressum') }}
                </h1>
                
                <div class="prose prose-gray max-w-none space-y-6 text-txmain">
                    <div>
                        <h3 class="text-lg font-bold text-txmain mb-2">{{ __('Angaben gemäß § 5 TMG / Information according to § 5 TMG') }}</h3>
                        <p class="text-sm leading-relaxed">
                            <strong>{{ \App\Models\Setting::get('site.company_name', config('app.name', 'Allocore / InvoiceMaker')) }}</strong><br>
                            {{ \App\Models\Setting::get('site.address', 'Allocore Team') }}<br>
                            {{ \App\Models\Setting::get('site.zip_city', 'Germany') }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-lg font-bold text-txmain mb-2">{{ __('Kontakt / Contact') }}</h3>
                        <p class="text-sm leading-relaxed">
                            <strong>{{ __('Email') }}:</strong> {{ \App\Models\Setting::get('site.email', 'support@allocore.de') }}<br>
                            <strong>{{ __('Website') }}:</strong> <a href="https://allocore.de" target="_blank" class="text-brand-600 hover:underline">https://allocore.de</a>
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-lg font-bold text-txmain mb-2">{{ __('Haftung für Inhalte / Liability for Content') }}</h3>
                        <p class="text-sm leading-relaxed text-gray-600">
                            {{ __('Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen.') }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-lg font-bold text-txmain mb-2">{{ __('Urheberrecht / Copyright') }}</h3>
                        <p class="text-sm leading-relaxed text-gray-600">
                            {{ __('Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht.') }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ url()->previous() ?: url('/') }}" class="inline-flex items-center text-sm font-bold text-brand-600 hover:text-brand-700">
                        ← {{ __('Back') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-landing-layout>
