<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TheSeer\Tokenizer\Token;

class Subscriber extends Model
{
    use HasFactory;

    protected $guarded = [];

    static public function setToken(): Token
    {
        return new Token(1,'hasher','a');
    }
}
