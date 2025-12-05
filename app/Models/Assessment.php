<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'type',
    ];

    // Relasi: Satu pertanyaan bisa memiliki banyak jawaban dari berbagai user
    public function submissions()
    {
        return $this->hasMany(AssessmentSubmission::class);
    }
}
