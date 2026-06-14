<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavedCard extends Model
{
    protected $fillable = [
        'user_id', 'kart_sahibi', 'son_dort_hane', 'son_kullanma_ay', 'son_kullanma_yil'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
