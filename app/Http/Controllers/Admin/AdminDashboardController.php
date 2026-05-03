<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $equipments = Equipment::all();
        return view('admin.dashboard', compact('equipments'));
    }

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|string|max:255',
        'quantity' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    $equipment = new Equipment();
    $equipment->name = $request->name;
    $equipment->status = $request->status;
    $equipment->quantity = $request->quantity;

    // ✅ Handle Image Upload
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/equipment'), $imageName);
        $equipment->image = 'images/equipment/' . $imageName; // store relative path
    }

    $equipment->save();

    return redirect()->back()->with('success', 'Equipment added successfully!');
}

 public function update(Request $request, $id)
{
    $equipment = Equipment::findOrFail($id);

    $equipment->name = $request->name;
    $equipment->status = $request->status;
    $equipment->quantity = $request->quantity;

    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/equipment'), $imageName);
        $equipment->image = 'images/equipment/' . $imageName;
    }

    $equipment->save();

    return redirect()->back()->with('success', 'Equipment updated successfully!');
}

 public function destroy($id)
{
    $equipment = Equipment::findOrFail($id);
    $equipment->delete();

    return redirect()->route('admin.dashboard')
                     ->with('success', 'Equipment deleted successfully.');
}
}
