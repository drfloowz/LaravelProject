<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'baslik' => 'required|string|max:255',
            'ad_soyad' => 'required|string|max:255',
            'telefon' => 'required|string|max:20',
            'sehir' => 'required|string|max:255',
            'ilce' => 'required|string|max:255',
            'acik_adres' => 'required|string',
        ]);

        Auth::user()->addresses()->create($request->all());

        return redirect()->back()->with('success', 'Adres başarıyla eklendi.');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        return redirect()->back()->with('success', 'Adres silindi.');
    }
}
