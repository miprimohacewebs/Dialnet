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

/** Ruta para la autenticación de administradores */
Route::get('login', function () {
    return View::make('login');
});

/**
 * Grupo con el middleware autenticado, incluye los middleware web y auth
 * Necesario para:
 * - Validar que el usuario se encuentra logado.
 * - OJO: todas las acciones que se metan aquí solo podrán ser ejecutadas por usuarios logados.
 * - valida tokens csrf, para usar esta funcionalidad solo hay que agregar dentro del formulario este Código {{ csrf_field() }}
 * - Obtener datos de la sesión/request.
 */
Route::group(['middleware' => ['autenticado']], function () {
    /** Rutas zona administración*/
    Route::get('administracion','AdministracionController@index');

    Route::get('categoriasadmin', function () {
        return View::make('administracion/categorias');
    });
    Route::get('autoresadmin', function () {
        return View::make('administracion/autores');
    });

    Route::get('publicacionesadmin','PublicacionesController@create');

    Route::get('modificarPublicacion/{id}','PublicacionesController@edit');

    Route::get('eliminarPublicacion/{id}','PublicacionesController@destroy');

    /** Ruta para guardar una publicación */
    Route::post('administrador/guardarPublicacion','PublicacionesController@store');

    /** Ruta para realizar el logout */
    Route::get('app/logout', 'Auth\AuthController@logout');
});

/**
 * Grupo con el middleware web
 * Necesario para:
 * - valida tokens csrf, para usar esta funcionalidad solo hay que agregar dentro del formulario este Código {{ csrf_field() }}
 * - Obtener datos de la sesión/request.
 */
Route::group(['middleware' => ['web']], function () {
    Route::auth();

    Route::get('/', 'IndexController@index');

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
});




