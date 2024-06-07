<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'user_id',
        // kolom lainnya
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}