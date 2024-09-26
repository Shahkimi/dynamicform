<?php

namespace App\Http\Controllers;

use App\Models\Ptj;
use App\Models\Unit;
use App\Models\Bahagian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    public function index()
    {
        $ptjs = Ptj::select('id', 'nama_ptj', 'kod_ptj', 'pengarah')
            ->latest()
            ->paginate(15);

        return view('test.test', compact('ptjs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_ptj' => 'required|string|max:255',
            'kod_ptj' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'pengarah' => 'required|string|max:255',
            'bahagian' => 'required|string|max:255',
            'units' => 'required|array',
            'units.*' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $ptj = Ptj::create($validator->validated());

            $bahagian = $ptj->bahagians()->create([
                'bahagian' => $request->bahagian,
            ]);

            foreach ($request->units as $unit) {
                $bahagian->units()->create([
                    'unit' => $unit,
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Data saved successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while saving the data.'], 500);
        }
    }
    public function show($id)
    {
        try {
            $ptj = Ptj::with(['bahagians.units'])->findOrFail($id);
            return response()->json($ptj);
        } catch (\Exception $e) {
            \Log::error('Error in PTJ show method: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return response()->json(['error' => 'An error occurred while fetching the PTJ data: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $ptj = Ptj::findOrFail($id);
            $ptj->delete();
            return response()->json(['message' => 'PTJ deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the PTJ'], 500);
        }
    }

    //Bahagian controller Section
    public function showBahagian($id)
    {
        $ptj = Ptj::findOrFail($id);
        $bahagians = $ptj->bahagians()->with('units')->paginate(5);
        return view('test.bahagian', compact('ptj', 'bahagians'));
    }
    public function storeBahagian(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ptj_id' => 'required|exists:ptj,id',
            'bahagian' => 'required|string|max:255',
            'units' => 'required|array',
            'units.*' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $bahagian = Bahagian::create([
                'ptj_id' => $request->ptj_id,
                'bahagian' => $request->bahagian,
            ]);

            foreach ($request->units as $unit) {
                $bahagian->units()->create([
                    'unit' => $unit,
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Bahagian added successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while saving the data.'], 500);
        }
    }
    public function destroyBahagian($id)
    {
        try {
            DB::beginTransaction();

            $bahagian = Bahagian::findOrFail($id);
            $bahagian->units()->delete(); // Delete associated units
            $bahagian->delete(); // Delete the bahagian

            DB::commit();

            return response()->json(['message' => 'Bahagian and associated units deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while deleting the Bahagian'], 500);
        }
    }
}
