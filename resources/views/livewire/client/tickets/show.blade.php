<div>
 <x-slot name="header">
 <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
 <div>
 <div class="flex items-center text-sm text-gray-500 mb-2">
 <a href="{{ route('client.tickets.index') }}" class="hover:text-brand-600 transition-colors">Support Tickets</a>
 <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
 <span>#{{ $ticket->id }}</span>
 </div>
 <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
 {{ $ticket->subject }}
 </h2>
 <div class="flex items-center gap-3 mt-2">
 @php
 $statusColors = [
 'open' => 'bg-green-100 text-green-800',
 'in_progress' => 'bg-yellow-100 text-yellow-800',
 'resolved' => 'bg-brand-100 text-brand-800',
 'closed' => 'bg-gray-100 text-gray-800',
 ];
 $statusColor = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800';

 $priorityColors = [
 'low' => 'text-gray-600',
 'medium' => 'text-brand-600',
 'high' => 'text-orange-600 font-bold',
 'urgent' => 'text-red-600 font-bold',
 ];
 $priorityColor = $priorityColors[$ticket->priority] ?? 'text-gray-600';
 @endphp
 <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
 {{ str_replace('_', ' ', ucfirst($ticket->status)) }}
 </span>
 <span class="text-sm {{ $priorityColor }}">
 Priority: {{ ucfirst($ticket->priority) }}
 </span>
 <span class="text-sm text-gray-500">
 Category: {{ ucfirst($ticket->category) }}
 </span>
 <span class="text-sm text-gray-500">
 Opened: {{ $ticket->created_at->format('M j, Y g:i A') }}
 </span>
 </div>
 </div>
 </div>
 </x-slot>

 <div class="py-12">
 <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

 @if (session()->has('message'))
 <div class="bg-green-50 border-l-4 border-green-400 p-4">
 <div class="flex">
 <div class="flex-shrink-0">
 <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
 <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
 </svg>
 </div>
 <div class="ml-3">
 <p class="text-sm text-green-700">
 {{ session('message') }}
 </p>
 </div>
 </div>
 </div>
 @endif

 <!-- Replies Thread -->
 <div class="space-y-6">
 @foreach($replies as $reply)
 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border {{ $reply->user->is_super_admin ? 'border-brand-200' : 'border-gray-200' }}">
 <div class="p-6">
 <div class="flex items-center justify-between mb-4 pb-4 border-b border-gray-100">
 <div class="flex items-center gap-3">
 <div class="h-10 w-10 rounded-full bg-{{ $reply->user->is_super_admin ? 'indigo' : 'gray' }}-100 flex items-center justify-center text-{{ $reply->user->is_super_admin ? 'indigo' : 'gray' }}-700 font-bold text-lg">
 {{ substr($reply->user->name, 0, 1) }}
 </div>
 <div>
 <div class="font-bold text-gray-900 flex items-center gap-2">
 {{ $reply->user->name }}
 @if($reply->user->is_super_admin)
 <span class="px-2 py-0.5 rounded-full bg-brand-100 text-brand-800 text-xs font-medium">Support Team</span>
 @endif
 </div>
 <div class="text-xs text-gray-500" title="{{ $reply->created_at }}">
 {{ $reply->created_at->diffForHumans() }}
 </div>
 </div>
 </div>
 </div>
 
 <div class="prose max-w-none text-gray-800 text-sm whitespace-pre-wrap">{{ $reply->message }}</div>
 
 @if($reply->attachment_path)
 <div class="mt-4 pt-4 border-t border-gray-100">
 <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Attachment</h4>
 <a href="{{ Storage::url($reply->attachment_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500 transition-colors">
 <svg class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
 </svg>
 View Attachment
 </a>
 </div>
 @endif
 </div>
 </div>
 @endforeach
 </div>

 <!-- Reply Form -->
 <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
 <div class="p-6 bg-gray-50 border-t border-gray-200">
 <h3 class="text-lg font-medium text-gray-900 mb-4">Post a Reply</h3>
 
 <form wire:submit.prevent="reply" class="space-y-4">
 
 <div>
 <textarea wire:model.defer="message" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm" placeholder="Type your reply here..."></textarea>
 @error('message') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
 </div>

 <div>
 <div class="flex items-center" x-data="{ fileName: '' }">
 <label class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-500">
 <span class="flex items-center">
 <svg class="h-4 w-4 mr-1.5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" /></svg>
 Attach File
 </span>
 <input type="file" wire:model="attachment" class="sr-only" x-on:change="fileName = $event.target.files[0].name">
 </label>
 <span class="ml-3 text-sm text-gray-500" x-text="fileName"></span>
 <div wire:loading wire:target="attachment" class="ml-3 text-sm text-brand-500">
 Uploading...
 </div>
 </div>
 <p class="text-xs text-gray-400 mt-1">Optional. Max size: 5MB.</p>
 @error('attachment') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
 </div>

 <div class="flex justify-end pt-2">
 <button type="submit" class="inline-flex justify-center items-center rounded-md border border-transparent bg-brand-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-colors disabled:opacity-50" wire:loading.attr="disabled">
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
 </div>
</div>
