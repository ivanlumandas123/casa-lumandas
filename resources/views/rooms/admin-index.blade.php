<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rooms</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto">
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-700 border border-green-200 rounded-lg text-sm">{{ session('success') }}</div>
        @endif

        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500">Manage all rooms and availability.</p>
            <a href="{{ route('rooms.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                + Add Room
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($rooms as $room)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="h-40 bg-gray-100 relative">
                        @if ($room->image_url)
                            <img src="{{ $room->image_url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                            </div>
                        @endif
                        <span @class([
                            'absolute top-2 right-2 px-2 py-0.5 rounded-full text-[10px] font-medium uppercase',
                            'bg-green-100 text-green-700' => $room->bookings_count == 0,
                            'bg-amber-100 text-amber-700' => $room->bookings_count > 0,
                        ])>
                            {{ $room->bookings_count > 0 ? 'Booked' : 'Available' }}
                        </span>
                    </div>

                    <div class="p-4 flex flex-col flex-1">
                        <h3 class="font-semibold text-gray-800">{{ $room->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1 flex-1">{{ $room->description }}</p>

                        <div class="flex items-center justify-between mt-3 text-sm">
                            <span class="font-semibold text-indigo-600">₱{{ number_format($room->price_per_night, 2) }}/night</span>
                            <span class="text-gray-400">{{ $room->capacity }} pax</span>
                        </div>

                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('rooms.edit', $room) }}" class="flex-1 text-center px-3 py-2 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50 text-sm font-medium transition">
                                Edit
                            </a>
                            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this room? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-3 py-2 rounded-lg border border-red-200 text-red-500 hover:bg-red-50 text-sm font-medium transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($rooms->isEmpty())
            <div class="text-center text-gray-400 py-16">No rooms yet. <a href="{{ route('rooms.create') }}" class="text-indigo-600 hover:underline">Add your first room</a>.</div>
        @endif
    </div>
</x-app-layout>