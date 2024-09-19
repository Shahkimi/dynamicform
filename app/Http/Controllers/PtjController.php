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
        return view('ptj.create');
    }

    // Step 1: Store PTJ data
    public function storePtj(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'nama_ptj' => 'required|string|max:255',
            'kod_ptj' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'pengarah' => 'required|string|max:255',
        ]);

        // Create PTJ and redirect to create Bahagian
        $ptj = Ptj::create($validated);

        return redirect()->route('createBahagian', $ptj);
    }

    // Step 2: Show form to create Bahagian for a specific PTJ
    public function createBahagian(Ptj $ptj)
    {
        return view('bahagian.create', compact('ptj'));
    }

    // Step 2: Store Bahagian data
    public function storeBahagian(Request $request, Ptj $ptj)
    {
        // Validate incoming request
        $validated = $request->validate([
            'bahagian' => 'required|string|max:255',
        ]);

        // Create Bahagian and redirect to create Unit
        $bahagian = $ptj->bahagians()->create($validated);

        return redirect()->route('createUnit', $bahagian);
    }

    // Step 3: Show form to create Unit for a specific Bahagian
    public function createUnit(Bahagian $bahagian)
    {
        return view('unit.create', compact('bahagian'));
    }

    // Step 3: Store Unit data
    public function storeUnit(Request $request, Bahagian $bahagian)
    {
        // Validate incoming request
        $validated = $request->validate([
            'unit' => 'required|string|max:255',
        ]);

        // Create Unit and redirect to PTJ index page
        $bahagian->units()->create($validated);

        return redirect()->route('ptj.index');
    }
}
