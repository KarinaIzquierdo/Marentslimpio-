<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelo extends Model
{
    protected $table = 'modelos';
    public $timestamps = false;
    protected $fillable = ['nombre', 'categoria_id'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'modelo_id');
    }
}
