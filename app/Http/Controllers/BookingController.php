<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Equipment;

/**
 * BookingController handles the booking operations.
 */

class BookingController extends Controller
{
    public function index()
    {
    $bookings = Booking::where('user_id', auth()->id())->with('equipment')->get();

    return view('bookings.index', compact('bookings'));
    }

public function create($id)
{
    $equipment = Equipment::findOrFail($id); // ensures no null
    return view('bookings.create', compact('equipment'));
}

    public function store(Request $request)
{
    $request->validate([
        'equipment_id' => 'required|exists:equipment,id',
         'name'         => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'booking_date' => 'required|date',
        'return_date' => 'required|date|after_or_equal:booking_date',
    ]);

    $equipment = Equipment::findOrFail($request->equipment_id);

    // Check availability
    if ($equipment->quantity < $request->quantity) {
        return back()->with('error', 'Not enough stock available.');
    }

    // Save booking
    Booking::create([
    'user_id'       => auth()->id(),
    'name'          => $request->name,
    'equipment_id'  => $equipment->id,
    'quantity'      => $request->quantity,
    'date_of_booking' => $request->booking_date,
    'booking_time'    => $request->booking_time,
    'date_of_return'  => $request->return_date,
    'return_time'     => $request->return_time,
    'location'        => $request->location,
    ]);


    // Deduct from equipment stock
    $equipment->decrement('quantity', $request->quantity);

    return redirect()->route('bookings.index')->with('success', 'Booking successful!');
}


    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        return view('bookings.edit', compact('booking'));
    }

    public function update(Request $request, Booking $booking)
    {
        $booking->update($request->all());
        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }

}
