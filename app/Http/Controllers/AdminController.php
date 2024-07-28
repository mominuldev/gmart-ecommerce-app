<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'desc')->paginate(10);

        return view('admin.brand', compact('brands'));
    }

    public function createBrand()
    {
        return view('admin.brand-create');
    }

    public function storeBrand(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug',
            'logo' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = Str::slug($request->slug);
        $logo = $request->file('logo');

        if ($logo) {
            $logoName = time() . '.' . $logo->extension();
            $logo->move(public_path('uploads/brands'), $logoName);
            $brand->logo = $logoName;
        }




        $brand->save();

        return redirect()->route('admin.brands')->with('success', 'Brand created successfully.');
    }

}
