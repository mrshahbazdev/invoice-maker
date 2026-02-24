<div class="space-y-6">
    <!-- Admin KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between z-10 relative">
                <div>
                    <p class="text-sm font-medium text-gray-400 mb-1">Total Users</p>
                    <h3 class="text-3xl font-bold text-white">{{ \App\Models\User::count() }}</h3>
                </div>
                <div class="p-3 bg-indigo-500/20 text-indigo-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div
                class="absolute -bottom-4 -right-4 w-24 h-24 bg-gradient-to-br from-indigo-500/10 to-transparent rounded-full blur-2xl z-0">
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between z-10 relative">
                <div>
                    <p class="text-sm font-medium text-gray-400 mb-1">Total Businesses</p>
                    <h3 class="text-3xl font-bold text-white">{{ \App\Models\Business::count() }}</h3>
                </div>
                <div class="p-3 bg-teal-500/20 text-teal-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div
                class="absolute -bottom-4 -right-4 w-24 h-24 bg-gradient-to-br from-teal-500/10 to-transparent rounded-full blur-2xl z-0">
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between z-10 relative">
                <div>
                    <p class="text-sm font-medium text-gray-400 mb-1">Invoices Generated</p>
                    <h3 class="text-3xl font-bold text-white">{{ \App\Models\Invoice::count() }}</h3>
                </div>
                <div class="p-3 bg-blue-500/20 text-blue-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div
                class="absolute -bottom-4 -right-4 w-24 h-24 bg-gradient-to-br from-blue-500/10 to-transparent rounded-full blur-2xl z-0">
            </div>
        </div>

        <div class="bg-gray-800 rounded-2xl p-6 border border-gray-700 shadow-sm relative overflow-hidden">
            <div class="flex items-center justify-between z-10 relative">
                <div>
                    <p class="text-sm font-medium text-gray-400 mb-1">Est. MRR (Demo)</p>
                    <h3 class="text-3xl font-bold text-white">$0</h3>
                </div>
                <div class="p-3 bg-emerald-500/20 text-emerald-400 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div
                class="absolute -bottom-4 -right-4 w-24 h-24 bg-gradient-to-br from-emerald-500/10 to-transparent rounded-full blur-2xl z-0">
            </div>
        </div>
    </div>

    <!-- Recent Users Setup -->
    <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden mt-6">
        <div class="px-6 py-4 border-b border-gray-700 bg-gray-900/50">
            <h2 class="text-lg font-semibold text-white">Recent Users</h2>
        </div>
        <div class="divide-y divide-gray-700/50">
            @foreach(\App\Models\User::latest()->take(5)->get() as $user)
                <div class="p-4 flex items-center justify-between hover:bg-gray-700/20 transition-colors">
                    <div class="flex items-center">
                        <div
                            class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold uppercase shadow-inner">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                            <div class="text-xs text-gray-400">{{ $user->email }}</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-400">
                        {{ $user->created_at->diffForHumans() }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>