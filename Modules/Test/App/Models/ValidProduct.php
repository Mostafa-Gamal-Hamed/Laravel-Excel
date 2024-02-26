<?php

namespace Modules\Test\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Test\Database\factories\ValidProductFactory;

class ValidProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected static function newFactory(): ValidProductFactory
    {
        //return ValidProductFactory::new();
    }
}
