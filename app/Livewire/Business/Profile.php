<?php

namespace App\Livewire\Business;

use Livewire\Component;
use App\Models\Business;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
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
            $this->stripe_onboarding_complete = $this->business->stripe_onboarding_complete;
        } else {
            // Defaults for new business
            $this->name = Auth::user()->name;
            $this->email = Auth::user()->email;
            $this->currency = 'USD';
            $this->timezone = 'UTC';
        }
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

        session()->flash('message', 'Business profile updated successfully.');
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
