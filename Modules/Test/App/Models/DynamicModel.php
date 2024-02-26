<?php

namespace Modules\Test\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Test\Database\factories\DynamicModelFactory;

class DynamicModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    public function changeTable($tableName)
    {
        $this->setTable($tableName);
    }

    protected $guarded = [];

    // protected static function newFactory(): DynamicModelFactory
    // {
    //     //return DynamicModelFactory::new();
    // }
}
