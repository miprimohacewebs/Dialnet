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

    /** Ruta para realizar el logout */
    Route::get('app/logout', 'Auth\AuthController@logout');

    /**
     * Rutas de publicaciones
     */

    Route::get('publicacionesadmin','PublicacionesController@create');

    /** Ruta para guardar una publicación */
    Route::post('administrador/guardarPublicacion','PublicacionesController@store');

    /** Ruta para guardar una publicación */
    Route::post('administrador/modificarPublicacion/{id}','PublicacionesController@update');

    Route::get('modificarPublicacion/{id}','PublicacionesController@edit');

    Route::get('eliminarPublicacion/{id}','PublicacionesController@destroy');


    /**
     * Rutas de Categorías
     */

    Route::get('categoriasadmin', 'CategoriasController@create');

    /** Ruta para guardar una categoria */
    Route::post('administrador/guardarCategoria','CategoriasController@store');

    Route::get('modificarCategorias/{id}','CategoriasController@edit');

    /** Ruta para guardar una categoria */
    Route::post('administrador/modificarCategoria/{id}','CategoriasController@update');

    Route::get('eliminarCategoria/{id}','CategoriasController@destroy');


    /**
     * Rutas de autores
     */

    Route::get('autoresadmin', 'AutoresController@create');

    Route::post('administrador/guardarAutor','AutoresController@store');

    Route::get('modificarAutor/{id}','AutoresController@edit');

    Route::post('administrador/modificarAutor/{id}','AutoresController@update');

    Route::get('eliminarAutor/{id}','AutoresController@destroy');

    /**
     * Rutas de editores
     */

    Route::get('editoresadmin', 'EditoresController@create');

    Route::post('administrador/guardarEditor','EditoresController@store');

    Route::get('modificarEditor/{id}','EditoresController@edit');

    Route::post('administrador/modificarEditor/{id}','EditoresController@update');

    Route::get('eliminarEditor/{id}','EditoresController@destroy');

    /**
     * Rutas descriptores
     */

    Route::get('api/obtenerDescriptores/{etiqueta}', 'PublicacionesController@obtenerDescriptores');
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
    Route::get('api/categorias', 'CategoriasController@mostrarCategorias');
    /** Ruta para rellenar la tabla de autores */
    Route::get('api/autores', 'AutoresController@mostrarAutores');
    /** Ruta para rellenar la tabla de letras de publicaciones */
    Route::get('api/letras', 'PublicacionesController@obtenerLetras');
    /** Ruta para rellenar la tabla de editores */
    Route::get('api/editores','EditoresController@show');
    /** Ruta para rellenar la tabla de descriptores en publicaciones */
    Route::get('api/descriptores', 'PublicacionesController@obtenerDescriptoresDatatable');
    /** Ruta para rellenar la tabla de descriptores en publicaciones */
    Route::get('api/annos', 'PublicacionesController@obtenerAnnos');
    /** Formulario de contacto */
    Route::get('contacto','ContactoController@create');
    Route::post('contacto_store','ContactoController@store');
    /*
    Route::get('contacto',
        ['as' => 'contacto', 'uses' => 'ContactoController@create']);
    Route::post('contacto',
        ['as' => 'contacto_store', 'uses' => 'ContactoController@store']);
    */

    Route::get('emails.contacto', function () {
        return View::make('contacto');
    });
});




