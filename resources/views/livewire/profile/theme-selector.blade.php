<div>
    <label class="block font-medium text-sm text-txmain mb-2">
        {{ $label }}
    </label>
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <!-- Default (Null) Option -->
        <label
            class="relative flex cursor-pointer rounded-lg border bg-card p-4 shadow-sm focus:outline-none {{ is_null($modelValue) ? 'border-brand-500 ring-2 ring-brand-500' : 'border-gray-300' }}">
            <input type="radio" wire:model.live="{{ $modelName }}" value="" class="sr-only">
            <span class="flex flex-1">
                <span class="flex flex-col">
                    <span class="block text-sm font-medium text-txmain">{{ __('System Default') }}</span>
                    <span class="mt-2 flex items-center space-x-2">
                        <span class="w-6 h-6 rounded-full border border-gray-200"
                            style="background-color: {{ $defaultHex }};"></span>
                    </span>
                </span>
            </span>
            @if(is_null($modelValue))
                <svg class="h-5 w-5 text-brand-600 absolute right-4 top-4" viewBox="0 0 20 20" fill="currentColor"
                    aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                        clip-rule="evenodd" />
                </svg>
            @endif
        </label>

        <!-- Available Themes -->
        @foreach($availableThemes as $theme)
            <label
                class="relative flex cursor-pointer rounded-lg border bg-card p-4 shadow-sm focus:outline-none {{ $modelValue === $theme->id ? 'border-brand-500 ring-2 ring-brand-500' : 'border-gray-300' }}">
                <input type="radio" wire:model.live="{{ $modelName }}" value="{{ $theme->id }}" class="sr-only">
                <span class="flex flex-1">
                    <span class="flex flex-col">
                        <span class="block text-sm font-medium text-txmain">{{ $theme->name }}</span>
                        <span class="mt-2 flex items-center space-x-2">
                            <span class="w-6 h-6 rounded-full border border-gray-200"
                                style="background-color: {{ $theme->primary_color }};"></span>
                        </span>
                    </span>
                </span>
                @if($modelValue === $theme->id)
                    <svg class="h-5 w-5 text-brand-600 absolute right-4 top-4" viewBox="0 0 20 20" fill="currentColor"
                        aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                            clip-rule="evenodd" />
                    </svg>
                @endif
            </label>
        @endforeach
    </div>
    @error($modelName) <span class="text-sm text-red-600 mt-2">{{ $message }}</span> @enderror
</div>