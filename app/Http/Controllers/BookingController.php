<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\CarbonPeriod;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->isAdmin()) {
            $bookings = Booking::with(['user', 'room'])->latest()->get();
        } else {
            $bookings = $request->user()->bookings()->with('room')->latest()->get();
        }

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::all();

        return view('bookings.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'notes' => 'nullable|string',
        ]);

        if ($this->hasOverlap($validated['room_id'], $validated['check_in'], $validated['check_out'])) {
            return back()->withInput()->withErrors(['check_in' => 'Room is already booked for the selected dates.']);
        }

        $validated['user_id'] = $request->user()->id;

        Booking::create($validated);

        return redirect()->route('bookings.index')->with('success', 'Booking created!');
    }

    public function edit(Booking $booking)
    {
        $this->authorizeBooking($booking);

        $rooms = Room::all();

        return view('bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $this->authorizeBooking($booking);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'status' => 'sometimes|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        if ($this->hasOverlap($validated['room_id'], $validated['check_in'], $validated['check_out'], $booking->id)) {
            return back()->withInput()->withErrors(['check_in' => 'Room is already booked for the selected dates.']);
        }

        $booking->update($validated);

        return redirect()->route('bookings.index')->with('success', 'Booking updated!');
    }

    public function destroy(Request $request, Booking $booking)
    {
        $this->authorizeBooking($booking);

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted!');
    }

    public function bookedDates(Room $room)
    {
        $bookings = $room->bookings()->where('status', '!=', 'cancelled')->get();

        $dates = [];

        foreach ($bookings as $booking) {
            $period = CarbonPeriod::create($booking->check_in, $booking->check_out);
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
        }

        return response()->json(array_values(array_unique($dates)));
    }

    private function hasOverlap($roomId, $checkIn, $checkOut, $excludeBookingId = null)
    {
        $query = Booking::where('room_id', $roomId)
            ->where('status', '!=', 'cancelled')
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn);

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query->exists();
    }

    private function authorizeBooking(Booking $booking): void
    {
        if (!auth()->user()->isAdmin() && $booking->user_id !== auth()->id()) {
            abort(403);
        }
    }
}