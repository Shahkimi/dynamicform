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
            ->paginate(10);

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

    public function editBahagian($id)
    {
        $bahagian = Bahagian::with('units')->findOrFail($id);
        return response()->json($bahagian);
    }

    public function updateBahagian(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'bahagian' => 'required|string|max:255',
            'units' => 'required|array',
            'units.*' => 'required|string|max:255',
            'unit_ids' => 'required|array',
            'unit_ids.*' => 'nullable|exists:unit,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();

            $bahagian = Bahagian::findOrFail($id);
            $bahagian->update(['bahagian' => $request->bahagian]);

            // Update or create units
            foreach ($request->units as $index => $unitName) {
                if (!empty($request->unit_ids[$index])) {
                    Unit::where('id', $request->unit_ids[$index])->update(['unit' => $unitName]);
                } else {
                    $bahagian->units()->create(['unit' => $unitName]);
                }
            }

            // Delete units that were removed
            $existingUnitIds = $bahagian->units->pluck('id')->toArray();
            $keptUnitIds = array_filter($request->unit_ids);
            $deletedUnitIds = array_diff($existingUnitIds, $keptUnitIds);
            Unit::destroy($deletedUnitIds);

            DB::commit();

            return response()->json(['message' => 'Bahagian updated successfully!'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'An error occurred while updating the data.'], 500);
        }
    }

    public function edit($id)
    {
        $ptj = Ptj::findOrFail($id);
        return response()->json($ptj);
    }

    public function update(Request $request, $id)
    {
        \Log::info('Update request received:', $request->all());

        $validator = Validator::make($request->all(), [
            'nama_ptj' => 'required|string|max:255',
            'kod_ptj' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'pengarah' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $ptj = Ptj::findOrFail($id);
            $ptj->update($request->all());
            return response()->json(['message' => 'PTJ updated successfully!']);
        } catch (\Exception $e) {
            \Log::error('Error updating PTJ:', ['message' => $e->getMessage()]);
            return response()->json(['errors' => ['general' => [$e->getMessage()]]], 500);
        }
    }
    public function search(Request $request)
{
    \Log::info('Search request received:', $request->all());

    $search = $request->input('search');
    \Log::info('Search term:', ['search' => $search]);

    $ptjs = Ptj::where(function ($query) use ($search) {
        $query->where('nama_ptj', 'like', "%$search%")
            ->orWhere('kod_ptj', 'like', "%$search%")
            ->orWhere('alamat', 'like', "%$search%");
    })->get();

    \Log::info('Search results:', ['count' => $ptjs->count(), 'results' => $ptjs->toArray()]);

    return response()->json(['data' => $ptjs]);
}
}
