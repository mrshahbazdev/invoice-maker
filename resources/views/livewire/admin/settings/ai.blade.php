<div class="max-w-4xl mx-auto space-y-6">
    @if (session()->has('message'))
        <div class="p-4 rounded-xl bg-green-500/20 text-green-400 border border-green-500/30 flex items-center">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">

        <!-- API Keys Configuration -->
        <div class="bg-gray-800 shadow-sm rounded-xl border border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-700 bg-gray-900/50">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                        </path>
                    </svg>
                    API Keys
                </h3>
                <p class="text-sm text-gray-400 mt-1">Configure your connections to leading AI providers.</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Default AI Provider</label>
                    <select wire:model="default_ai_provider"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 focus:ring-brand-500 focus:border-brand-500">
                        <option value="openai">OpenAI (ChatGPT)</option>
                        <option value="anthropic">Anthropic (Claude)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">OpenAI API Key</label>
                    <input wire:model="openai_api_key" type="password" placeholder="sk-..."
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 font-mono text-sm focus:ring-brand-500 focus:border-brand-500">
                    <p class="text-xs text-gray-500 mt-1">Required for ChatGPT integrations (e.g., Receipt Scanner).</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Anthropic API Key</label>
                    <input wire:model="anthropic_api_key" type="password" placeholder="sk-ant-..."
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg text-white px-3 py-2 font-mono text-sm focus:ring-brand-500 focus:border-brand-500">
                    <p class="text-xs text-gray-500 mt-1">Required for Claude integrations.</p>
                </div>
            </div>
        </div>

        <!-- System Prompts Configuration -->
        <div class="bg-gray-800 shadow-sm rounded-xl border border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-700 bg-gray-900/50">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                        </path>
                    </svg>
                    System Prompts
                </h3>
                <p class="text-sm text-gray-400 mt-1">Tune how the AI behaves throughout the application by adjusting
                    these base prompts.</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Invoice Description Generator
                        Prompt</label>
                    <textarea wire:model="invoice_description_prompt" rows="3"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg text-gray-300 px-3 py-2 text-sm focus:ring-brand-500 focus:border-brand-500"></textarea>
                    <p class="text-xs text-gray-500 mt-1">This prompt instructions the AI on how to summarize line items
                        into a nice invoice note.</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Business Insights Prompt</label>
                    <textarea wire:model="business_insights_prompt" rows="4"
                        class="w-full bg-gray-900 border border-gray-700 rounded-lg text-gray-300 px-3 py-2 text-sm focus:ring-brand-500 focus:border-brand-500"></textarea>
                    <p class="text-xs text-gray-500 mt-1">Instructs the AI on how to analyze cash book data to generate
                        financial insights.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-brand-600 hover:bg-brand-500 text-white font-bold py-2.5 px-6 rounded-lg shadow-lg flex items-center transition-colors">
                <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span wire:loading.remove wire:target="save">Save AI Settings</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>
</div>