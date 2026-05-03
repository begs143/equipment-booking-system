<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'equipment')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        $booking->status = 'Approved';
        $booking->save();

        return back()->with('success', 'Booking approved successfully.');
    }

  public function reject(Request $request, $id)
{
    $request->validate([
        'reason' => 'required|string|max:255',
    ]);

    $booking = Booking::findOrFail($id);

    // update status + save reason
    $booking->status = 'Rejected';
    $booking->rejection_reason = $request->reason;
    $booking->save();
    return redirect()->route('admin.bookings.index')->with('success', 'Rejected.');
}
    public function destroy(Booking $booking)
{
    $booking->delete();

    return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
}
  public function trashed()
{
    $bookings = Booking::onlyTrashed()->get();
    return view('admin.bookings.trashed', compact('bookings'));
}

public function restore($id)
{
    $booking = Booking::onlyTrashed()->findOrFail($id);
    $booking->restore();

    return redirect()->route('admin.bookings.index')->with('success', 'Booking restored successfully.');
}

public function forceDelete($id)
{
    $booking = Booking::onlyTrashed()->findOrFail($id);
    $booking->forceDelete();

    return redirect()->route('admin.bookings.index')->with('success', 'Booking permanently deleted.');
}
public function markReturned($id)
{
    $booking = Booking::findOrFail($id);

    if ($booking->status !== 'Approved') {
        return redirect()->back()->with('error', 'Only approved bookings can be marked as returned.');
    }

        $booking->status = 'Returned';
    $booking->save();
    if ($booking->equipment) {
        $booking->equipment->quantity += $booking->quantity; // assuming you have "quantity" in bookings table
        $booking->equipment->save();
    }

    return redirect()->back()->with('success', 'Booking marked as returned successfully.');
}
}
