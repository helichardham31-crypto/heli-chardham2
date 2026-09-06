<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    //
    use App\Models\Booking;
class CheckBookingController extends Controller
{


public function checkBookingStatus(Request $request)
{
    $bookingId = $request->input('pnr');

    $booking = Booking::where('booking_id', $bookingId)->first();

    if (!$booking) {
        return response()->json(['success' => false, 'message' => 'Invalid booking ID'], 404);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'name' => $booking->name,
            'travel_date' => $booking->travel_date,
            'travel_from' => $booking->travel_from,
            'travel_to' => $booking->travel_to,
            'booking_status' => $booking->booking_status,
            'payment_status' => $booking->payment_status ?? 'N/A'
        ]
    ]);
}
}
