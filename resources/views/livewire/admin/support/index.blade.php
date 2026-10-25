<div>
    <x-slot:title>
        Support Tickets Management
    </x-slot:title>

    <div class="max-w-7xl mx-auto space-y-8">
        <div class="adm-head">
            <div>
                <h2 class="adm-title">Support Tickets</h2>
                <p class="adm-sub">Manage and respond to client support requests.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <div class="flex gap-2">
                    <!-- Stat boxes -->
                    <div class="adm-stat-mini">
                        <div class="lbl">Open</div>
                        <div class="val" style="color: #4ade80;">
                            {{ \App\Models\Ticket::where('status', 'open')->count() }}</div>
                    </div>
                    <div class="adm-stat-mini">
                        <div class="lbl">Urgent</div>
                        <div class="val" style="color: #f87171;">
                            {{ \App\Models\Ticket::where('priority', 'urgent')->whereIn('status', ['open', 'in_progress'])->count() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="adm-flash is-success">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        <div class="adm-card">
            <!-- Filters -->
            <div class="p-6" style="border-bottom: 1px solid var(--adm-border);">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 w-full">
                    <div class="w-full">
                        <label class="adm-filter-label">Search</label>
                        <div class="adm-search w-full">
                            <div class="adm-search-icon">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="text" class="adm-input"
                                placeholder="Search ID, subject, email...">
                        </div>
                    </div>
                    <div class="w-full">
                        <label class="adm-filter-label">Status</label>
                        <select wire:model.live="status" class="adm-input">
                            <option value="">All Statuses</option>
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="adm-filter-label">Priority</label>
                        <select wire:model.live="priority" class="adm-input">
                            <option value="">All Priorities</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                    <div class="w-full">
                        <label class="adm-filter-label">Category</label>
                        <select wire:model.live="category" class="adm-input">
                            <option value="">All Categories</option>
                            <option value="general">General</option>
                            <option value="technical">Technical</option>
                            <option value="billing">Billing</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="adm-table-wrap relative">
                <div wire:loading.delay wire:target="search, status, priority, category"
                    class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm z-10 flex flex-col items-center justify-center">
                    <svg class="animate-spin h-10 w-10 text-brand-500 mb-2" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    <span class="text-brand-400 font-medium">Filtering Tickets...</span>
                </div>
                <table class="adm-table">
                    <thead>
                        <tr>
                            <th>Ticket Info</th>
                            <th>User / Business</th>
                            <th>Status / Priority</th>
                            <th>Last Activity</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td class="align-top">
                                    <div class="flex flex-col">
                                        <a href="{{ route('admin.support.show', $ticket) }}"
                                            class="adm-cell-title hover:text-brand-400 transition-colors truncate max-w-[250px] inline-block"
                                            title="{{ $ticket->subject }}">
                                            #{{ $ticket->id }} - {{ $ticket->subject }}
                                        </a>
                                        <span
                                            class="text-xs text-gray-500 mt-1 uppercase tracking-wider">{{ ucfirst($ticket->category) }}</span>
                                    </div>
                                </td>
                                <td class="align-top">
                                    <div class="flex items-center">
                                        <div class="adm-avatar is-sm is-gray mr-3">
                                            {{ substr($ticket->user->name, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-300">{{ $ticket->user->name }}</span>
                                            <span
                                                class="text-xs text-gray-500 truncate max-w-[200px]">{{ $ticket->user->email }}</span>
                                            @if($ticket->user->business)
                                                <span class="text-xs text-brand-400 mt-1 truncate max-w-[200px]"
                                                    title="{{ $ticket->user->business->name }}">
                                                    <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                        </path>
                                                    </svg>
                                                    {{ $ticket->user->business->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="align-top">
                                    <div class="flex flex-col items-start gap-2">
                                        @php
                                            $statusBadges = [
                                                'open' => 'is-green',
                                                'in_progress' => 'is-yellow',
                                                'resolved' => 'is-brand',
                                                'closed' => 'is-gray',
                                            ];
                                            $statusBadge = $statusBadges[$ticket->status] ?? 'is-gray';

                                            $priorityBadges = [
                                                'low' => 'is-gray',
                                                'medium' => 'is-brand',
                                                'high' => 'is-orange',
                                                'urgent' => 'is-red',
                                            ];
                                            $priorityBadge = $priorityBadges[$ticket->priority] ?? 'is-gray';
                                        @endphp
                                        <span class="adm-badge {{ $statusBadge }}">
                                            {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
                                        </span>
                                        <span
                                            class="adm-badge {{ $priorityBadge }} {{ $ticket->priority === 'urgent' ? 'animate-pulse' : '' }}">
                                            {{ $ticket->priority }}
                                        </span>
                                    </div>
                                </td>
                                <td class="align-top">
                                    <div class="text-sm text-gray-300">{{ $ticket->updated_at->diffForHumans() }}</div>
                                    <div class="text-xs text-gray-500 mt-1" title="{{ $ticket->created_at }}">Opened:
                                        {{ $ticket->created_at->format('M j, Y') }}</div>
                                </td>
                                <td class="align-top text-right">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.support.show', $ticket) }}" class="adm-icon-btn"
                                            title="Manage Ticket">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        <button wire:click="deleteTicket({{ $ticket->id }})"
                                            wire:confirm="Are you sure you want to delete this ticket and all its replies? This action cannot be undone."
                                            class="adm-icon-btn is-danger" title="Delete Ticket">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="adm-empty">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                            </path>
                                        </svg>
                                        <p class="title">No tickets found</p>
                                        <p class="sub">Try adjusting your filters or search query.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tickets->hasPages())
                <div class="adm-table-foot">
                    {{ $tickets->links(data: ['scrollTo' => false]) }}
                </div>
            @endif
        </div>
    </div>
</div>
