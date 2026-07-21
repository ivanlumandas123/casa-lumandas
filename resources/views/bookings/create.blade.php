<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Booking</h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <style>
        .flatpickr-calendar {
            width: 100% !important;
            max-width: 600px;
            font-size: 1rem;
            box-shadow: none !important;
            border: none;
            background: transparent;
        }
        .flatpickr-day.booked-date {
            background: #fee2e2 !important;
            color: #b91c1c !important;
            text-decoration: line-through;
            cursor: not-allowed;
        }
        .flatpickr-day.inRange {
            background: #e0e7ff !important;
            border-color: #e0e7ff !important;
            box-shadow: -5px 0 0 #e0e7ff, 5px 0 0 #e0e7ff !important;
        }
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #4f46e5 !important;
            border-color: #4f46e5 !important;
            color: white !important;
        }
        .flatpickr-weekdays,
        .flatpickr-weekday {
            background: transparent !important;
        }
        .flatpickr-months {
            margin-bottom: 0.5rem;
        }
        .flatpickr-prev-month,
        .flatpickr-next-month {
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 6px !important;
            top: 8px !important;
        }
        .flatpickr-current-month {
            font-weight: 600;
        }
    </style>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-8 shadow rounded-2xl border border-gray-100">

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 text-red-700 border border-red-200 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('bookings.store') }}" id="booking-form">
                @csrf

                <div class="mb-6">
                    <label class="block mb-2 font-medium text-sm text-gray-700">Room</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-indigo-500 pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        </span>
                        <select id="room_id" name="room_id" class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            <option value="">-- Select a room --</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" {{ old('room_id', request('room_id')) == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }} — ₱{{ number_format($room->price_per_night, 2) }}/night ({{ $room->capacity }} pax)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p id="room-description" class="text-sm text-gray-500 mt-1.5"></p>
                </div>

                <div class="mb-6">
                    <label class="block mb-3 font-medium text-sm text-gray-700">Select Check-in & Check-out Dates</label>
                    <div class="bg-gray-50 rounded-xl p-5">
                        <div id="calendar"></div>
                        <div class="flex flex-col gap-2 mt-3 pt-3 border-t border-gray-200">
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-200"></span>
                                Red / strikethrough dates are already booked and cannot be selected.
                            </div>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                                Selected range
                            </div>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-indigo-600 mt-3" id="selected-dates-display">No dates selected yet.</p>
                </div>

                <input type="hidden" name="check_in" id="check_in" value="{{ old('check_in') }}">
                <input type="hidden" name="check_out" id="check_out" value="{{ old('check_out') }}">

                <div class="mb-8">
                    <label class="block mb-2 font-medium text-sm text-gray-700">Notes</label>
                    <textarea name="notes" rows="3" placeholder="Add any special requests or notes..." class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 text-sm placeholder:text-gray-400">{{ old('notes') }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold text-sm hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        Create Booking
                    </button>
                    <a href="{{ route('bookings.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 text-sm font-medium hover:bg-gray-50 transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script>
        const rooms = @json($rooms->keyBy('id'));
        let calendar = null;
        let bookedDates = [];

        function initCalendar() {
            if (calendar) calendar.destroy();

            calendar = flatpickr("#calendar", {
                mode: "range",
                inline: true,
                minDate: "today",
                disable: bookedDates,
                onChange: function (selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        const checkIn = instance.formatDate(selectedDates[0], "Y-m-d");
                        const checkOut = instance.formatDate(selectedDates[1], "Y-m-d");
                        document.getElementById('check_in').value = checkIn;
                        document.getElementById('check_out').value = checkOut;
                        document.getElementById('selected-dates-display').innerText =
                            `Selected: ${checkIn} to ${checkOut}`;
                    } else {
                        document.getElementById('check_in').value = '';
                        document.getElementById('check_out').value = '';
                        document.getElementById('selected-dates-display').innerText = 'No dates selected yet.';
                    }
                },
                onDayCreate: function (dObj, dStr, fp, dayElem) {
                    const dateStr = fp.formatDate(dayElem.dateObj, "Y-m-d");
                    if (bookedDates.includes(dateStr)) {
                        dayElem.classList.add('booked-date');
                    }
                }
            });
        }

        function loadBookedDates(roomId) {
            if (!roomId) {
                bookedDates = [];
                document.getElementById('room-description').innerText = '';
                initCalendar();
                return;
            }

            document.getElementById('room-description').innerText = rooms[roomId]?.description ?? '';

            fetch(`/rooms/${roomId}/booked-dates`)
                .then(res => res.json())
                .then(dates => {
                    bookedDates = dates;
                    initCalendar();
                })
                .catch(err => {
                    console.error('Failed to load booked dates:', err);
                    bookedDates = [];
                    initCalendar();
                });
        }

        document.getElementById('room_id').addEventListener('change', function () {
            loadBookedDates(this.value);
        });

        document.getElementById('booking-form').addEventListener('submit', function (e) {
            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;
            if (!checkIn || !checkOut) {
                e.preventDefault();
                alert('Please select both check-in and check-out dates on the calendar before submitting.');
            }
        });

        initCalendar();
        if (document.getElementById('room_id').value) {
            loadBookedDates(document.getElementById('room_id').value);
        }
    </script>
</x-app-layout>