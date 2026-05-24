<div>
 <x-slot:title>
 Support Tickets Management
 </x-slot:title>

 <div class="max-w-7xl mx-auto space-y-8">
 <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
 <div>
 <h2 class="text-2xl font-bold font-heading text-white">Support Tickets</h2>
 <p class="text-gray-400 mt-1">Manage and respond to client support requests.</p>
 </div>
 <div class="mt-4 sm:mt-0">
 <div class="flex gap-2">
 <!-- Stat boxes -->
 <div class="bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-center">
 <div class="text-xs text-gray-500 uppercase tracking-wider">Open</div>
 <div class="text-lg font-bold text-green-400">
 {{ \App\Models\Ticket::where('status', 'open')->count() }}</div>
 </div>
 <div class="bg-gray-800 border border-gray-700 rounded-lg px-4 py-2 text-center">
 <div class="text-xs text-gray-500 uppercase tracking-wider">Urgent</div>
 <div class="text-lg font-bold text-red-500">
 {{ \App\Models\Ticket::where('priority', 'urgent')->whereIn('status', ['open', 'in_progress'])->count() }}
 </div>
 </div>
 </div>
 </div>
 </div>

 @if (session()->has('message'))
 <div
 class="mb-6 bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl flex items-center">
 <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
 </svg>
 {{ session('message') }}
 </div>
 @endif

 <div class="bg-gray-800 rounded-2xl border border-gray-700 shadow-sm overflow-hidden">
 <!-- Filters -->
 <div class="p-6 border-b border-gray-700 bg-gray-800/50">
 <div class="grid grid-cols-1 md:grid-cols-4 gap-4 w-full">
 <div class="w-full">
 <label
 class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Search</label>
 <div class="relative w-full">
 <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
 <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
 stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
 </svg>
 </div>
 <input wire:model.live.debounce.300ms="search" type="text"
 class="block w-full pl-10 bg-gray-900 border border-gray-700 rounded-xl text-gray-300 focus:ring-brand-500 focus:border-brand-500 sm:text-sm py-2"
 placeholder="Search ID, subject, email...">
 </div>
 </div>
 <div class="w-full">
 <label
 class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Status</label>
 <select wire:model.live="status"
 class="block w-full bg-gray-900 border border-gray-700 rounded-xl text-gray-300 focus:ring-brand-500 focus:border-brand-500 sm:text-sm py-2">
 <option value="">All Statuses</option>
 <option value="open">Open</option>
 <option value="in_progress">In Progress</option>
 <option value="resolved">Resolved</option>
 <option value="closed">Closed</option>
 </select>
 </div>
 <div class="w-full">
 <label
 class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Priority</label>
 <select wire:model.live="priority"
 class="block w-full bg-gray-900 border border-gray-700 rounded-xl text-gray-300 focus:ring-brand-500 focus:border-brand-500 sm:text-sm py-2">
 <option value="">All Priorities</option>
 <option value="low">Low</option>
 <option value="medium">Medium</option>
 <option value="high">High</option>
 <option value="urgent">Urgent</option>
 </select>
 </div>
 <div class="w-full">
 <label
 class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Category</label>
 <select wire:model.live="category"
 class="block w-full bg-gray-900 border border-gray-700 rounded-xl text-gray-300 focus:ring-brand-500 focus:border-brand-500 sm:text-sm py-2">
 <option value="">All Categories</option>
 <option value="general">General</option>
 <option value="technical">Technical</option>
 <option value="billing">Billing</option>
 </select>
 </div>
 </div>
 </div>

 <div class="overflow-x-auto relative">
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
 <table class="w-full text-left border-collapse">
 <thead>
 <tr class="bg-gray-800/80 border-b border-gray-700">
 <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Ticket
 Info</th>
 <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">User /
 Business</th>
 <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Status /
 Priority</th>
 <th class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider">Last
 Activity</th>
 <th
 class="py-4 px-6 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">
 Actions</th>
 </tr>
 </thead>
 <tbody class="divide-y divide-gray-700/50">
 @forelse($tickets as $ticket)
 <tr class="hover:bg-gray-700/30 transition-colors group">
 <td class="py-4 px-6 align-top">
 <div class="flex flex-col">
 <a href="{{ route('admin.support.show', $ticket) }}"
 class="font-bold text-white hover:text-brand-400 transition-colors truncate max-w-[250px] inline-block"
 title="{{ $ticket->subject }}">
 #{{ $ticket->id }} - {{ $ticket->subject }}
 </a>
 <span
 class="text-xs text-gray-500 mt-1 uppercase tracking-wider">{{ ucfirst($ticket->category) }}</span>
 </div>
 </td>
 <td class="py-4 px-6 align-top">
 <div class="flex items-center">
 <div
 class="h-8 w-8 rounded-full bg-gray-700 flex items-center justify-center text-white font-bold mr-3">
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
 <td class="py-4 px-6 align-top">
 <div class="flex flex-col items-start gap-2">
 @php
 $statusColors = [
 'open' => 'bg-green-500/10 text-green-400 border-green-500/20',
 'in_progress' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
 'resolved' => 'bg-brand-500/10 text-brand-400 border-brand-500/20',
 'closed' => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
 ];
 $statusColor = $statusColors[$ticket->status] ?? 'bg-gray-500/10 text-gray-400 border-gray-500/20';

 $priorityColors = [
 'low' => 'text-gray-400 bg-gray-900 border-gray-700',
 'medium' => 'text-brand-400 bg-brand-900/30 border-brand-700/50',
 'high' => 'text-orange-400 font-bold bg-orange-900/30 border-orange-700/50',
 'urgent' => 'text-red-400 font-bold bg-red-900/30 border-red-700/50 animate-pulse',
 ];
 $priorityColor = $priorityColors[$ticket->priority] ?? 'text-gray-400 bg-gray-900 border-gray-700';
 @endphp
 <span
 class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-md border {{ $statusColor }}">
 {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
 </span>
 <span
 class="px-2 py-0.5 inline-flex text-[10px] leading-4 font-semibold uppercase tracking-wider rounded border {{ $priorityColor }}">
 {{ $ticket->priority }}
 </span>
 </div>
 </td>
 <td class="py-4 px-6 align-top">
 <div class="text-sm text-gray-300">{{ $ticket->updated_at->diffForHumans() }}</div>
 <div class="text-xs text-gray-500 mt-1" title="{{ $ticket->created_at }}">Opened:
 {{ $ticket->created_at->format('M j, Y') }}</div>
 </td>
 <td class="py-4 px-6 align-top text-right">
 <div class="flex justify-end gap-2">
 <a href="{{ route('admin.support.show', $ticket) }}"
 class="p-2 text-brand-400 bg-brand-500/10 hover:bg-brand-500/20 rounded-lg transition-colors"
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
 class="p-2 text-red-400 bg-red-500/10 hover:bg-red-500/20 rounded-lg transition-colors"
 title="Delete Ticket">
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
 <td colspan="5" class="py-12 text-center text-gray-500">
 <div class="flex flex-col items-center justify-center">
 <svg class="w-12 h-12 text-txmain mb-4" fill="none" stroke="currentColor"
 viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
 </path>
 </svg>
 <p class="text-lg font-medium text-gray-400">No tickets found</p>
 <p class="text-sm mt-1">Try adjusting your filters or search query.</p>
 </div>
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>

 @if($tickets->hasPages())
 <div class="p-4 border-t border-gray-700 bg-gray-800/50">
 {{ $tickets->links(data: ['scrollTo' => false]) }}
 </div>
 @endif
 </div>
 </div>
</div>