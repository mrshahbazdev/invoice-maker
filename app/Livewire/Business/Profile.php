<?php

namespace App\Livewire\Business;

use Livewire\Component;
use App\Models\Business;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Stripe\StripeClient;

class Profile extends Component
{
    use WithFileUploads;

    public ?Business $business = null;
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';
    public string $currency = 'USD';
    public string $timezone = 'UTC';
    public string $tax_number = '';
    public string $bank_details = '';
    public string $payment_terms = '';
    public string $language = 'en';
    public string $invoice_number_prefix = 'INV';
    public int $invoice_number_next = 1;
    public string $bank_booking_account = '1000';
    public string $cash_booking_account = '1200';
    public $logo;
    public bool $stripe_onboarding_complete = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'currency' => 'required|string|max:3',
            'timezone' => 'required|string',
            'tax_number' => 'nullable|string|max:255',
            'bank_details' => 'nullable|string',
            'payment_terms' => 'nullable|string',
            'language' => 'required|string|in:en,de,es,fr,it,pt,ar,zh,ja,ru',
            'invoice_number_prefix' => 'required|string|max:10',
            'invoice_number_next' => 'required|integer|min:1',
            'bank_booking_account' => 'nullable|string|max:20',
            'cash_booking_account' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:2048',
        ];
    }

    public function mount(): void
    {
        $this->business = Auth::user()->business;

        if ($this->business) {
            $this->name = $this->business->name;
            $this->email = $this->business->email ?? '';
            $this->phone = $this->business->phone ?? '';
            $this->address = $this->business->address ?? '';
            $this->currency = $this->business->currency;
            $this->timezone = $this->business->timezone;
            $this->tax_number = $this->business->tax_number ?? '';
            $this->bank_details = $this->business->bank_details ?? '';
            $this->payment_terms = $this->business->payment_terms ?? '';
            $this->invoice_number_prefix = $this->business->invoice_number_prefix ?? 'INV';
            $this->invoice_number_next = $this->business->invoice_number_next ?? 1;
            $this->bank_booking_account = $this->business->bank_booking_account ?? '1000';
            $this->cash_booking_account = $this->business->cash_booking_account ?? '1200';
            $this->stripe_onboarding_complete = $this->business->stripe_onboarding_complete;
        } else {
            // Defaults for new business
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->currency = 'USD';
            $this->timezone = 'UTC';
        }

        $this->language = Auth::user()->language ?? 'en';
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'currency' => $this->currency,
            'timezone' => $this->timezone,
            'tax_number' => $this->tax_number,
            'bank_details' => $this->bank_details,
            'payment_terms' => $this->payment_terms,
            'invoice_number_prefix' => $this->invoice_number_prefix,
            'invoice_number_next' => $this->invoice_number_next,
            'bank_booking_account' => $this->bank_booking_account,
            'cash_booking_account' => $this->cash_booking_account,
        ];

        if ($this->logo) {
            $path = $this->logo->store('logos', 'public');
            $data['logo'] = $path;
        }

        if ($this->business) {
            $this->business->update($data);
        } else {
            // Create new business and link to user
            $data['user_id'] = Auth::id();
            $this->business = Business::create($data);
            Auth::user()->update(['business_id' => $this->business->id]);
        }

        Auth::user()->update(['language' => $this->language]);
        App::setLocale($this->language);

        session()->flash('message', 'Business profile and language updated successfully.');
    }

    public function removeLogo(): void
    {
        if ($this->business) {
            $this->business->update(['logo' => null]);
            $this->logo = null;
            session()->flash('message', 'Logo removed successfully.');
        }
    }

    public function connectStripe()
    {
        if (!$this->business) {
            return;
        }

        $stripeSecret = env('STRIPE_SECRET');

        if (!$stripeSecret) {
            session()->flash('error', 'Stripe secret key is not configured in .env file.');
            return;
        }

        $stripe = new StripeClient($stripeSecret);

        // Create Stripe account if it doesn't exist
        if (!$this->business->stripe_account_id) {
            $account = $stripe->accounts->create([
                'type' => 'standard',
                'email' => $this->business->user->email,
            ]);

            $this->business->update([
                'stripe_account_id' => $account->id
            ]);
        }

        // Generate onboarding link
        $accountLink = $stripe->accountLinks->create([
            'account' => $this->business->stripe_account_id,
            'refresh_url' => route('business.profile'),
            'return_url' => route('stripe.return'),
            'type' => 'account_onboarding',
        ]);

        return redirect()->away($accountLink->url);
    }

    public function render()
    {
        return view('livewire.business.profile');
    }
}
