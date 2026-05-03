@extends('layouts.app')

@section('title', 'Manage Bookings')

@section('content')
    <h1 class="mb-4">All Bookings</h1>

    @php
        // Custom status order
        $statusOrder = ['Pending' => 1, 'Approved' => 2, 'Returned' => 3, 'Rejected' => 4];

        // Sort by status first, then by booking date
        $bookings = $bookings->sortBy(function ($booking) use ($statusOrder) {
            return sprintf(
                '%d-%s',
                $statusOrder[$booking->status] ?? 99,
                $booking->date_of_booking
            );
        });
    @endphp

    <table class="table table-bordered table-hover align-middle">
        <thead class="table-secondary">
            <tr>
                <th>User</th>
                <th>Equipment</th>
                <th>Quantity</th>
                <th>Booking Date</th>
                <th>Booking Time</th>
                <th>Return Date</th>
                <th>Return Time</th>
                <th>Location</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->equipment->name }}</td>
                    <td>{{ $booking->quantity }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->date_of_booking)->format('F j, Y') }}</td>
                    <td>{{ $booking->booking_time ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($booking->date_of_return)->format('F j, Y') }}</td>
                    <td>{{ $booking->return_time ?? '-' }}</td>
                    <td>{{ $booking->location ?? '-' }}</td>
                    <td>
                        <span class="badge
                            @if ($booking->status == 'Approved') bg-success
                            @elseif ($booking->status == 'Rejected') bg-danger
                            @elseif ($booking->status == 'Returned') bg-primary
                            @else bg-secondary
                            @endif">
                            {{ $booking->status ?? 'Pending' }}
                        </span>
                    </td>
                    <td class="text-center">
                      @if ($booking->status == 'Pending' || $booking->status == 'Rejected')
    <form action="{{ route('admin.bookings.approve', $booking->id) }}" method="POST" class="d-inline">
        @csrf
        <button class="btn btn-success btn-sm">Approve</button>
    </form>

                          <button type="button" class="btn btn-danger btn-sm"
        data-bs-toggle="modal" data-bs-target="#rejectModal"
        data-id="{{ $booking->id }}">
    Reject
</button>
<!-- Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="rejectForm">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Reject Booking</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <label for="reason" class="form-label">Reason</label>
            <textarea class="form-control" name="reason" id="reason" rows="3" required></textarea>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Reject</button>
          </div>
        </div>
    </form>
  </div>
</div>
                        @elseif ($booking->status == 'Approved')
                            <form action="{{ route('admin.bookings.return', $booking->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Mark this equipment as returned?');">
                                @csrf
                                <button class="btn btn-primary btn-sm">Mark Returned</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this booking?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
<script>
document.addEventListener("DOMContentLoaded", function() {
    var rejectModal = document.getElementById('rejectModal');
    rejectModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var bookingId = button.getAttribute('data-id');
        var form = document.getElementById('rejectForm');
        form.action = "/admin/bookings/" + bookingId + "/reject";
    });
});
</script>
