<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'skills', 'level'];

    // PENTING: Mengubah JSON di database menjadi Array PHP otomatis
    protected $casts = [
        'skills' => 'object', // Gunakan 'object' sesuai permintaan Anda, atau 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
