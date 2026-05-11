<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('pages.home');
});


/*
|--------------------------------------------------------------------------
| CATEGORÍAS
|--------------------------------------------------------------------------
*/
Route::get('/categoria/{nombre}', function ($nombre) {

    $nombre = strtolower($nombre);

    if ($nombre === 'caballero') {
        $banner = 'banners/Banner_deporte.jpg';

        $productos = [
            ['nombre' => 'Bigotes Negro', 'imagen' => 'img/productos/caballero/bigotes_negro.png', 'precio' => 79999, 'tallas' => '38-43'],
            ['nombre' => 'Bigotes Verde', 'imagen' => 'img/productos/caballero/bigotes_verde.png', 'precio' => 79999, 'tallas' => '38-43'],
            ['nombre' => 'Bolichero Negro', 'imagen' => 'img/productos/caballero/bolichero_negro.png', 'precio' => 79999, 'tallas' => '38-43'],
            ['nombre' => 'Bolichero Blanco', 'imagen' => 'img/productos/caballero/bolichero_blanco.png', 'precio' => 79999, 'tallas' => '38-43'],
            ['nombre' => 'Cool', 'imagen' => 'img/productos/caballero/cool.png', 'precio' => 79999, 'tallas' => '38-43'],
            ['nombre' => 'Mool', 'imagen' => 'img/productos/caballero/mool.png', 'precio' => 79999, 'tallas' => '38-43'],
            ['nombre' => 'Rayo Azul', 'imagen' => 'img/productos/caballero/rayo_azul.png', 'precio' => 79999, 'tallas' => '38-43'],
            ['nombre' => 'Sticker', 'imagen' => 'img/productos/caballero/sticker.png', 'precio' => 79999, 'tallas' => '38-43'],
            ['nombre' => 'Tractor Blanco A', 'imagen' => 'img/productos/caballero/tractor_blanco_a.png', 'precio' => 79999, 'tallas' => '38-43'],
            ['nombre' => 'Tractor Blanco N', 'imagen' => 'img/productos/caballero/tractor_blanco_n.png', 'precio' => 79999, 'tallas' => '38-43'],
            ['nombre' => 'Trenza Negra', 'imagen' => 'img/productos/caballero/trenza_negra.png', 'precio' => 79999, 'tallas' => '38-43'],
        ];

    } elseif ($nombre === 'dama') {
        $banner = 'banners/Banner_dama.jpg';
        $productos = [];

    } elseif ($nombre === 'ninos' || $nombre === 'ninas') {
        $banner = 'banners/Banner_Niños.jpg';
        $productos = [];

    } else {
        $banner = 'banners/Banner_home.jpg';
        $productos = [];
    }

    return view('pages.categoria', [
        'categoria' => ucfirst($nombre),
        'banner' => asset($banner),
        'productos' => $productos
    ]);
});


/*
|--------------------------------------------------------------------------
| PERSONALIZADOS
|--------------------------------------------------------------------------
*/
Route::get('/personalizados/{nombre}', function ($nombre) {

    $nombre = strtolower($nombre);

    if ($nombre === 'pisa-huevos') {
        $banner = 'banners/Banner_pisahuevos.jpg';
    } elseif ($nombre === 'vans' || $nombre === 'botas') {
        $banner = 'banners/Banner_deporte.jpg';
    } else {
        $banner = 'banners/Banner_home.jpg';
    }

    return view('pages.categoria-personalizada', [
        'categoria' => ucfirst(str_replace('-', ' ', $nombre)),
        'banner' => asset($banner),
        'productos' => []
    ]);
});


require __DIR__.'/auth.php';