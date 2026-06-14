<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Sepetiniz boş. Lütfen önce ürün ekleyin.');
        }

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        $tax = $totalAmount * 0.20;
        $grandTotal = $totalAmount + $tax;

        return view('checkout.index', compact('cart', 'totalAmount', 'tax', 'grandTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Sepetiniz boş.');
        }

        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        $tax = $totalAmount * 0.20;
        $grandTotal = $totalAmount + $tax;

        // Adres ve iletişim bilgilerini birleştirerek kaydediyoruz
        $shippingAddress = json_encode([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        try {
            DB::beginTransaction();

            // 1. Sipariş Kaydı
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $grandTotal,
                'status' => 'pending',
                'shipping_address' => $shippingAddress,
            ]);

            // 2. Sipariş Kalemleri ve Stok Düşümü
            foreach ($cart as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Ürün stok eksiltme (lockForUpdate olası concurrency hatalarını önler)
                $product = Product::lockForUpdate()->find($productId);
                if ($product) {
                    $newStock = $product->stock - $item['quantity'];
                    $product->update(['stock' => max(0, $newStock)]);
                }
            }

            DB::commit();

            // İşlem başarılıysa sepeti temizle
            Session::forget('cart');

            return redirect()->route('checkout.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Sipariş oluşturulurken bir hata oluştu: ' . $e->getMessage())->withInput();
        }
    }

    public function success(Order $order)
    {
        // Kullanıcı kendi siparişi değilse erişemesin
        abort_if($order->user_id !== Auth::id(), 403);
        
        return view('checkout.success', compact('order'));
    }
}
