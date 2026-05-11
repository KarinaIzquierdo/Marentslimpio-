<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Talla extends Model
{
    protected $table = 'talla';

    public $timestamps = false;

    protected $fillable = [
        'numero'
    ];

    // 🔗 RELACIÓN
    public function variaciones()
    {
        return $this->hasMany(ProductoVariacion::class);
    }
}