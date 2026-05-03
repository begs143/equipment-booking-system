<?php
namespace App\Http\Controllers;

use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index()
    {
        // Fetch only available equipment (optional filter)
        $equipments = Equipment::where('quantity', '>', 0)->get();

        return view('equipments.index', compact('equipments'));
    }

}
