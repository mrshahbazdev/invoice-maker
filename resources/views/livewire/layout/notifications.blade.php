<div>
    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
        <!-- Bell Icon with Badge -->
        <button @click="open = !open" type="button"
            class="relative p-2 text-gray-500 hover:text-brand-600 focus:outline-none transition-colors border border-gray-200 rounded-md bg-card sm:bg-transparent flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                </path>
            </svg>

            @if($unreadCount > 0)
                <span
                    class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
        </button>

        <!-- Dropdown Panel -->
        <div x-show="open" x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 mt-2 w-80 bg-card rounded-md shadow-lg border border-gray-100 ring-1 ring-black ring-opacity-5 z-50 overflow-hidden"
            style="display: none;">

            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                <h3 class="text-sm font-bold text-gray-800">Notifications</h3>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-xs text-brand-600 hover:text-brand-800 font-medium ml-2">
                        Mark all as read
                    </button>
                @endif
            </div>

            <div class="max-h-96 overflow-y-auto">
                @if(count($unreadNotifications) > 0)
                    <ul class="divide-y divide-gray-100">
                        @foreach($unreadNotifications as $notification)
                            <li class="p-4 hover:bg-gray-50 transition duration-150 ease-in-out cursor-pointer"
                                wire:click="markAsRead('{{ $notification->id }}', '{{ $notification->data['url'] ?? '#' }}')">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 pt-0.5">
                                        @if(($notification->data['type'] ?? '') === 'estimate_accepted')
                                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                        @elseif(($notification->data['type'] ?? '') === 'invoice_paid')
                                            <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        @elseif(($notification->data['type'] ?? '') === 'late_fee_applied')
                                            <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-red-600" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                        @else
                                            <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="h-4 w-4 text-gray-600" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-3 w-0 flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $notification->data['message'] ?? 'Notification' }}
                                        </p>
                                        <p class="mt-1 text-xs text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-6 text-center text-sm text-gray-500">
                        <svg class="mx-auto h-8 w-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        You have no unread notifications.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>