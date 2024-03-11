<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialNet extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'active',
        'created_at',
        'updated_at'
    ];
}
