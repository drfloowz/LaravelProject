<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedCard;
use Illuminate\Support\Facades\Auth;

class SavedCardController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kart_sahibi' => 'required|string|max:255',
            'kart_no' => 'required|string|size:16', // Sahte formdan gelecek tam no (sadece test için)
            'son_kullanma_ay' => 'required|string|size:2',
            'son_kullanma_yil' => 'required|string|size:4',
        ]);

        // Sadece son 4 haneyi kaydediyoruz
        $sonDort = substr($request->kart_no, -4);

        Auth::user()->savedCards()->create([
            'kart_sahibi' => $request->kart_sahibi,
            'son_dort_hane' => $sonDort,
            'son_kullanma_ay' => $request->son_kullanma_ay,
            'son_kullanma_yil' => $request->son_kullanma_yil,
        ]);

        return redirect()->back()->with('success', 'Kart başarıyla kaydedildi.');
    }

    public function destroy(SavedCard $card)
    {
        if ($card->user_id !== Auth::id()) {
            abort(403);
        }

        $card->delete();

        return redirect()->back()->with('success', 'Kart silindi.');
    }
}
