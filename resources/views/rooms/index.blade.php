<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Browse Rooms</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($rooms as $room)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                    <div class="h-44 bg-gray-100">
                        @if ($room->image_url)
                            <img src="{{ $room->image_url }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                            </div>
                        @endif
                    </div>

                    <div class="p-5 flex flex-col flex-1">
                        <h3 class="font-semibold text-gray-800 text-lg">{{ $room->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1 flex-1">{{ $room->description }}</p>

                        <div class="flex items-center justify-between mt-4 text-sm">
                            <span class="font-semibold text-amber-600">₱{{ number_format($room->price_per_night, 2) }}/night</span>
                            <span class="text-gray-400">{{ $room->capacity }} pax</span>
                        </div>

                        <div class="mt-2">
                            @if ($room->bookings_count > 0)
                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    {{ $room->bookings_count }} upcoming booking(s)
                                </span>
                            @else
                                <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    Fully open
                                </span>
                            @endif
                        </div>

                        <a href="{{ route('bookings.create', ['room_id' => $room->id]) }}"
                           class="mt-4 block text-center px-4 py-2.5 bg-[#0f1c30] text-white rounded-lg hover:bg-[#16274a] transition font-medium text-sm">
                            Book Now
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($rooms->isEmpty())
            <div class="text-center text-gray-400 py-16">No rooms available yet.</div>
        @endif
    </div>
</x-app-layout>