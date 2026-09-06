<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    //
    public function bookingList()
    {
        $bookings = Booking::orderBy('created_at', 'desc')->get();
        return view('admin.bookinglist', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|unique:bookings,booking_id',
            'name' => 'required',
            'travel_date' => 'required|date',
            'travel_from' => 'required',
            'travel_to' => 'required',
            'booking_status' => 'required',
            'payment_status' => 'required',
        ]);

        Booking::create($request->all());

        return redirect()->route('admin.booking-list')->with('success', 'Booking created successfully');
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('admin.edit-booking', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'booking_id' => 'required|unique:bookings,booking_id,' . $id,
            'name' => 'required',
            'travel_date' => 'required|date',
            'travel_from' => 'required',
            'travel_to' => 'required',
            'booking_status' => 'required',
            'payment_status' => 'required',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return redirect()->route('admin.booking-list')->with('success', 'Booking updated successfully');
    }
}
