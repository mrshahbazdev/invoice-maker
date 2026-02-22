@php $title = 'Clients'; @endphp

<div>
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Clients</h2>
            <p class="text-gray-600">Manage your client list</p>
        </div>
        <a href="{{ route('clients.create') }}"
            class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-200 text-center">
            + Add Client
        </a>
    </div>

    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search clients..."
                class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b bg-gray-50">
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700 cursor-pointer"
                            wire:click="sortBy('name')">
                            Name
                            @if($sortBy === 'name')
                                <span>{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Email</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Company</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Phone</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4 font-medium text-gray-900">{{ $client->name }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $client->email ?? '-' }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $client->company_name ?? '-' }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $client->phone ?? '-' }}</td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('clients.edit', $client) }}"
                                        class="text-blue-600 hover:text-blue-700 text-sm font-medium">Edit</a>
                                    <button wire:click="delete({{ $client->id }})"
                                        wire:confirm="Are you sure you want to delete this client?"
                                        class="text-red-600 hover:text-red-700 text-sm font-medium">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">
                                No clients found. <a href="{{ route('clients.create') }}"
                                    class="text-blue-600 hover:text-blue-700">Add your first client</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($clients->hasPages())
            <div class="p-4 border-t flex justify-between items-center">
                <span class="text-sm text-gray-600">
                    Showing {{ $clients->firstItem() }} to {{ $clients->lastItem() }} of {{ $clients->total() }} results
                </span>
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</div>