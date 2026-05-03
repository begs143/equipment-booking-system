@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-6">Available Equipments</h1>

    @if($equipments->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($equipments as $equipment)
                <div class="bg-white shadow-md rounded-lg p-5 border border-gray-200 text-center">

                    {{-- Equipment Image --}}
                    @if($equipment->image)
                        <img src="{{ asset($equipment->image) }}"
                             alt="{{ $equipment->name }}"
                             class="h-12 w-full object-cover rounded mb-3">
                    @else
                        <div class="h-30 w-full bg-gray-200 flex items-center justify-center rounded mb-3">
                            <span class="text-gray-500">No Image</span>
                        </div>
                    @endif

                    {{-- Equipment Info --}}
                    <h2 class="text-xl font-semibold mb-2">{{ $equipment->name }}</h2>
                    <p class="mb-1"><strong>Quantity:</strong> {{ $equipment->quantity }}</p>
                    <p class="mb-3"><strong>Status:</strong>
                        <span class="{{ $equipment->status === 'Available' ? 'text-green-600' : 'text-red-600' }}">
                            {{ $equipment->status }}
                        </span>
                    </p>

                    {{-- Book Now Button --}}
                    @auth
                        <a href="{{ route('bookings.create', $equipment->id ) }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Book Now
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Book Now
                        </a>
                    @endauth
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">No equipment available.</p>
    @endif
</div>
@endsection
