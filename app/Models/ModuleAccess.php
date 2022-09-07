<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'module_id',
        'module_label',
        'module_slug',
        'canEdit',
        'canSave',
        'canDelete',
    ];
}
