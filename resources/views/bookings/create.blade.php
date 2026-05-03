@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">

    {{-- Welcome Section --}}
    <div class="mb-6 bg-blue-100 border border-blue-300 rounded-lg p-4">
        <h2 class="text-lg font-semibold text-blue-800">
            Welcome{{ Auth::check() ? ', ' . Auth::user()->name : '' }}
        </h2>
        <p class="text-sm text-blue-700">
            Please fill in the form below to book your equipment.
        </p>
    </div>

    <h1 class="text-2xl font-bold mb-4">Book Equipment</h1>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        {{-- Name --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Your Name</label>
            <input type="text" name="name"
                   value="{{ Auth::check() ? Auth::user()->name : '' }}"
                   {{ Auth::check() ? 'readonly' : 'required' }}
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>

        {{-- Equipment --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Equipment</label>
            <input type="text" name="equipment_name" value="{{ $equipment->name }}" readonly
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <input type="hidden" name="equipment_id" value="{{ $equipment->id }}">
        </div>

        {{-- Quantity --}}
        <div class="mb-4">
            <label class="block mb-1 font-medium">Quantity</label>
            <input type="number" name="quantity" min="1" max="{{ $equipment->quantity }}" required
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   placeholder="Enter quantity">
            <p class="text-sm text-gray-500">Available: {{ $equipment->quantity }}</p>
        </div>

        {{-- Booking Date --}}
   {{-- Booking Date & Time --}}
<div class="mb-4">
    <label class="block mb-1 font-medium">Date & Time of Booking</label>
    <div class="flex gap-2">
        <input type="date" name="booking_date" required
               class="w-1/2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <input type="time" name="booking_time" required
               class="w-1/2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>
</div>

        {{-- Return Date --}}
   <div class="mb-4">
    <label class="block mb-1 font-medium">Date & Time of Return</label>
    <div class="flex gap-2">
        <input type="date" name="return_date" required
               class="w-1/2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <input type="time" name="return_time" required
               class="w-1/2 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>
</div>
{{-- Location --}}
<div class="mb-4">
    <label class="block mb-1 font-medium">Where will you bring it?</label>
    <select name="location" required
            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <option value="" disabled selected>Select location</option>
        <option value="AVR">AVR</option>
        <option value="Pavement">Pavement</option>
        <option value="Classroom">Classroom</option>
        <option value="Outside Campus">Outside Campus</option>
    </select>
</div>

<button type="submit" class="btn btn-primary">
    Book Now
</button>
<a href="{{ route('equipment.index') }}" class="btn btn-secondary">
    Cancel
</a>


</div>
        </div>
    </form>
</div>
@endsection
