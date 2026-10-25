<div class="max-w-4xl mx-auto space-y-6">
    @if (session()->has('message'))
        <div class="adm-flash is-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">

        <!-- Standard SEO Meta Tags -->
        <div class="adm-card">
            <div class="adm-card-head">
                <h3>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                        </path>
                    </svg>
                    Standard Meta tags
                </h3>
                <p>These tags appear in Google search results and help improve your
                    ranking.</p>
            </div>
            <div class="adm-card-body space-y-4">
                <div>
                    <label class="adm-label">Meta Title</label>
                    <input wire:model="meta_title" type="text" class="adm-input">
                    <p class="adm-hint">Recommended length: 50-60 characters.</p>
                </div>
                <div>
                    <label class="adm-label">Meta Description</label>
                    <textarea wire:model="meta_description" rows="3" class="adm-input"></textarea>
                    <p class="adm-hint">Recommended length: 150-160 characters.</p>
                </div>
                <div>
                    <label class="adm-label">Keywords</label>
                    <input wire:model="meta_keywords" type="text" class="adm-input">
                    <p class="adm-hint">Comma separated. E.g., invoice maker, free billing software.
                    </p>
                </div>
            </div>
        </div>

        <!-- Open Graph / Social Media -->
        <div class="adm-card">
            <div class="adm-card-head">
                <h3>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5">
                        </path>
                    </svg>
                    Social Media Optimization (Open Graph)
                </h3>
                <p>This determines how your site looks when a link is shared on
                    Facebook, Twitter, or LinkedIn.</p>
            </div>
            <div class="adm-card-body space-y-4">
                <div>
                    <label class="adm-label">Social Meta Title</label>
                    <input wire:model="og_title" type="text" class="adm-input">
                </div>
                <div>
                    <label class="adm-label">Social Meta Description</label>
                    <textarea wire:model="og_description" rows="2" class="adm-input"></textarea>
                </div>
                <div>
                    <label class="adm-label">Social Image (OG Image)</label>
                    <div class="mt-2 flex items-center gap-4">
                        @if ($new_og_image)
                            <img src="{{ $new_og_image->temporaryUrl() }}"
                                class="h-24 w-auto rounded border border-gray-700 object-cover">
                        @elseif ($existing_og_image)
                            <img src="{{ Storage::url($existing_og_image) }}"
                                class="h-24 w-auto rounded border border-gray-700 object-cover">
                        @endif
                        <input type="file" wire:model="new_og_image" accept="image/*"
                            class="text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-brand-500/20 file:text-brand-400 hover:file:bg-brand-500/30">
                    </div>
                    <div wire:loading wire:target="new_og_image" class="text-xs text-brand-400 mt-2">Uploading
                        preview...</div>
                    <p class="adm-hint">Recommended size: 1200 x 630 pixels. This image appears when
                        the link is unfurled.</p>
                </div>
            </div>
        </div>

        <!-- Tracking & Scripts -->
        <div class="adm-card">
            <div class="adm-card-head">
                <h3>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                    Tracking &amp; Third-Party Scripts
                </h3>
                <p>Inject global tracking scripts into your application.</p>
            </div>
            <div class="adm-card-body space-y-4">
                <div>
                    <label class="adm-label">Google Analytics ID</label>
                    <input wire:model="google_analytics_id" type="text" placeholder="G-XXXXXXXXXX" class="adm-input">
                </div>
                <div>
                    <label class="adm-label">Custom Header Scripts (e.g., Meta
                        Pixel)</label>
                    <textarea wire:model="custom_header_scripts" rows="4" class="adm-input mono"></textarea>
                    <p class="adm-hint">WARNING: These scripts fall directly into the &lt;head&gt;
                        tag. Be careful.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="adm-btn adm-btn-primary">
                <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span wire:loading.remove wire:target="save">Save SEO Settings</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>
</div>
