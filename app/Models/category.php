<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
    ];
    
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}