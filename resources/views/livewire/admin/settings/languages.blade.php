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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Language List -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 shadow-sm">
                <h3 class="text-lg font-bold text-white mb-4">Available Languages</h3>
                <div class="space-y-3">
                    @foreach($availableLocales as $code => $name)
                        @php
                            $isEnabled = isset($enabledLanguages[$code]);
                            $isBase = $code === 'en';
                        @endphp
                        <div
                            class="flex items-center justify-between p-4 {{ $isEnabled ? 'bg-indigo-900/20 border-indigo-500/30' : 'bg-gray-900 border-gray-700' }} border rounded-xl transition-all">
                            <div class="flex flex-col">
                                <span
                                    class="font-bold {{ $isEnabled ? 'text-indigo-400' : 'text-gray-300' }}">{{ $name }}</span>
                                <span class="text-xs text-gray-500 uppercase font-mono">{{ $code }}</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                @if($isEnabled && !$isBase)
                                    <button wire:click="editTranslations('{{ $code }}')"
                                        class="{{ $editingLocale === $code ? 'text-indigo-400' : 'text-gray-400 hover:text-white' }} transition-colors"
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
                                        class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-500">
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
                    <div class="flex justify-between items-center mb-6 pb-6 border-b border-gray-700">
                        <div>
                            <h3 class="text-xl font-bold text-white flex items-center">
                                Translating to <span
                                    class="ml-2 px-2 py-1 bg-indigo-500/20 text-indigo-400 rounded-md text-sm border border-indigo-500/30">{{ $availableLocales[$editingLocale] }}
                                    ({{ strtoupper($editingLocale) }})</span>
                            </h3>
                            <p class="text-sm text-gray-400 mt-1">Translate the base English strings into
                                {{ $availableLocales[$editingLocale] }}.</p>
                        </div>
                        <button wire:click="saveTranslations"
                            class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-indigo-500/20 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            Save Changes
                        </button>
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
                                class="block w-full pl-10 bg-gray-900 border border-gray-700 rounded-xl text-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-2.5"
                                placeholder="Search original strings...">
                        </div>
                    </div>

                    <div class="flex-1 overflow-y-auto pr-2 space-y-4 rounded-xl custom-scrollbar">
                        @if(empty($filteredKeys))
                            <div class="text-center py-12 text-gray-500">
                                No matching strings found.
                            </div>
                        @else
                            @foreach($filteredKeys as $key)
                                <div class="bg-gray-900 border border-gray-700 rounded-xl p-4">
                                    <div class="mb-2 text-sm text-gray-400 font-mono">{{ $key }}</div>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 w-1 bg-indigo-500 rounded-l-md"></div>
                                        <textarea wire:model.defer="translations.{{ $key }}" rows="2"
                                            class="w-full bg-gray-800 border {{ empty($translations[$key]) ? 'border-red-500/30 focus:border-red-500' : 'border-gray-600 focus:border-indigo-500' }} text-white rounded-md pl-4 pr-3 py-2 text-sm focus:ring-1 focus:ring-indigo-500"
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
</div>