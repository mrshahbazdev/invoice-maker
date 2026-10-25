<div>
    <x-slot:title>
        Ticket #{{ $ticket->id }} - {{ $ticket->subject }}
    </x-slot:title>

    <div class="max-w-7xl mx-auto space-y-8">
        <div class="adm-head">
            <div>
                <div class="adm-breadcrumb">
                    <a href="{{ route('admin.support.index') }}">Support Tickets</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span>#{{ $ticket->id }}</span>
                </div>
                <h2 class="adm-title">
                    {{ $ticket->subject }}
                </h2>
                <div class="text-sm text-gray-400 mt-1 flex items-center gap-2">
                    <span>Opened by <span class="text-gray-300 font-medium">{{ $ticket->user->name }}</span> ({{ $ticket->user->email }})</span>
                    <span>&bull;</span>
                    <span>{{ $ticket->created_at->format('M j, Y g:i A') }}</span>
                </div>
            </div>

            <div class="mt-4 sm:mt-0 flex gap-2">
                @if($ticket->user->business)
                    <a href="{{ route('admin.businesses.index', ['search' => $ticket->user->business->name]) }}" class="adm-btn adm-btn-ghost adm-btn-sm" title="View Business">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $ticket->user->business->name }}
                    </a>
                @endif
                <a href="{{ route('admin.users.index', ['search' => $ticket->user->email]) }}" class="adm-btn adm-btn-ghost adm-btn-sm" title="View User">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    User Profile
                </a>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="adm-flash is-success">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ session('message') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- Left Column: Replies -->
            <div class="lg:col-span-3 space-y-6">
                <!-- Replies Thread -->
                <div class="space-y-6">
                    @foreach($replies as $reply)
                        <div class="adm-card adm-reply {{ $reply->user->is_super_admin ? 'is-staff' : '' }}">
                            <div class="flex items-center justify-between mb-4 pb-4" style="border-bottom: 1px solid var(--adm-border);">
                                <div class="flex items-center gap-3">
                                    @if($reply->user->is_super_admin)
                                        <div class="adm-avatar">
                                            {{ substr($reply->user->name, 0, 1) }}
                                        </div>
                                    @else
                                        <div class="adm-avatar is-gray">
                                            {{ substr($reply->user->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-white flex items-center gap-2">
                                            {{ $reply->user->name }}
                                            @if($reply->user->is_super_admin)
                                                <span class="adm-badge is-brand">Staff</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400" title="{{ $reply->created_at }}">
                                            {{ $reply->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="prose prose-invert max-w-none text-gray-300 text-sm whitespace-pre-wrap">{{ $reply->message }}</div>

                            @if($reply->attachment_path)
                                <div class="mt-4 pt-4" style="border-top: 1px solid var(--adm-border);">
                                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Attachment</h4>
                                    <a href="{{ str_starts_with($reply->attachment_path, 'private/') ? route('private-files.show', ['kind' => 'tickets', 'file' => basename($reply->attachment_path)]) : Storage::url($reply->attachment_path) }}" target="_blank" class="adm-btn adm-btn-ghost adm-btn-sm">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                        </svg>
                                        View Attachment
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Reply Form -->
                <div class="adm-card relative mt-8">
                    <div class="adm-reply-accent"></div>
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Post a Reply</h3>

                        <form wire:submit.prevent="reply" class="space-y-4">

                            <div>
                                <textarea wire:model.lazy="message" rows="5" class="adm-input custom-scrollbar" placeholder="Type your response to the client..."></textarea>
                                @error('message') <span class="adm-error">{{ $message }}</span> @enderror
                            </div>

                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <div class="flex items-center" x-data="{ fileName: '' }">
                                        <label class="adm-btn adm-btn-ghost adm-btn-sm adm-file-btn">
                                            <span class="flex items-center">
                                                <svg class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
                                                Attach File
                                            </span>
                                            <input type="file" wire:model="attachment" x-on:change="fileName = $event.target.files[0].name">
                                        </label>
                                        <span class="ml-3 text-sm text-gray-400" x-text="fileName"></span>
                                        <div wire:loading wire:target="attachment" class="ml-3 text-sm text-brand-400">
                                            Uploading...
                                        </div>
                                    </div>
                                    <p class="adm-hint">Optional. Max size: 5MB.</p>
                                    @error('attachment') <span class="adm-error">{{ $message }}</span> @enderror
                                </div>

                                <button type="submit" class="adm-btn adm-btn-primary w-full sm:w-auto" wire:loading.attr="disabled">
                                    <svg wire:loading wire:target="reply" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Send Reply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Ticket Management -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Ticket Details Widget -->
                <div class="adm-card p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        Manage Ticket
                    </h3>

                    <form wire:submit.prevent="updateTicketDetails" class="space-y-4">
                        <div>
                            <label class="adm-label">Status</label>
                            <select wire:model.lazy="status" class="adm-input">
                                <option value="open">Open</option>
                                <option value="in_progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>

                        <div>
                            <label class="adm-label">Priority</label>
                            <select wire:model.lazy="priority" class="adm-input">
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>

                        <div>
                            <label class="adm-label">Category</label>
                            <select wire:model.lazy="category" class="adm-input">
                                <option value="general">General</option>
                                <option value="technical">Technical</option>
                                <option value="billing">Billing</option>
                            </select>
                        </div>

                        <div class="pt-4 font-mono text-xs text-gray-500 mb-4 px-1 space-y-2" style="border-top: 1px solid var(--adm-border);">
                            <div><span class="text-gray-400">Last Replied:</span> {{ $ticket->updated_at->diffForHumans() }}</div>
                            <div><span class="text-gray-400">Total Replies:</span> {{ $replies->count() }}</div>
                        </div>

                        <button type="submit" class="adm-btn adm-btn-secondary adm-btn-block">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                            Update Ticket
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
