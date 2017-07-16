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

// Route::get('api/publicaciones', function () {
//     return Datatables::eloquent(App\Publicaciones::query())->make(true);
// });

    Route::get('publicaciones','PublicacionesController@index');
    Route::get('api/publicaciones','PublicacionesController@getTablaPublicaciones');
    Route::get('api/categorias', 'CategoriasController@show');
    Route::get('api/autores', 'AutoresController@show');
    Route::get('api/letras', 'PublicacionesController@obtenerLetras');
    Route::get('api/verDetalle', 'PublicacionesController@show');
    Route::get('api/publicacionesFiltro', 'PublicacionesController@getTablaPublicacionesFiltro');
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




