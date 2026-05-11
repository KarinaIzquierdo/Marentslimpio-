<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'color';

    public $timestamps = false; // 🔥 IMPORTANTE

    protected $fillable = [
        'nombre'
    ];

    // 🔗 RELACIÓN (útil)
    public function variaciones()
    {
        return $this->hasMany(ProductoVariacion::class);
    }
}