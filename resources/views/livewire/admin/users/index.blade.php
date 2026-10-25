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
                placeholder="Search users by name or email...">
        </div>
    </div>

    <!-- Users Table -->
    <div class="adm-card">
        <div class="adm-table-wrap">
            <table class="adm-table">
                <thead>
                    <tr>
                        <th scope="col">User</th>
                        <th scope="col">Role &amp; Business</th>
                        <th scope="col">Registered</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <div class="adm-avatar">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-white flex items-center gap-2">
                                            {{ $user->name }}
                                            @if($user->is_super_admin)
                                                <span class="adm-badge is-purple">
                                                    Super Admin
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-sm text-gray-400">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap">
                                <div class="text-sm text-gray-300 capitalize">{{ $user->role ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $user->business?->name ?? 'No Business' }}</div>
                            </td>
                            <td class="whitespace-nowrap text-sm text-gray-400">
                                {{ $user->created_at->format('M j, Y') }}
                            </td>
                            <td class="whitespace-nowrap">
                                @if($user->is_active)
                                    <span class="adm-badge is-green">
                                        Active
                                    </span>
                                @else
                                    <span class="adm-badge is-red">
                                        Suspended
                                    </span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap text-right text-sm font-medium">
                                @if(!$user->is_super_admin)
                                    <button wire:click="impersonate({{ $user->id }})" class="adm-link mr-3">
                                        Login As
                                    </button>

                                    <button wire:click="toggleActive({{ $user->id }})"
                                        class="{{ $user->is_active ? 'adm-link adm-link-danger' : 'adm-link' }}">
                                        {{ $user->is_active ? 'Suspend' : 'Activate' }}
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="adm-empty">
                                No users found matching your search.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="adm-table-foot">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</div>
