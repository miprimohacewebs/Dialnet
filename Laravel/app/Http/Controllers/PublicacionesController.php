<?php

namespace App\Http\Controllers;
use App\Publicaciones;
use App\Categorias;
use App\Autores;
use App\Editor;
use App\autorGrupoAutor;
use App\editorGrupoEditor;
use Datatables;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Validator;
use Session;
use Exception;
use Storage;

class PublicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('publicaciones.index');
    }
    
    /**
     * Muestra los campos de la tablaPublicaciones
     * @return publicaciones para rellenar el datatable
     */
    public function getTablaPublicaciones()
    {
        $publicaciones = Publicaciones::all();
        return Datatables::of($publicaciones)->make(true);
        
    }

    /**
     * Muestra los campos de la tablaPublicaciones
     * @param int $valor
     * @param String $tipo tipo de valor, 'cat' categoria, 'aut' autor, 'tit' titulo. 
     * @return publicaciones para rellenar el datatable.
     */
    public function getTablaPublicacionesFiltro(Request $request)
    {
        $valor = $request->get('valor');
        $tipo = $request->get('tipo');
        $publicaciones = Publicaciones::obtenerPublicaciones($valor, $tipo);
        return Datatables::of($publicaciones)->make(true);
        
    }
    
    /**
     * Obtiene la primera letra de los titulos de publicaciones, las ordena y no mete repetidas.
     * @return Tabla de primeras letras de publicaciones
     */
    public function obtenerLetras() {
        $letras = Publicaciones::obtenerLetrasSeccion();
        return Datatables::of($letras)->make(true);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $autoresSeleccionados1 = null;
        $editoresSeleccionados1 = null;
        $categorias1 = Categorias::orderBy('tx_categoria')->get(['x_idcategoria', 'tx_categoria']);
        $autores1 = Autores::orderBy('tx_autor')->get(['idautor', 'tx_autor']);
        $editores1 = Editor::orderBy('tx_editor')->get(['x_ideditor','tx_editor']);
        if (! empty ($request->session()->get('autoresSeleccionados2'))) {
            $autoresSeleccionados1 = collect($request->session()->get('autoresSeleccionados2'));
        }
        if (! empty ($request->session()->get('editoresSeleccionados2'))) {
            $editoresSeleccionados1 = collect($request->session()->get('editoresSeleccionados2'));
        }
        $vuelta = array('categorias' => $categorias1, 'autores' => $autores1, 'editores' => $editores1, 'autoresSeleccionados' => $autoresSeleccionados1, 'editoresSeleccionados' => $editoresSeleccionados1);
        return view('administracion/publicaciones', $vuelta);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'max:300',
            'subtitulo' => 'max:500',
            'asunto' => 'max:200',
            'resumen' => 'max:200',
            'obra' => 'max:200',
            'descriptores' => 'max:500',
            'genero' => 'max:30',
            'isbn' => 'max:80',
            'anno' => 'bail|date_format:Y|before:+1 year',
            'pais' => 'max:50',
            'idioma' => 'max:50',
            'edicion' => 'max:50',
            'fechaPublicacion' => 'bail|date_format:d/m/Y|before:today',
            'paginas' => 'max:16',
            'numPaginas' => 'bail|integer|max:99999999',

        ]);

        if ($validator->fails()){
            $autores2 = Autores::obtenerlistaAutoresSeleccionados($request->seleccionadosAutores);
            $editores2 = Editor::obtenerListaeditoresSeleccionados($request->seleccionadosEditores);
            $vuelta = array('autoresSeleccionados2'=>$autores2, 'editoresSeleccionados2'=>$editores2);
            return redirect()->to('publicacionesadmin')
                ->withErrors($validator)
                ->withInput()
                ->with($vuelta);
        }


        $idGrupoAutor = autorGrupoAutor::agruparAutores($request->seleccionadosAutores);

        $idGrupoEditor = editorGrupoEditor::AgruparEditores($request->seleccionadosEditores);

        $imagen = $request->imagenPublicacion;

        if ($imagen!=null){
            Storage::get($imagen);
        }

        $publicacion= ['titulo'=>$request->titulo, 'subtitulo'=>$request->subtitulo,
            'asunto'=>$request->asunto, 'resumen'=>$request->resumen, 'obra'=>$request->obra,
            'descriptores'=>$request->descriptores, 'genero'=>$request->genero,
            'categoria'=>$request->categoria, 'isbn'=>$request->isbn, 'anno'=>$request->anno,
            'pais'=>$request->pais, 'idioma'=>$request->idioma, 'edicion'=>$request->edicion,
            'fechaPublicacion'=>$request->fechaPublicacion, 'paginas'=>$request->paginas,
            'numPaginas'=>$request->numPaginas, 'idAutor'=>$idGrupoAutor, 'idEditor'=> $idGrupoEditor];
        Publicaciones::guardarPublicacion($publicacion);

        $request->session()->flash('alert-success', 'Se ha creado la publicación');
        return redirect()->action('PublicacionesController@create')->with('alert-success', 'Se ha creado la publicación');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publicacion = Publicaciones::where('x_idpublicacion', $id)->get(['tx_titulo', 'tx_isbn', 'tx_paginas', 'tx_edicion', 'tx_resumen']);
        return $publicacion;
    }

    /**
     * Reenvía los detalles de la publicación indcada por idPublicación por petición JQuery
     * @param Request $request
     */
    public function verDetallePublicacion(Request $request) {
        $idPublicacion= $request->idPublicacion;

        $publicacion = Publicaciones::obtenerInformacionDetalle($idPublicacion);
        return response()->json(array('success' => true, 'publicacion' => $publicacion, 'msg' => 'Se han generado los detalles de la publicacion'));

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $publicacion = Publicaciones::where('x_idpublicacion', $id)->first();
        $imagen = null;
        if ($publicacion['tx_imagen']!=null) {
            $imagen = Storage::get($publicacion['tx_imagen']);
        }

        $publicacionVuelta= ['titulo'=>$publicacion['tx_titulo'], 'subtitulo'=>$publicacion['tx_subtitulo'],
        'asunto'=>$publicacion['tx_asunto'], 'resumen'=>$publicacion['tx_resumen'], 'obra'=>$publicacion['tx_obra'],
            'descriptores'=>$publicacion['tx_descriptores'], 'genero'=>$publicacion['tx_genero'],
            'categoria'=>$publicacion['cat_x_idcategoria'], 'isbn'=>$publicacion['tx_isbn'], 'anno'=>$publicacion['nu_anno'],
            'pais'=>$publicacion['tx_pais'], 'idioma'=>$publicacion['tx_idioma'], 'edicion'=>$publicacion['tx_edicion'],
            'fechaPublicacion'=>$publicacion['fh_fechapublicacion'], 'paginas'=>$publicacion['tx_paginas'],
            'numPaginas'=>$publicacion['nu_numPaginas'], 'idAutor'=>$publicacion['aga_x_idgrupoautor'], 'idEditor'=> $publicacion['ge_x_idgrupoeditor'],
            'imagen'=>$imagen, 'idPublicacion'=>$publicacion['x_idpublicacion']];

        $categorias = Categorias::orderBy('tx_categoria')->get(['x_idcategoria', 'tx_categoria']);
        $autores = Autores::orderBy('tx_autor')->get(['idautor', 'tx_autor']);
        $editores = Editor::orderBy('tx_editor')->get(['x_ideditor','tx_editor']);
        $autoresSeleccionados = autorGrupoAutor::where('aut_x_idautor',$publicacion['aga_x_idgrupoautor'])->get(['aut_x_idautor']);
        dd($autoresSeleccionados);
        $editoresSeleccionados = Editor::obtenerListaeditoresSeleccionados($publicacion['ge_x_idgrupoeditor']);

        $vuelta = array('publicacion' => $publicacionVuelta, 'categorias' => $categorias, 'autores' => $autores, 'editores' => $editores,
            'autoresSeleccionados' => $autoresSeleccionados, 'editoresSeleccionados' => $editoresSeleccionados);
        return view('administracion/publicaciones', $vuelta);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $imagenPublicacion = Publicaciones::select('tx_imagen')->where('x_idpublicacion', $id)->first();
            if ($imagenPublicacion['tx_imagen']!=null && Storage::disk('local')->exists($imagenPublicacion['tx_imagen'])){
                Storage::delete($imagenPublicacion['tx_imagen']);
            }
            Publicaciones::destroy($id);
        }catch (Exception $e){
            Log::error($e);
            return redirect()->action('AdministracionController@index')->with('alert-error', 'Ha ocurrido un error al borrar la publicación');
        }

        return redirect()->action('AdministracionController@index')->with('alert-success', 'Se ha borrado la publicación');
    }
}
