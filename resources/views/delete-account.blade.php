<x-landing-layout>
    @section('title', __('Delete my account') . ' - ' . \App\Models\Setting::get('site.name', config('app.name', 'InvoiceMaker')))

    <div class="py-24 bg-page">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-card rounded-3xl p-8 sm:p-12 shadow-sm border border-gray-100">
                <h1 class="text-3xl sm:text-4xl font-black text-txmain mb-2 tracking-tight">
                    {{ __('Delete my account') }}
                </h1>
                <p class="text-txmain mb-8">
                    {{ __('Use this page to request deletion of your account and its associated data. We will process your request and confirm by email. Legal retention duties (for example tax records) may require us to keep invoice data for a defined period even after deletion.') }}
                </p>

                @if (!empty($submitted))
                    <div class="rounded-2xl bg-green-50 border border-green-200 p-5 text-green-800">
                        <strong>{{ __('Request received.') }}</strong>
                        {{ __('If an account exists for the email address you entered, we have recorded your deletion request and our team will process it. You will receive a confirmation by email.') }}
                    </div>
                @else
                    <form method="POST" action="{{ route('account.delete-request.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-semibold text-txmain mb-1">{{ __('Account email address') }}</label>
                            <input id="email" name="email" type="email" required value="{{ old('email') }}"
                                class="w-full rounded-xl border border-gray-200 px-4 py-3 text-txmain focus:outline-none focus:ring-2 focus:ring-orange-500"
                                placeholder="name@example.com">
                            @error('email')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <label class="flex items-start gap-3 text-sm text-txmain">
                            <input name="confirm" type="checkbox" value="1" required class="mt-1 accent-orange-500">
                            <span>{{ __('I understand that deleting my account is permanent and I will lose access to my invoices, clients and products, except for data we must legally retain.') }}</span>
                        </label>
                        @error('confirm')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <button type="submit"
                            class="w-full rounded-xl bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 transition">
                            {{ __('Request account deletion') }}
                        </button>
                    </form>
                @endif

                <p class="text-sm text-gray-500 mt-8">
                    {{ __('See also:') }}
                    <a href="{{ route('privacy') }}" class="text-orange-600 hover:underline">{{ __('Privacy Policy') }}</a>
                </p>
            </div>
        </div>
    </div>
</x-landing-layout>
