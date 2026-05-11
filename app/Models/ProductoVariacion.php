<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductoVariacion extends Model
{
    protected $table = 'producto_variacion';

    public $timestamps = false;

    protected $fillable = [
        'producto_id',
        'talla_id',
        'color_id',
        'color_secundario_id', 
        'costo',               
        'stock',
        'tiene_descuento',     
        'valor_descuento'      
    ];

    // 🔗 RELACIONES

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // COLOR PRINCIPAL
    public function colorPrimario()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    // COLOR SECUNDARIO
    public function colorSecundario()
    {
        return $this->belongsTo(Color::class, 'color_secundario_id');
    }

    //  TALLA
    public function talla()
    {
        return $this->belongsTo(Talla::class);
    }
}