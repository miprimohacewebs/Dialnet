<?php
/*
 * |--------------------------------------------------------------------------
 * | Routes File
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you will register all of the routes in an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
/** Ruta index */
Route::get('/', function () {
    return View::make('index');
});

Route::get('publicaciones','PublicacionesController@index');
/** Ruta para rellenar la tabla de publicaciones */
Route::get('api/publicaciones','PublicacionesController@getTablaPublicaciones');
/** Ruta para rellenar la tabla de categorías */
Route::get('api/categorias', 'CategoriasController@show');
/** Ruta para rellenar la tabla de autores */
Route::get('api/autores', 'AutoresController@show');
/** Ruta para rellenar la tabla de letras de publicaciones */
Route::get('api/letras', 'PublicacionesController@obtenerLetras');
/** Ruta para rellenar el detalle de una publicación */
Route::get('api/verDetallePublicacion', 'PublicacionesController@verDetallePublicacion');
/** Ruta para cargar la tabla de publicaciones filtrada */
Route::post('api/publicacionesFiltro', 'PublicacionesController@getTablaPublicacionesFiltro');
/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | This route group applies the "web" middleware group to every route
 * | it contains. The "web" middleware group is defined in your HTTP
 * | kernel and includes session state, CSRF protection, and more.
 * |
 */

Route::group(['middleware' => ['web']], function () {
   
   
});


Route::auth();

Route::get('/home', 'HomeController@index');




