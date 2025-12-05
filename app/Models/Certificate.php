<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certificate_title',
        'issuer_organization',
        'date_issued',
        'image_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
