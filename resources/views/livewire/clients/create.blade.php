@php $title = 'Create Client'; @endphp

<div>
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Create Client</h2>
        <p class="text-gray-600">Add a new client to your list</p>
    </div>

    <div class="max-w-2xl">
        <form wire:submit="save" class="bg-white rounded-lg shadow p-6">
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Contact Name *</label>
                <input type="text" wire:model="name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="John Doe">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" wire:model="email"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="john@example.com">
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                <input type="text" wire:model="phone"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="+1 (555) 123-4567">
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                <input type="text" wire:model="company_name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Acme Corporation">
                @error('company_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                <textarea wire:model="address" rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="123 Business Street&#10;City, State ZIP"></textarea>
                @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tax Number</label>
                <input type="text" wire:model="tax_number"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('tax_number') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Currency Override</label>
                <select wire:model="currency"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="USD">USD - US Dollar</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="GBP">GBP - British Pound</option>
                    <option value="CAD">CAD - Canadian Dollar</option>
                    <option value="AUD">AUD - Australian Dollar</option>
                    <option value="JPY">JPY - Japanese Yen</option>
                    <option value="PKR">PKR - Pakistani Rupee</option>
                    <option value="INR">INR - Indian Rupee</option>
                    <option value="AED">AED - UAE Dirham</option>
                </select>
                @error('currency') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Language Preference</label>
                <select wire:model="language"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="en">English</option>
                    <option value="es">Spanish (Español)</option>
                    <option value="fr">French (Français)</option>
                    <option value="de">German (Deutsch)</option>
                </select>
                @error('language') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                <p class="mt-2 text-xs text-gray-500">This language will be used for PDFs and portal experiences.</p>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                <textarea wire:model="notes" rows="2"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Any additional notes..."></textarea>
                @error('notes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('clients.index') }}"
                    class="text-gray-600 hover:text-gray-700 py-2 px-4 rounded-lg border border-gray-300">Cancel</a>
                <button type="submit"
                    class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition duration-200">
                    Create Client
                </button>
            </div>
        </form>
    </div>
</div>