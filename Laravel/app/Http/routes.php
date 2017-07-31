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
/** Ruta para rellenar el detalle de una publicación */
Route::get('api/verDetallePublicacion', 'PublicacionesController@verDetallePublicacion');
/** Ruta para cargar la tabla de publicaciones filtrada */
Route::get('api/publicacionesFiltro', 'PublicacionesController@getTablaPublicacionesFiltro');
/** Ruta para rellenar la tabla de categorías */
Route::get('api/categorias', 'CategoriasController@show');
/** Ruta para rellenar la tabla de autores */
Route::get('api/autores', 'AutoresController@show');
/** Ruta para rellenar la tabla de letras de publicaciones */
Route::get('api/letras', 'PublicacionesController@obtenerLetras');
/** Ruta para la autenticación de administradores */
Route::get('login', function () {
    return View::make('login');
});

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

/**
 * Grupo con el middleware auth
 * Necesario para:
 * - Validar que el usuario se encuentra logado.
 * - OJO: todas las acciones que se metan aquí solo podrán ser ejecutadas por usuarios logados.
 */
Route::group(['middleware' => 'auth'], function () {

});

/**
 * Grupo con el middleware web
 * Necesario para:
 * - Obtener la información de login del usuario.
 */
Route::group(['middleware' => ['web']], function () {
    Route::auth();
    Route::get('/', function () {
        return View::make('index');
    });
    Route::get('administracion', function () {
        return View::make('administracion/administracion');
    });

    /** Ruta para realizar el logout */
    Route::get('app/logout', 'Auth\AuthController@logout');
});




