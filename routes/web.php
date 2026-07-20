<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/rooms/{room}/booked-dates', [BookingController::class, 'bookedDates'])->name('rooms.booked-dates');
    Route::resource('rooms', RoomController::class)->except(['show']);

    Route::resource('bookings', BookingController::class);
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::get('/setup-admin-xk92', function () {
    if (\App\Models\User::where('email', 'admin@example.com')->exists()) {
        return 'Admin already exists. Email: admin@example.com';
    }

    \App\Models\User::create([
        'name' => 'Admin',
        'email' => 'admin@example.com',
        'password' => bcrypt('password123'),
        'role' => 'admin',
    ]);

    return 'Admin created! Email: admin@example.com / Password: password123';
});

Route::get('/setup-rooms-xk92', function () {
    if (\App\Models\Room::count() > 0) {
        return 'Rooms already exist: ' . \App\Models\Room::count();
    }

    \App\Models\Room::create(['name' => 'Standard Room', 'description' => 'Cozy room with 1 queen bed, perfect for solo travelers or couples.', 'price_per_night' => 1500, 'capacity' => 2, 'image_url' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80']);
    \App\Models\Room::create(['name' => 'Deluxe Queen Room', 'description' => 'Spacious room with city view and modern amenities.', 'price_per_night' => 2500, 'capacity' => 3, 'image_url' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=800&q=80']);
    \App\Models\Room::create(['name' => 'Deluxe King Room', 'description' => 'Perfect blend of comfort and luxury with a stunning city view.', 'price_per_night' => 3200, 'capacity' => 2, 'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=800&q=80']);
    \App\Models\Room::create(['name' => 'Family Suite', 'description' => 'Large suite for the whole family, with 2 queen beds.', 'price_per_night' => 4800, 'capacity' => 5, 'image_url' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=800&q=80']);
    \App\Models\Room::create(['name' => 'Standard Twin Room', 'description' => 'Two comfortable single beds, ideal for friends or colleagues.', 'price_per_night' => 1800, 'capacity' => 2, 'image_url' => 'https://images.unsplash.com/photo-1595576508898-0ad5c879a061?auto=format&fit=crop&w=800&q=80']);

    return 'Rooms created! Total: ' . \App\Models\Room::count();
});

require __DIR__.'/auth.php';