<div>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <a href="{{ route('client.tickets.index') }}"
                        class="hover:text-brand-600 transition-colors">Support Tickets</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span>Create New Ticket</span>
                </div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Open a Support Request') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Please provide details so we can assist you better.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">

                    <form wire:submit.prevent="createTicket" class="space-y-6">

                        <!-- Subject -->
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject <span
                                    class="text-red-500">*</span></label>
                            <input type="text" wire:model.defer="subject" id="subject"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm"
                                placeholder="Brief summary of your issue">
                            @error('subject') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category <span
                                        class="text-red-500">*</span></label>
                                <select wire:model.defer="category" id="category"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                    <option value="general">General Inquiry</option>
                                    <option value="technical">Technical Support</option>
                                    <option value="billing">Billing Issue</option>
                                </select>
                                @error('category') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Priority -->
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700">Priority <span
                                        class="text-red-500">*</span></label>
                                <select wire:model.defer="priority" id="priority"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                                @error('priority') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Message <span
                                    class="text-red-500">*</span></label>
                            <textarea wire:model.defer="message" id="message" rows="8"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 sm:text-sm"
                                placeholder="Please describe your issue in detail..."></textarea>
                            @error('message') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label for="attachment" class="block text-sm font-medium text-gray-700">Attachment
                                (Optional)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative"
                                x-data="{ isUploading: false, progress: 0 }"
                                x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file-upload"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-brand-600 hover:text-brand-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-500">
                                            <span>Upload a file</span>
                                            <input id="file-upload" wire:model="attachment" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">
                                        Images or PDF up to 5MB
                                    </p>
                                </div>
                                <div x-show="isUploading"
                                    class="absolute inset-x-0 bottom-0 bg-brand-100 rounded-b-md h-1">
                                    <div class="bg-brand-600 h-1 rounded-bl-md" x-bind:style="`width: ${progress}%`">
                                    </div>
                                </div>
                            </div>
                            @if($attachment)
                                <div class="mt-2 flex items-center text-sm text-green-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    File attached: {{ $attachment->getClientOriginalName() }}
                                </div>
                            @endif
                            @error('attachment') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Form Actions -->
                        <div class="pt-4 flex items-center justify-end space-x-4 border-t border-gray-100">
                            <a href="{{ route('client.tickets.index') }}"
                                class="text-gray-600 hover:text-gray-900 font-medium text-sm transition-colors">Cancel</a>
                            <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-brand-600 py-2 px-6 text-sm font-bold text-white shadow-sm hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-colors">
                                Submit Ticket
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>