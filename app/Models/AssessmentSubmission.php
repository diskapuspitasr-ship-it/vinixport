<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'assessment_id',
        'value',
    ];

    // Relasi: Submission ini milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Submission ini untuk pertanyaan apa?
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
