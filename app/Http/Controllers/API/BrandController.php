<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// class BrandController extends Controller
// {
//     public function store(Request $request)
//     {
//         $request->validate([
//             'name' => 'required',
//             'slug' => 'required|unique:brands,slug',
//             'image' => 'required|mimes:png,jpg,jpeg|max:2048'
//         ]);

//         $brand = new Brand();
//         $brand->name = $request->name;
//         $brand->slug = Str::slug($request->name);

//         if ($request->hasFile('image')) {
//             $image = $request->file('image');
//             $file_name = time() . '.' . $image->extension();
//             $image->storeAs('brands', $file_name);
//             $brand->image = $file_name;
//         }

//         $brand->save();

//         return response()->json(['message' => 'Brand created successfully!', 'brand' => $brand], 201);
//     }

//     public function index()
//     {
//         $brands = Brand::all();
//         return response()->json($brands);
//     }
// }
