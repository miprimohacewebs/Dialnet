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
    
//     $publicaciones = \App\Publicaciones::all();
//     return View::make('index', compact('publicaciones'));
    return View::make('index');
});

Route::get('/api/publicaciones', function () {
    return Datatables::eloquent(\App\Publicaciones::query())->make(true);
});




// Route::get('/', 'PublicacionesController@index');
// Route::get('/Publicaciones', 'PublicacionesController@getPublicaciones')->name('datatable.publicaciones');


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
    Route::get('publicaciones','PublicacionesController@index');
    Route::get('publicaciones/consiguePublicaciones','PublicacionesController@getTablaPublicaciones');
    
});


Route::auth();

Route::get('/home', 'HomeController@index');


