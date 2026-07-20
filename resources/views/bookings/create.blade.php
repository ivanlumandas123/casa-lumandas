<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Booking</h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <style>
        .flatpickr-calendar {
            width: 100% !important;
            max-width: 500px;
            font-size: 1.05rem;
            box-shadow: none !important;
            border: 1px solid #e5e7eb;
            border-radius: 0.75rem;
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
        }
        .flatpickr-day.startRange,
        .flatpickr-day.endRange {
            background: #4f46e5 !important;
            border-color: #4f46e5 !important;
            color: white !important;
        }
    </style>

    <div class="py-8 max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow rounded-xl border border-gray-100">

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

                <div class="mb-5">
                    <label class="block mb-1 font-medium text-sm text-gray-700">Room</label>
                    <select id="room_id" name="room_id" class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">-- Select a room --</option>
                        @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id', request('room_id')) == $room->id ? 'selected' : '' }}>
                                {{ $room->name }} — ₱{{ number_format($room->price_per_night, 2) }}/night ({{ $room->capacity }} pax)
                            </option>
                        @endforeach
                    </select>
                    <p id="room-description" class="text-sm text-gray-500 mt-1"></p>
                </div>

                <div class="mb-5">
                    <label class="block mb-2 font-medium text-sm text-gray-700">Select Check-in & Check-out Dates</label>
                    <div id="calendar"></div>
                    <p class="text-xs text-gray-400 mt-2">Red / strikethrough dates are already booked and cannot be selected.</p>
                    <p class="text-sm font-medium text-indigo-600 mt-2" id="selected-dates-display">No dates selected yet.</p>
                </div>

                <input type="hidden" name="check_in" id="check_in" value="{{ old('check_in') }}">
                <input type="hidden" name="check_out" id="check_out" value="{{ old('check_out') }}">

                <div class="mb-6">
                    <label class="block mb-1 font-medium text-sm text-gray-700">Notes</label>
                    <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                </div>

                <div>
                    <button type="submit" style="background-color:#4f46e5; color:#ffffff; padding:12px 24px; border-radius:8px; font-weight:600; font-size:14px; border:none; cursor:pointer;">
                        Create Booking
                    </button>
                    <a href="{{ route('bookings.index') }}" style="margin-left:12px; padding:12px 24px; border-radius:8px; border:1px solid #d1d5db; color:#374151; font-size:14px; text-decoration:none; display:inline-block;">
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