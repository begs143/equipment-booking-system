@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Equipment Table --}}
    <div class="bg-white shadow-md rounded p-4">
        <h2 class="text-xl font-bold mb-4">Equipment List</h2>
        <table class="table-auto w-full border-collapse border border-gray-300">
           <thead>
    <tr>
        <th class="border p-2">ID</th>
        <th class="border p-2">Image</th> {{-- 👈 new --}}
        <th class="border p-2">Name</th>
        <th class="border p-2">Status</th>
        <th class="border p-2">Quantity</th>
        <th class="border p-2">Actions</th>
    </tr>
</thead>
<tbody>
    @foreach($equipments as $equipment)
    <tr>
        <td class="border p-2">{{ $equipment->id }}</td>
        <td class="border p-2">
            @if($equipment->image)
                <img src="{{ asset($equipment->image) }}" alt="Equipment Image"
                     class="w-10 h-10 object-cover rounded">
            @else
                <span class="text-gray-500">No Image</span>
            @endif
        </td>
        <td class="border p-2">{{ $equipment->name }}</td>
        <td class="border p-2">{{ $equipment->status }}</td>
        <td class="border p-2">{{ $equipment->quantity }}</td>
        <td class="border p-2">
                        {{-- Edit Form --}}
                        <form action="{{ route('admin.dashboard.update', $equipment->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $equipment->name }}" class="border p-1 rounded" required>
                            <input type="text" name="status" value="{{ $equipment->status }}" class="border p-1 rounded" required>
                            <input type="number" name="quantity" value="{{ $equipment->quantity }}" class="border p-1 rounded w-20" min="0" required>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Update</button>
                        </form>

                        {{-- Delete Form --}}
                        <form action="{{ route('admin.dashboard.destroy', $equipment->id) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                                onclick="return confirm('Are you sure you want to delete this equipment?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Add Equipment Form --}}
    <div class="bg-white shadow-md rounded p-4 mt-6">
        <h2 class="text-xl font-bold mb-4">Add New Equipment</h2>
  <form action="{{ route('admin.dashboard.store') }}"
      method="POST"
      enctype="multipart/form-data"  {{-- 👈 important --}}
      class="space-y-3">
    @csrf
    <div>
        <label class="block">Name:</label>
        <input type="text" name="name" class="border p-2 rounded w-full" required>
    </div>
    <div>
        <label class="block">Status:</label>
        <input type="text" name="status" class="border p-2 rounded w-full" required>
    </div>
    <div>
        <label class="block">Quantity:</label>
        <input type="number" name="quantity" class="border p-2 rounded w-full" min="0" required>
    </div>
    <div>
        <label for="image">Upload Image</label>
        <input type="file" name="image" id="image" class="border p-2 w-full">
    </div>
    <div>
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
            Add Equipment
        </button>
    </div>
</form>
    </div>

</div>
@endsection
