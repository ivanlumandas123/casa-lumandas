<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    @php
        $isAdmin = auth()->user()->isAdmin();
        $bookings = $isAdmin
            ? \App\Models\Booking::with(['user', 'room'])->get()
            : auth()->user()->bookings()->with('room')->get();

        $stats = [
            'total' => $bookings->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'confirmed' => $bookings->where('status', 'confirmed')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];
    @endphp

    @if ($isAdmin)
        {{-- ============ ADMIN: full analytics dashboard ============ --}}
        @php
            $totalRooms = \App\Models\Room::count();
            $totalUsers = \App\Models\User::count();

            $months = collect(range(5, 0))->map(fn($i) => \Carbon\Carbon::now()->subMonths($i));
            $chartLabels = $months->map(fn($m) => $m->format('M'))->toArray();
            $chartData = $months->map(function ($m) use ($bookings) {
                return $bookings->filter(fn($b) => $b->check_in->format('Y-m') === $m->format('Y-m'))->count();
            })->toArray();

            $recentBookings = $bookings->sortByDesc('created_at')->take(5);
            $recentUsers = \App\Models\User::latest()->take(4)->get();
        @endphp

        <div class="space-y-6">
            <div class="bg-gradient-to-r from-[#0f1c30] to-[#1c2f4d] rounded-2xl p-8 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold">Welcome back, {{ explode(' ', auth()->user()->name)[0] }} 👋</h1>
                    <p class="text-white/60 mt-1 text-sm">Here's what's happening with your booking system today.</p>
                </div>
                <a href="{{ route('bookings.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-400 text-[#0f1c30] rounded-lg font-semibold text-sm hover:bg-amber-300 transition shrink-0">+ New Booking</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Total Bookings</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Pending</p>
                    <p class="text-2xl font-bold text-amber-500 mt-1">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Confirmed</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['confirmed'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Cancelled</p>
                    <p class="text-2xl font-bold text-red-500 mt-1">{{ $stats['cancelled'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Rooms</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalRooms }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Total Users</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-5 bg-white rounded-xl border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Bookings Overview</h3>
                    <canvas id="bookingsChart" height="220"></canvas>
                </div>

                <div class="lg:col-span-4 bg-white rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800">Recent Bookings</h3>
                        <a href="{{ route('bookings.index') }}" class="text-xs font-medium text-amber-600 hover:underline">View All</a>
                    </div>
                    <div class="space-y-3">
                        @forelse ($recentBookings as $booking)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 shrink-0 overflow-hidden">
                                    @if ($booking->room->image_url)
                                        <img src="{{ $booking->room->image_url }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-700 truncate">{{ $booking->room->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $booking->check_in->format('M d') }} – {{ $booking->check_out->format('M d, Y') }}</p>
                                </div>
                                <span @class([
                                    'px-2 py-0.5 rounded-full text-[10px] font-medium uppercase tracking-wide shrink-0',
                                    'bg-amber-100 text-amber-700' => $booking->status == 'pending',
                                    'bg-green-100 text-green-700' => $booking->status == 'confirmed',
                                    'bg-red-100 text-red-700' => $booking->status == 'cancelled',
                                ])>{{ $booking->status }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">No bookings yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="lg:col-span-3 bg-white rounded-xl border border-gray-100 p-6 flex flex-col items-center">
                    <h3 class="font-semibold text-gray-800 self-start mb-4">Booking Status</h3>
                    <canvas id="statusChart" height="180"></canvas>
                    <div class="w-full mt-4 space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>Confirmed</span>
                            <span class="text-gray-500">{{ $stats['confirmed'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>Pending</span>
                            <span class="text-gray-500">{{ $stats['pending'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>Cancelled</span>
                            <span class="text-gray-500">{{ $stats['cancelled'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800">Recent Users</h3>
                        <a href="{{ route('admin.users.index') }}" class="text-xs font-medium text-amber-600 hover:underline">View All</a>
                    </div>
                    <div class="space-y-3">
                        @foreach ($recentUsers as $user)
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-sm font-semibold shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-700 truncate">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('rooms.index') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-amber-300 hover:bg-amber-50 transition">
                            <span class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">🏠</span>
                            <span class="text-sm font-medium text-gray-700">Manage Rooms</span>
                        </a>
                        <a href="{{ route('bookings.index') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-amber-300 hover:bg-amber-50 transition">
                            <span class="w-9 h-9 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">☰</span>
                            <span class="text-sm font-medium text-gray-700">View Bookings</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-amber-300 hover:bg-amber-50 transition">
                            <span class="w-9 h-9 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">👤</span>
                            <span class="text-sm font-medium text-gray-700">Manage Users</span>
                        </a>
                        <a href="{{ route('rooms.create') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-amber-300 hover:bg-amber-50 transition">
                            <span class="w-9 h-9 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center">+</span>
                            <span class="text-sm font-medium text-gray-700">Add Room</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new Chart(document.getElementById('bookingsChart'), {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Bookings',
                            data: @json($chartData),
                            borderColor: '#d97706',
                            backgroundColor: 'rgba(217,119,6,0.08)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#d97706',
                        }]
                    },
                    options: {
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                    }
                });

                new Chart(document.getElementById('statusChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Confirmed', 'Pending', 'Cancelled'],
                        datasets: [{
                            data: [{{ $stats['confirmed'] }}, {{ $stats['pending'] }}, {{ $stats['cancelled'] }}],
                            backgroundColor: ['#16a34a', '#fbbf24', '#ef4444'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        cutout: '70%',
                        plugins: { legend: { display: false } }
                    }
                });
            });
        </script>
    @else
        {{-- ============ USER: full dashboard ============ --}}
        @php
            $availableRooms = \App\Models\Room::count();
            $months = collect(range(5, 0))->map(fn($i) => \Carbon\Carbon::now()->subMonths($i));
            $chartLabels = $months->map(fn($m) => $m->format('M'))->toArray();
            $chartData = $months->map(function ($m) use ($bookings) {
                return $bookings->filter(fn($b) => $b->check_in->format('Y-m') === $m->format('Y-m'))->count();
            })->toArray();
            $recentBookings = $bookings->sortByDesc('created_at')->take(3);
        @endphp

        <div class="space-y-6">
            <div class="bg-gradient-to-r from-[#0f1c30] to-[#1c2f4d] rounded-2xl p-8 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold">Welcome back, {{ explode(' ', auth()->user()->name)[0] }} 👋</h1>
                    <p class="text-white/60 mt-1 text-sm">Here's an overview of your bookings.</p>
                </div>
                <a href="{{ route('bookings.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-400 text-[#0f1c30] rounded-lg font-semibold text-sm hover:bg-amber-300 transition shrink-0">+ New Booking</a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Total Bookings</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Pending</p>
                    <p class="text-2xl font-bold text-amber-500 mt-1">{{ $stats['pending'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Confirmed</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $stats['confirmed'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Cancelled</p>
                    <p class="text-2xl font-bold text-red-500 mt-1">{{ $stats['cancelled'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-5 border border-gray-100">
                    <p class="text-xs text-gray-400">Available Rooms</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $availableRooms }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-5 bg-white rounded-xl border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Bookings Overview</h3>
                    <canvas id="bookingsChart" height="220"></canvas>
                </div>

                <div class="lg:col-span-4 bg-white rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-gray-800">Recent Bookings</h3>
                        <a href="{{ route('bookings.index') }}" class="text-xs font-medium text-amber-600 hover:underline">View All</a>
                    </div>
                    <div class="space-y-3">
                        @forelse ($recentBookings as $booking)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-gray-100 shrink-0 overflow-hidden">
                                    @if ($booking->room->image_url)
                                        <img src="{{ $booking->room->image_url }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-700 truncate">{{ $booking->room->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $booking->check_in->format('M d') }} – {{ $booking->check_out->format('M d, Y') }}</p>
                                </div>
                                <span @class([
                                    'px-2 py-0.5 rounded-full text-[10px] font-medium uppercase tracking-wide shrink-0',
                                    'bg-amber-100 text-amber-700' => $booking->status == 'pending',
                                    'bg-green-100 text-green-700' => $booking->status == 'confirmed',
                                    'bg-red-100 text-red-700' => $booking->status == 'cancelled',
                                ])>{{ $booking->status }}</span>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400">No bookings yet.</p>
                        @endforelse
                    </div>
                </div>

                <div class="lg:col-span-3 bg-white rounded-xl border border-gray-100 p-6 flex flex-col items-center">
                    <h3 class="font-semibold text-gray-800 self-start mb-4">Booking Status</h3>
                    <canvas id="statusChart" height="180"></canvas>
                    <div class="w-full mt-4 space-y-2 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>Confirmed</span>
                            <span class="text-gray-500">{{ $stats['confirmed'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>Pending</span>
                            <span class="text-gray-500">{{ $stats['pending'] }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>Cancelled</span>
                            <span class="text-gray-500">{{ $stats['cancelled'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <a href="{{ route('rooms.index') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-amber-300 hover:bg-amber-50 transition">
                        <span class="w-9 h-9 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">🏠</span>
                        <span class="text-sm font-medium text-gray-700">Browse Rooms</span>
                    </a>
                    <a href="{{ route('bookings.create') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-amber-300 hover:bg-amber-50 transition">
                        <span class="w-9 h-9 rounded-lg bg-green-100 text-green-600 flex items-center justify-center">+</span>
                        <span class="text-sm font-medium text-gray-700">Book a Room</span>
                    </a>
                    <a href="{{ route('bookings.index') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-amber-300 hover:bg-amber-50 transition">
                        <span class="w-9 h-9 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">☰</span>
                        <span class="text-sm font-medium text-gray-700">My Bookings</span>
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-3 rounded-lg border border-gray-100 hover:border-amber-300 hover:bg-amber-50 transition">
                        <span class="w-9 h-9 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center">⚙</span>
                        <span class="text-sm font-medium text-gray-700">Profile</span>
                    </a>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                new Chart(document.getElementById('bookingsChart'), {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Bookings',
                            data: @json($chartData),
                            borderColor: '#d97706',
                            backgroundColor: 'rgba(217,119,6,0.08)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#d97706',
                        }]
                    },
                    options: {
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
                    }
                });

                new Chart(document.getElementById('statusChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Confirmed', 'Pending', 'Cancelled'],
                        datasets: [{
                            data: [{{ $stats['confirmed'] }}, {{ $stats['pending'] }}, {{ $stats['cancelled'] }}],
                            backgroundColor: ['#16a34a', '#fbbf24', '#ef4444'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        cutout: '70%',
                        plugins: { legend: { display: false } }
                    }
                });
            });
        </script>
    @endif
</x-app-layout>