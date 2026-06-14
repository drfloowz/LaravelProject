<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('category')->latest();

        if ($request->has('category') && $request->category != '') {
            $categorySlug = $request->category;
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        $products = $query->paginate(12);

        return view('home', compact('categories', 'products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->with('category')->firstOrFail();
        // Caching or View Composers are better for navbar categories, but passing directly for simplicity
        $categories = Category::all(); 
        
        return view('product.show', compact('product', 'categories'));
    }
}
