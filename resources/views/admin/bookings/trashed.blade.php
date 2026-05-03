@extends('layouts.app')

@section('title', 'Trashed Bookings')

@section('content')
<div class="container">
    <h1 class="mb-4">Trashed Bookings (Recycle Bin)</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Equipment</th>
                <th>Quantity</th>
                <th>Booking Date</th>
                <th>Return Date</th>
                <th>Deleted At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name ?? 'Unknown' }}</td>
                    <td>{{ $booking->equipment->name ?? 'Unknown' }}</td>
                    <td>{{ $booking->quantity }}</td>
                    <td>{{ $booking->date_of_booking }}</td>
                    <td>{{ $booking->date_of_return }}</td>
                    <td>{{ $booking->deleted_at->format('F j, Y g:i A') }}</td>
                    <td>
                        {{-- Restore --}}
                    <form action="{{ route('admin.bookings.restore', $booking->id) }}" method="POST" class="d-inline">
    @csrf
    <button class="btn btn-warning btn-sm">Restore</button>
</form>

<form action="{{ route('admin.bookings.forceDelete', $booking->id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm" onclick="return confirm('Delete permanently?')">Force Delete</button>
</form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No trashed bookings.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to All Bookings</a>
</div>
@endsection
