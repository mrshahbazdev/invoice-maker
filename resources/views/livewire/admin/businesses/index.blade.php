<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <!-- Search -->
        <div class="adm-search w-full sm:w-1/3">
            <div class="adm-search-icon">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="adm-input"
                placeholder="Search businesses by name or email...">
        </div>
    </div>

    <!-- Businesses Table -->
    <div class="adm-card">
        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th scope="col">Business / Owner</th>
                        <th scope="col">Contact</th>
                        <th scope="col" class="text-center">Stats</th>
                        <th scope="col">Plan</th>
                        <th scope="col" class="text-right">Modify Plan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($businesses as $business)
                        <tr>
                            <td class="whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 flex-shrink-0 rounded-xl bg-gray-900 border border-gray-700 flex items-center justify-center text-gray-400 overflow-hidden">
                                        @if($business->logo)
                                            <img src="{{ Storage::url($business->logo) }}" alt=""
                                                class="h-10 w-10 rounded-xl object-cover">
                                        @else
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="adm-cell-title">{{ $business->name }}</div>
                                        <div class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            {{ $business->user->name ?? 'Unknown Owner' }}
                                        </div>
                                        <div class="adm-cell-sub">Created
                                            {{ $business->created_at->format('M j, Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap">
                                <div class="text-sm text-gray-300">{{ $business->email }}</div>
                                <div class="text-xs text-gray-500">{{ $business->phone ?? 'No phone' }}</div>
                            </td>
                            <td class="whitespace-nowrap text-center">
                                <span class="adm-badge is-gray">
                                    {{ $business->invoices_count }} Invoices
                                </span>
                            </td>
                            <td class="whitespace-nowrap">
                                @if(strtolower($business->plan) === 'unlimited' || strtolower($business->plan) === 'enterprise')
                                    <span class="adm-badge is-purple">
                                        {{ ucfirst($business->plan ?: 'Free') }}
                                    </span>
                                @else
                                    <span class="adm-badge is-brand">
                                        {{ ucfirst($business->plan ?: 'Free') }}
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap text-right text-sm">
                                <select wire:change="setPlan({{ $business->id }}, $event.target.value)"
                                    class="adm-input adm-input-sm">
                                    <option value="free" @if(strtolower($business->plan) === 'free' || !$business->plan)
                                        selected @endif>Free Plan</option>
                                    <option value="pro" @if(strtolower($business->plan) === 'pro') selected @endif>Pro Plan
                                    </option>
                                    <option value="unlimited" @if(strtolower($business->plan) === 'unlimited') selected
                                        @endif>Unlimited (Override)</option>
                                </select>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="adm-empty">
                                No businesses found matching your search.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($businesses->hasPages())
            <div class="adm-table-foot">
                {{ $businesses->links() }}
            </div>
        @endif
    </div>
</div>
