<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $primaryKey = 'Username';
    public $incrementing = false;
    protected $keyType = 'string';
    
    public $timestamps = false;
}
