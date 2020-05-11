<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('error/404', function () {
    return 'errors.404';
})->name('error.404');

//Declaramos rutas para la consulta de productos a mostrar en la página
Route::name('consulta.')->group(function () {
    Route::get('/', 'ConsultaController@index')->name('index');
    Route::get('productos', 'ConsultaController@productos')->name('productos');
    Route::get('producto/{producto}/detalle', 'ConsultaController@detalle')->name('detalle');
    Route::get('sub_categoria/{sub_categoria}/productos', 'ConsultaController@sub_categoria')->name('sub_categoria');
    Route::get('buscar/producto', 'ConsultaController@buscar')->name('buscar');
    Route::get('empresa', 'ConsultaController@empresa')->name('empresa');
    Route::get('contacto', 'ConsultaController@contacto')->name('contacto');
});


//Declaramos rutas para la información de login y usuario en la página
/* ::::::::::::::::: ESTAS RUTAS NO NECESITA QUE EL USUARIO ESTE LOGUEADO :::::::::::: */
Route::group(['middleware' => ['guest']], function () {
    Route::name('user.')->group(function () {
        Route::get('login', 'UsuarioController@login')->name('login');
        Route::post('postlogin', 'UsuarioController@postlogin')->name('postlogin');
        Route::post('create', 'UsuarioController@create')->name('create');
    });
});
/* ::::::::::::::::: ESTAS RUTAS NECESITA QUE EL USUARIO ESTE LOGUEADO :::::::::::: */
Route::group(['middleware' => ['auth']], function () {
    Route::name('user.')->group(function () {
        Route::get('perfil', 'UsuarioController@perfil')->name('perfil');
        Route::get('perfil/pedido/{numero}/detalle', 'UsuarioController@detalle_pedido')->name('detalle_pedido');
        Route::get('logout', 'UsuarioController@logout')->name('logout');
    });
});


//Declaramos rutas para comentarios de productos o de la página
/* ::::::::::::::::: ESTAS RUTAS NO NECESITA QUE EL USUARIO ESTE LOGUEADO :::::::::::: */
Route::group(['middleware' => ['guest']], function () {
    Route::name('comentario_general.')->group(function () {
        Route::get('comentarios', 'ComentariosController@comentario_general_index')->name('index');
    });
});
/* ::::::::::::::::: ESTAS RUTAS NECESITA QUE EL USUARIO ESTE LOGUEADO :::::::::::: */
Route::group(['middleware' => ['auth']], function () {
    Route::name('comentario_general.')->group(function () {
        Route::post('comentario/general/nuevo', 'ComentariosController@comentario_general_nuevo')->name('nuevo');
        Route::get('comentario/general/eliminar/{id}', 'ComentariosController@comentario_general_eliminar')->name('eliminar');
    });
});
/* ::::::::::::::::: ESTAS RUTAS NECESITA QUE EL USUARIO ESTE LOGUEADO :::::::::::: */
Route::group(['middleware' => ['auth']], function () {
/* ::::::::::::::::: ESTAS RUTAS NECESITA QUE EL USUARIO ESTE LOGUEADO :::::::::::: */
    Route::name('comentario_producto.')->group(function () {
        Route::post('comentario/producto/nuevo', 'ComentariosController@comentario_producto_nuevo')->name('nuevo');
        Route::get('comentario/producto/eliminar/{id}', 'ComentariosController@comentario_producto_eliminar')->name('eliminar');
    });
});


//Declaramos rutas para gestionar productos en el carrito
/* ::::::::::::::::: ESTAS RUTAS NECESITA QUE EL USUARIO ESTE LOGUEADO :::::::::::: */
Route::group(['middleware' => ['guest']], function () {
    Route::name('carrito.')->group(function () {
        Route::get('carrito', 'CarritoController@index')->name('index');
        Route::get('agregar/inmediatamente/{producto}', 'CarritoController@agregar_inmediatamente')->name('agregar_inmediatamente');
        Route::post('agregar/mas', 'CarritoController@agregar_mas')->name('agregar_mas');
        Route::get('eliminar/{producto}', 'CarritoController@eliminar')->name('eliminar');
        Route::get('eliminar/cantidad/{producto}', 'CarritoController@eliminar_cantidad')->name('eliminar_cantidad');
    });
});


//Declaramos rutas para registrar pedido
/* ::::::::::::::::: ESTAS RUTAS NECESITA QUE EL USUARIO ESTE LOGUEADO :::::::::::: */
Route::group(['middleware' => ['auth']], function () {
    Route::name('pedido.')->group(function () {
        Route::get('pedido', 'PedidoController@index')->name('index');
        Route::post('realizar/pedido', 'PedidoController@realizar')->name('realizar');
    });
});
