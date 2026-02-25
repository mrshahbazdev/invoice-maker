<div class="max-w-5xl mx-auto space-y-6">
 <div class="flex justify-between items-center mb-6">
 <div>
 <div class="flex items-center space-x-2">
 <a href="{{ route('admin.blog.index') }}" class="text-brand-400 hover:text-brand-300">Blog Posts</a>
 <span class="text-gray-500">/</span>
 <h2 class="text-2xl font-bold font-heading text-white">Edit Post</h2>
 </div>
 </div>
 <button wire:click="save"
 class="px-6 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-xl font-bold shadow-lg shadow-brand-500/20 transition-all">
 Update Post
 </button>
 </div>

 <form wire:submit.prevent="save" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
 <!-- Main Content Column -->
 <div class="lg:col-span-2 space-y-6">
 <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 shadow-sm">
 <div class="space-y-4">
 <div>
 <label class="block text-sm font-medium text-gray-400 mb-1">Title <span
 class="text-red-500">*</span></label>
 <input type="text" wire:model.live.debounce.500ms="title"
 class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500 text-lg font-medium placeholder-gray-600"
 required>
 @error('title') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
 </div>

 <div>
 <label class="block text-sm font-medium text-gray-400 mb-1">Content <span
 class="text-red-500">*</span></label>

 <!-- Include Quill CSS and JS -->
 <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
 <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

 <!-- Quill Editor Container mapped to Livewire property via Alpine -->
 <div x-data="{
 content: @entangle('content'),
 quill: null
 }" x-init="
 quill = new Quill($refs.quillEditor, {
 theme: 'snow',
 placeholder: 'Write your post content here...',
 modules: {
 toolbar: [
 [{ header: [2, 3, 4, false] }],
 ['bold', 'italic', 'underline', 'strike'],
 [{ list: 'ordered' }, { list: 'bullet' }],
 ['link', 'blockquote', 'code-block', 'image'],
 ['clean']
 ]
 }
 });
 // Set initial content
 if (content) {
 quill.root.innerHTML = content;
 }
 // Update Livewire component on change
 quill.on('text-change', function () {
 content = quill.root.innerHTML;
 });
 " class="rounded-xl border border-gray-700 overflow-hidden bg-gray-900">
 <div wire:ignore>
 <div x-ref="quillEditor" class="text-white min-h-[400px]"></div>
 </div>
 </div>

 <!-- Override default Quill styles for dark mode -->
 <style>
 .ql-toolbar.ql-snow {
 border: none !important;
 border-bottom: 1px solid #374151 !important;
 background-color: #1f2937 !important;
 border-radius: 0.75rem 0.75rem 0 0;
 }

 .ql-container.ql-snow {
 border: none !important;
 color: white !important;
 font-size: 1rem !important;
 font-family: inherit !important;
 }

 .ql-editor.ql-blank::before {
 color: #9ca3af !important;
 font-style: normal !important;
 }

 .ql-snow .ql-stroke {
 stroke: #d1d5db !important;
 }

 .ql-snow .ql-fill,
 .ql-snow .ql-stroke.ql-fill {
 fill: #d1d5db !important;
 }

 .ql-snow .ql-picker {
 color: #d1d5db !important;
 }

 .ql-snow .ql-picker-options {
 background-color: #374151 !important;
 border: 1px solid #4b5563 !important;
 }

 .ql-editor {
 padding: 1.5rem !important;
 }
 </style>

 @error('content') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
 </div>

 <div>
 <label class="block text-sm font-medium text-gray-400 mb-1">Excerpt</label>
 <textarea wire:model="excerpt" rows="3"
 class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500 text-sm"></textarea>
 @error('excerpt') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
 </div>
 </div>
 </div>

 <!-- SEO Settings -->
 <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 shadow-sm">
 <h3 class="text-lg font-bold text-white mb-4">SEO Settings</h3>
 <div class="space-y-4">
 <div>
 <label class="block text-sm font-medium text-gray-400 mb-1">Meta Title</label>
 <input type="text" wire:model="meta_title"
 class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500 text-sm">
 </div>
 <div>
 <label class="block text-sm font-medium text-gray-400 mb-1">Meta Description</label>
 <textarea wire:model="meta_description" rows="2"
 class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500 text-sm"></textarea>
 </div>
 </div>
 </div>
 </div>

 <!-- Sidebar Settings Column -->
 <div class="space-y-6">
 <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 shadow-sm">
 <h3 class="text-lg font-bold text-white mb-4">Publishing</h3>

 <div class="space-y-4">
 <div class="flex items-center justify-between p-3 bg-gray-900 rounded-xl border border-gray-700">
 <span class="text-sm font-medium text-gray-300">Publish Post</span>
 <label class="relative inline-flex items-center cursor-pointer">
 <input type="checkbox" wire:model="is_published" class="sr-only peer">
 <div
 class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-brand-500">
 </div>
 </label>
 </div>

 <div class="pt-4 border-t border-gray-700">
 <label class="block text-sm font-medium text-gray-400 mb-1">URL Slug <span
 class="text-red-500">*</span></label>
 <input type="text" wire:model="slug"
 class="w-full bg-gray-900 border border-gray-700 text-gray-300 rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500 text-sm font-mono"
 required>
 @error('slug') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
 </div>

 <div>
 <label class="block text-sm font-medium text-gray-400 mb-1">Category</label>
 <select wire:model="category_id"
 class="w-full bg-gray-900 border border-gray-700 text-white rounded-xl px-4 py-2 focus:ring-brand-500 focus:border-brand-500 text-sm">
 <option value="">Uncategorized</option>
 @foreach($categories as $category)
 <option value="{{ $category->id }}">{{ $category->name }}</option>
 @endforeach
 </select>
 </div>
 </div>
 </div>

 <div class="bg-gray-800 rounded-2xl border border-gray-700 p-6 shadow-sm">
 <h3 class="text-lg font-bold text-white mb-4">Featured Image</h3>

 <div class="space-y-4">
 @if($new_featured_image)
 <div class="relative rounded-xl overflow-hidden border border-gray-700 bg-gray-900">
 <img src="{{ $new_featured_image->temporaryUrl() }}"
 class="w-full h-auto object-cover max-h-48">
 <button type="button" wire:click="$set('new_featured_image', null)"
 class="absolute top-2 right-2 bg-red-600/90 text-white p-1 rounded-md hover:bg-red-700">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M6 18L18 6M6 6l12 12"></path>
 </svg>
 </button>
 </div>
 @elseif($featured_image)
 <div class="relative rounded-xl overflow-hidden border border-gray-700 bg-gray-900">
 <img src="{{ Storage::url($featured_image) }}" class="w-full h-auto object-cover max-h-48">
 <button type="button" wire:click="$set('featured_image', null)"
 class="absolute top-2 right-2 bg-red-600/90 text-white p-1 rounded-md hover:bg-red-700">
 <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
 d="M6 18L18 6M6 6l12 12"></path>
 </svg>
 </button>
 </div>
 @else
 <div
 class="border-2 border-dashed border-gray-600 rounded-xl p-6 text-center hover:bg-gray-700/50 transition bg-gray-900">
 <input type="file" wire:model="new_featured_image" id="new_featured_image" class="hidden"
 accept="image/*">
 <label for="new_featured_image" class="cursor-pointer flex flex-col items-center">
 <svg class="mx-auto h-10 w-10 text-gray-500 mb-2" stroke="currentColor" fill="none"
 viewBox="0 0 48 48">
 <path
 d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
 stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
 </svg>
 <span class="text-brand-400 text-sm font-medium hover:text-brand-300">Upload New</span>
 <span class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</span>
 </label>
 </div>
 @endif
 @error('new_featured_image') <span class="text-red-400 text-xs block">{{ $message }}</span>
 @enderror
 </div>
 </div>
 </div>
 </form>
</div>