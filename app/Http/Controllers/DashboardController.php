<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index()
    {
        $countProduct = Product::count();
        $countMaterial = Material::count();
        return view('pages.dashboard', [
            'countProduct' => $countProduct,
            'countMaterial' => $countMaterial,
        ]);
    }
}
