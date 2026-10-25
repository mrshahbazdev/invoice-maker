<div class="space-y-6">
    <!-- Admin KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="adm-card adm-stat">
            <div class="flex items-center justify-between relative" style="z-index: 1;">
                <div>
                    <p class="adm-stat-label">Total Users</p>
                    <h3 class="adm-stat-value">{{ number_format($totalUsers) }}</h3>
                </div>
                <div class="adm-stat-icon" style="background: rgba(255, 140, 0, .14); color: #ffb454;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="adm-stat-glow"></div>
        </div>

        <div class="adm-card adm-stat">
            <div class="flex items-center justify-between relative" style="z-index: 1;">
                <div>
                    <p class="adm-stat-label">Total Businesses</p>
                    <h3 class="adm-stat-value">{{ number_format($totalBusinesses) }}</h3>
                </div>
                <div class="adm-stat-icon" style="background: rgba(45, 212, 191, .12); color: #5eead4;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="adm-stat-glow"></div>
        </div>

        <div class="adm-card adm-stat">
            <div class="flex items-center justify-between relative" style="z-index: 1;">
                <div>
                    <p class="adm-stat-label">Invoices Generated</p>
                    <h3 class="adm-stat-value">{{ number_format($invoicesGenerated) }}</h3>
                </div>
                <div class="adm-stat-icon" style="background: rgba(255, 140, 0, .14); color: #ffb454;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="adm-stat-glow"></div>
        </div>

        <div class="adm-card adm-stat">
            <div class="flex items-center justify-between relative" style="z-index: 1;">
                <div>
                    <p class="adm-stat-label">Total Revenue (Paid)</p>
                    <h3 class="adm-stat-value">${{ number_format($totalRevenue, 2) }}</h3>
                </div>
                <div class="adm-stat-icon" style="background: rgba(52, 211, 153, .12); color: #6ee7b7;">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="adm-stat-glow"></div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="adm-card">
        <div class="adm-card-head">
            <h3>Recent Users</h3>
        </div>
        <div class="adm-stack">
            @foreach($recentUsers as $user)
                <div class="flex items-center justify-between px-6 py-4 hover:bg-white/[.03] transition-colors">
                    <div class="flex items-center">
                        <div class="adm-avatar">
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
