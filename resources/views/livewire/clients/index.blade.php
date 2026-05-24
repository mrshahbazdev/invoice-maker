@php $title = __('Clients'); @endphp

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-txmain">{{ __('Clients') }}</h2>
            <p class="text-txmain">{{ __('Manage your client list') }}</p>
        </div>
        <a href="{{ route('clients.create') }}"
            class="bg-brand-600 text-white py-2 px-4 rounded-lg hover:bg-brand-700 transition duration-200 text-center">
            + {{ __('Add Client') }}
        </a>
    </div>

    <div class="bg-card rounded-lg shadow">
        <div class="p-4 border-b">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ __('Search clients...') }}"
                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-transparent">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b bg-page">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-txmain cursor-pointer"
                            wire:click="sortBy('name')">
                            {{ __('Name') }}
                            @if($sortBy === 'name')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-txmain">{{ __('Email') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-txmain">{{ __('Company') }}</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-txmain">{{ __('Phone') }}</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-txmain">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr class="border-b hover:bg-page">
                            <td class="py-3 px-4 font-medium text-txmain">{{ $client->name }}</td>
                            <td class="py-3 px-4 text-txmain">{{ $client->email ?? '-' }}</td>
                            <td class="py-3 px-4 text-txmain">{{ $client->company_name ?? '-' }}</td>
                            <td class="py-3 px-4 text-txmain">{{ $client->phone ?? '-' }}</td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex justify-end gap-2 items-center">
                                    <button
                                        onclick="copyToClipboard('{{ URL::signedRoute('client.portal', $client->id) }}')"
                                        title="{{ __('Copy Client Portal Link') }}"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium mr-2">
                                        <svg class="w-4 h-4 inline-block -mt-1 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                            </path>
                                        </svg>{{ __('Portal') }}</button>
                                    <a href="{{ route('clients.edit', $client) }}"
                                        class="text-brand-600 hover:text-brand-700 text-sm font-medium">{{ __('Edit') }}</a>
                                    <button wire:click="delete({{ $client->id }})"
                                        wire:confirm="{{ __('Are you sure you want to delete this client?') }}"
                                        class="text-red-600 hover:text-red-700 text-sm font-medium">{{ __('Delete') }}</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                {{ __('No clients found.') }} <a href="{{ route('clients.create') }}"
                                    class="text-brand-600 hover:text-brand-700">{{ __('Add your first client') }}</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clients->hasPages())
            <div class="p-4 border-t flex justify-between items-center">
                <span class="text-sm text-txmain">
                    {{ __('Showing') }} {{ $clients->firstItem() }} {{ __('to') }} {{ $clients->lastItem() }} {{ __('of') }}
                    {{ $clients->total() }} {{ __('results') }}
                </span>
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function () {
            alert('{{ __('Client Portal Link copied to clipboard!') }}');
        }, function (err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>