<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_level_id',
        'guardianNumber',
        'contactNumber'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
