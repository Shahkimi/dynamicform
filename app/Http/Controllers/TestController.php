<?php

namespace App\Http\Controllers;

use App\Models\Ptj;
use App\Models\Bahagian;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    public function index()
    {
        return view('test.test');
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
}
