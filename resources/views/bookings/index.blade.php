@extends('layouts.app')

@section('content')
<div class="container">
    <h1>My Bookings</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Equipment</th>
                <th>Quantity</th>
                <th>Booking Date</th>
                <th>Booking Time</th> {{-- NEW --}}
                <th>Return Date</th>
                <th>Return Time</th> {{-- NEW --}}
                <th>Location</th> {{-- NEW --}}
                <th>Status</th>
                <th>Reason</th> {{-- NEW --}}
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->equipment->name }}</td>
                    <td>{{ $booking->quantity }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->date_of_booking)->format('F j, Y') }}</td>
                    <td>{{ $booking->booking_time ?? '-' }}</td> {{-- NEW --}}
                    <td>{{ \Carbon\Carbon::parse($booking->date_of_return)->format('F j, Y') }}</td>
                    <td>{{ $booking->return_time ?? '-' }}</td> {{-- NEW --}}
                    <td>{{ $booking->location ?? '-' }}</td> {{-- NEW --}}
                    <td>{{ $booking->status ?? 'Pending' }}</td>
                    <td>
    @if($booking->status === 'Rejected')
        {{ $booking->rejection_reason ?? 'No reason provided' }}
    @else
    @endif
</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No bookings yet.</td> {{-- updated colspan --}}
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
