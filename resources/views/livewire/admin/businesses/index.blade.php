<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <!-- Search -->
        <div class="relative w-full sm:w-1/3">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                class="block w-full pl-10 pr-3 py-2 border border-gray-700 rounded-lg leading-5 bg-gray-900 text-gray-300 placeholder-gray-500 focus:outline-none focus:bg-gray-800 focus:ring-1 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition duration-150 ease-in-out"
                placeholder="Search businesses by name or email...">
        </div>
    </div>

    <!-- Businesses Table -->
    <div class="bg-gray-800 shadow-sm rounded-xl border border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Business / Owner
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Contact
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Stats
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Plan
                        </th>
                        <th scope="col"
                            class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Modify Plan
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700/50">
                    @forelse($businesses as $business)
                        <tr class="hover:bg-gray-700/20 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div
                                        class="h-10 w-10 flex-shrink-0 rounded-xl bg-gray-900 border border-gray-700 flex items-center justify-center text-gray-400">
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
                                        <div class="text-sm font-bold text-white">{{ $business->name }}</div>
                                        <div class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                            {{ $business->user->name ?? 'Unknown Owner' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">Created
                                            {{ $business->created_at->format('M j, Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-300">{{ $business->email }}</div>
                                <div class="text-xs text-gray-500">{{ $business->phone ?? 'No phone' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-900 text-gray-300 border border-gray-700">
                                    {{ $business->invoices_count }} Invoices
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if(strtolower($business->plan) === 'unlimited' || strtolower($business->plan) === 'enterprise')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                        {{ ucfirst($business->plan ?: 'Free') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                        {{ ucfirst($business->plan ?: 'Free') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <select wire:change="setPlan({{ $business->id }}, $event.target.value)"
                                    class="bg-gray-900 text-gray-300 text-xs rounded border border-gray-700 focus:ring-brand-500 focus:border-brand-500 px-2 py-1">
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
                            <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                                No businesses found matching your search.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($businesses->hasPages())
            <div class="px-6 py-4 border-t border-gray-700 bg-gray-900/30">
                {{ $businesses->links() }}
            </div>
        @endif
    </div>
</div>