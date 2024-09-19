<?php

namespace App\Http\Controllers;

use App\Models\Ptj;
use App\Models\Bahagian;
use App\Models\Unit;
use Illuminate\Http\Request;

class PtjController extends Controller
{
    // Step 1: Show form to create PTJ
    public function createPtj()
    {
        return view('ptj.create'); // Show PTJ creation form
    }

    // Step 1: Store PTJ data
    public function storePtj(Request $request)
    {
        $ptj = Ptj::create($request->all());

        // Redirect to the next step (creating bahagian for this PTJ)
        return redirect()->route('createBahagian', $ptj->id);
    }

    // Step 2: Show form to create Bahagian for a specific PTJ
    public function createBahagian($ptj_id)
    {
        $ptj = Ptj::find($ptj_id);
        return view('bahagian.create', compact('ptj')); // Pass PTJ data to the view
    }

    // Step 2: Store Bahagian data
    public function storeBahagian(Request $request, $ptj_id)
    {
        $bahagian = Bahagian::create([
            'ptj_id' => $ptj_id,
            'bahagian' => $request->bahagian
        ]);

        // Redirect to the next step (creating unit for this Bahagian)
        return redirect()->route('createUnit', $bahagian->id);
    }

    // Step 3: Show form to create Unit for a specific Bahagian
    public function createUnit($bahagian_id)
    {
        $bahagian = Bahagian::find($bahagian_id);
        return view('unit.create', compact('bahagian')); // Pass Bahagian data to the view
    }

    // Step 3: Store Unit data
    public function storeUnit(Request $request, $bahagian_id)
    {
        Unit::create([
            'bahagian_id' => $bahagian_id,
            'unit' => $request->unit
        ]);

        // Redirect to a summary or success page
        return redirect()->route('ptj.index');
    }
}
