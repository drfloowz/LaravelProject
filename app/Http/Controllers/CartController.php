<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        $tax = $totalAmount * 0.20; // %20 KDV varsayımı
        $grandTotal = $totalAmount + $tax;

        return view('cart.index', compact('cart', 'totalAmount', 'tax', 'grandTotal'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = Session::get('cart', []);
        
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            $quantity = 1;
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image_path' => $product->image_path,
                'max_stock' => $product->stock,
                'slug' => $product->slug
            ];
        }

        // Stok limit kontrolü
        if ($cart[$product->id]['quantity'] > $product->stock) {
            $cart[$product->id]['quantity'] = $product->stock;
            Session::put('cart', $cart);
            return redirect()->back()->with('error', 'Stok miktarından fazla ürün ekleyemezsiniz.');
        }

        Session::put('cart', $cart);

        return redirect()->back()->with('success', 'Ürün sepete başarıyla eklendi!');
    }

    public function update(Request $request, $id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $quantity = (int) $request->input('quantity', 1);
            if ($quantity > 0 && $quantity <= $cart[$id]['max_stock']) {
                $cart[$id]['quantity'] = $quantity;
                Session::put('cart', $cart);
            }
        }

        return redirect()->route('cart.index')->with('success', 'Sepet güncellendi.');
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Ürün sepetten çıkarıldı.');
    }
}
