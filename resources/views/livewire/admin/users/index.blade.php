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
 placeholder="Search users by name or email...">
 </div>
 </div>

 <!-- Users Table -->
 <div class="bg-gray-800 shadow-sm rounded-xl border border-gray-700 overflow-hidden">
 <div class="overflow-x-auto">
 <table class="min-w-full divide-y divide-gray-700">
 <thead class="bg-gray-900/50">
 <tr>
 <th scope="col"
 class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
 User
 </th>
 <th scope="col"
 class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
 Role & Business
 </th>
 <th scope="col"
 class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
 Registered
 </th>
 <th scope="col"
 class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
 Status
 </th>
 <th scope="col"
 class="px-6 py-4 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">
 Actions
 </th>
 </tr>
 </thead>
 <tbody class="bg-gray-800 divide-y divide-gray-700/50">
 @forelse($users as $user)
 <tr class="hover:bg-gray-700/20 transition-colors">
 <td class="px-6 py-4 whitespace-nowrap">
 <div class="flex items-center">
 <div
 class="h-10 w-10 flex-shrink-0 rounded-full bg-brand-600 flex items-center justify-center text-white font-bold uppercase shadow-inner">
 {{ substr($user->name, 0, 1) }}
 </div>
 <div class="ml-4">
 <div class="text-sm font-medium text-white flex items-center gap-2">
 {{ $user->name }}
 @if($user->is_super_admin)
 <span
 class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30">
 Super Admin
 </span>
 @endif
 </div>
 <div class="text-sm text-gray-400">{{ $user->email }}</div>
 </div>
 </div>
 </td>
 <td class="px-6 py-4 whitespace-nowrap">
 <div class="text-sm text-gray-300 capitalize">{{ $user->role ?? 'N/A' }}</div>
 <div class="text-xs text-gray-500">{{ $user->business?->name ?? 'No Business' }}</div>
 </td>
 <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
 {{ $user->created_at->format('M j, Y') }}
 </td>
 <td class="px-6 py-4 whitespace-nowrap">
 @if($user->is_active)
 <span
 class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
 Active
 </span>
 @else
 <span
 class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-500/20 text-red-400 border border-red-500/30">
 Suspended
 </span>
 @endif
 </td>
 <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
 @if(!$user->is_super_admin)
 <button wire:click="impersonate({{ $user->id }})"
 class="text-brand-400 hover:text-brand-300 transition-colors">
 Login As
 </button>

 <button wire:click="toggleActive({{ $user->id }})"
 class="{{ $user->is_active ? 'text-red-400 hover:text-red-300' : 'text-green-400 hover:text-green-300' }} transition-colors">
 {{ $user->is_active ? 'Suspend' : 'Activate' }}
 </button>
 @endif
 </td>
 </tr>
 @empty
 <tr>
 <td colspan="5" class="px-6 py-10 text-center text-gray-400">
 No users found matching your search.
 </td>
 </tr>
 @endforelse
 </tbody>
 </table>
 </div>
 @if($users->hasPages())
 <div class="px-6 py-4 border-t border-gray-700 bg-gray-900/30">
 {{ $users->links() }}
 </div>
 @endif
 </div>
</div>