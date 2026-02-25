<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold font-heading text-white">Languages & Localization</h2>
            <p class="text-gray-400 mt-1">Manage supported languages and edit interface translations.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Language List -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-white">Available Languages</h3>
                    <button wire:click="showAddLanguageModal"
                        class="text-sm px-3 py-1 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition-colors flex items-center shadow-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Add Custom
                    </button>
                </div>

                <div class="space-y-3">
                    @foreach($this->availableLocales as $code => $name)
                        @php
                            $isEnabled = isset($enabledLanguages[$code]);
                            $isBase = $code === 'en';
                        @endphp
                        <div
                            class="flex items-center justify-between p-4 {{ $isEnabled ? 'bg-brand-900/20 border-brand-500/30' : 'bg-gray-900 border-gray-700' }} border rounded-xl transition-all">
                            <div class="flex flex-col">
                                <span
                                    class="font-bold {{ $isEnabled ? 'text-brand-400' : 'text-gray-300' }}">{{ $name }}</span>
                                <span class="text-xs text-gray-500 uppercase font-mono">{{ $code }}</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                @if($isEnabled && !$isBase)
                                    <button wire:click="editTranslations('{{ $code }}')"
                                        class="{{ $editingLocale === $code ? 'text-brand-400' : 'text-gray-400 hover:text-white' }} transition-colors"
                                        title="Edit Translations">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                @endif

                                <label
                                    class="relative inline-flex items-center {{ $isBase ? 'cursor-not-allowed opacity-50' : 'cursor-pointer' }}"
                                    title="{{ $isBase ? 'Base language cannot be disabled' : '' }}">
                                    <input type="checkbox" wire:click="toggleLanguage('{{ $code }}', '{{ $name }}')"
                                        class="sr-only peer" {{ $isEnabled ? 'checked' : '' }} {{ $isBase ? 'disabled' : '' }}>
                                    <div
                                        class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500">
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Translator Editor -->
        <div class="lg:col-span-2 space-y-6">
            @if($editingLocale)
                <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 shadow-sm flex flex-col h-[800px]">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-6 border-b border-gray-700 gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-white flex items-center">
                                Translating to <span
                                    class="ml-2 px-2 py-1 bg-brand-500/20 text-brand-400 rounded-md text-sm border border-brand-500/30">{{ $this->availableLocales[$editingLocale] }}
                                    ({{ strtoupper($editingLocale) }})</span>
                            </h3>
                            <p class="text-sm text-gray-400 mt-1">Translate the base English strings into
                                {{ $this->availableLocales[$editingLocale] }}.</p>
                        </div>
                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <button wire:click="autoTranslate" wire:loading.attr="disabled"
                                class="w-full sm:w-auto px-4 py-2 bg-purple-600/20 hover:bg-purple-600/30 text-purple-400 border border-purple-500/30 rounded-xl font-bold transition-all flex items-center justify-center gap-2">
                                <span wire:loading.remove wire:target="autoTranslate" class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Auto-Translate Missing (AI)
                                </span>
                                <span wire:loading wire:target="autoTranslate" class="flex items-center gap-2">
                                    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Translating...
                                </span>
                            </button>
                            <button wire:click="saveTranslations"
                                class="w-full sm:w-auto px-5 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold shadow-lg shadow-brand-500/20 transition-all flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                    </path>
                                </svg>
                                Save Changes
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text"
                                class="block w-full pl-10 bg-gray-900 border border-gray-700 rounded-xl text-gray-300 focus:ring-brand-500 focus:border-brand-500 sm:text-sm py-2.5"
                                placeholder="Search original strings...">
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto pr-2 space-y-4 rounded-xl custom-scrollbar"
                        wire:loading.class="opacity-50 pointer-events-none" wire:target="autoTranslate">
                        @if(empty($filteredKeys))
                            <div class="text-center py-12 text-gray-500">
                                No matching strings found.
                            </div>
                        @else
                            @foreach($filteredKeys as $key)
                                <div class="bg-gray-900 border border-gray-700 rounded-xl p-4">
                                    <div class="mb-2 text-sm text-gray-400 font-mono">{{ $key }}</div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 w-1 bg-brand-500 rounded-l-md"></div>
                                        <textarea wire:model.defer="translations.{{ $key }}" rows="2"
                                            class="w-full bg-gray-800 border {{ empty($translations[$key]) ? 'border-red-500/30 focus:border-red-500' : 'border-gray-600 focus:border-brand-500' }} text-white rounded-md pl-4 pr-3 py-2 text-sm focus:ring-1 focus:ring-brand-500"
                                            placeholder="Translate this text..."></textarea>
                                    </div>
                                    @if(empty($translations[$key]))
                                        <div class="mt-1 text-xs text-red-400/70">Missing translation</div>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @else
                <div
                    class="bg-gray-800 rounded-2xl border border-gray-700 p-12 shadow-sm flex flex-col items-center justify-center h-full min-h-[400px] text-center">
                    <div class="w-20 h-20 bg-gray-900 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.53 3 18.051">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Translation Editor</h3>
                    <p class="text-gray-400 max-w-sm">Enable a language and click the edit icon to start translating the
                        interface.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Create Custom Language Modal -->
    @if($isAddingLanguage)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div wire:click="$set('isAddingLanguage', false)"
                    class="fixed inset-0 bg-gray-900 bg-opacity-75 backdrop-blur-sm transition-opacity" aria-hidden="true">
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-gray-800 border border-gray-700 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="addLanguage">
                        <div class="bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-700">
                            <h3 class="text-lg leading-6 font-bold text-white mb-6" id="modal-title">
                                Add Custom Language
                            </h3>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Language Code</label>
                                    <input type="text" wire:model.defer="newLanguageCode"
                                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500 font-mono uppercase"
                                        placeholder="e.g. KO, HI, UR, etc." required>
                                    <p class="text-xs text-gray-500 mt-1">Short ISO code for the language.</p>
                                    @error('newLanguageCode') <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Language Name</label>
                                    <input type="text" wire:model.defer="newLanguageName"
                                        class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500"
                                        placeholder="e.g. Korean, Hindi, Urdu" required>
                                    @error('newLanguageName') <span class="text-red-400 text-xs mt-1">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-800 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-700">
                            <button type="submit"
                                class="w-full inline-flex justify-center rounded-xl shadow-sm px-4 py-2 bg-brand-600 font-bold text-white hover:bg-brand-700 focus:outline-none sm:ml-3 sm:w-auto transition-colors">
                                Add Language
                            </button>
                            <button type="button" wire:click="$set('isAddingLanguage', false)"
                                class="mt-3 w-full inline-flex justify-center rounded-xl shadow-sm px-4 py-2 bg-gray-700 font-bold text-gray-300 hover:bg-gray-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto transition-colors">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>