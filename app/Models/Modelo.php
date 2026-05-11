<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table = 'modelo';

    public $timestamps = false; // 🔥 IMPORTANTE

    protected $fillable = [
        'nombre',
        'categoria_id'
    ];

    // 🔗 RELACIONES

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}