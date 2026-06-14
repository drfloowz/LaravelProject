<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id', 'baslik', 'ad_soyad', 'telefon', 'sehir', 'ilce', 'acik_adres'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
