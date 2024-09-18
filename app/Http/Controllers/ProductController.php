<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('addMore', compact('products'));
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            "name" => "required",
            "kod_ptj" => "required",
            "alamat" => "required",
            "pengarah" => "required",
            "stocks.*" => "required"
        ];

        foreach ($request->stocks as $key => $value) {
            $rules["stocks.{$key}.bahagian"] = 'required';
            $rules["stocks.{$key}.unit"] = 'required';
        }

        // Validate the request
        $request->validate($rules);

        // Insert product with all fields
        $product = Product::create([
            "name" => $request->name,
            "kod_ptj" => $request->kod_ptj,
            "alamat" => $request->alamat,
            "pengarah" => $request->pengarah
        ]);

        // Insert stocks (assuming the Product model has a relationship to a Stock model)
        foreach ($request->stocks as $key => $value) {
            $product->stocks()->create($value);
        }

        return redirect()->back()->with(['success' => 'Product created successfully.']);
    }

}
