<?php

namespace App\Http\Controllers;
use App\categoriaGrupoCategoria;
use App\Publicaciones;
use App\Categorias;
use App\Autores;
use App\Editores;
use App\Descriptores;
use App\autorGrupoAutor;
use App\editorGrupoEditor;
use App\descriptoresGrupoDescriptor;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PublicacionesController extends Controller
{
    private $imagenPublicacionDefecto = '/assets/images/imagesPublicaciones/imgTemplate.jpg';
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
    public function getTablaPublicaciones(Request $request)
    {
        $annos = $request->get('annos');
        $autores = $request->get('autores');
        $categorias = $request->get('categorias');
        $descriptores = $request->get('descriptores');
        if ($annos===''){
            $annos=null;
        }
        if ($autores===''){
            $autores = null;
        }
        if ($categorias===''){
            $categorias=null;
        }
        if ($descriptores===''){
            $descriptores=null;
        }
        if ($annos!==null){
            $annos = explode(',', $annos);
        }
        if ($autores!==null){
            $autores = explode(',', $autores);
        }
        if ($categorias!==null){
            $categorias = explode(',', $categorias);
        }
        if ($descriptores!==null){
            $descriptores = explode(',', $descriptores);
        }

        $publicaciones = Publicaciones::obtenerPublicacionesMultiplesPosibilidades($annos, $autores, $categorias, $descriptores);
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

        $annos = $request->get('annos');
        $autores = $request->get('autores');
        $categorias = $request->get('categorias');
        $descriptores = $request->get('descriptores');
        if ($annos===''){
            $annos=null;
        }
        if ($autores===''){
            $autores = null;
        }
        if ($categorias===''){
            $categorias=null;
        }
        if ($descriptores===''){
            $descriptores=null;
        }
        if ($annos!==null){
            $annos = explode(',', $annos);
        }
        if ($autores!==null){
            $autores = explode(',', $autores);
        }
        if ($categorias!==null){
            $categorias = explode(',', $categorias);
        }
        if ($descriptores!==null){
            $descriptores = explode(',', $descriptores);
        }

        $publicaciones = Publicaciones::obtenerPublicacionesMultiplesPosibilidades($annos, $autores, $categorias, $descriptores);
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


    public function obtenerDescriptoresDatatable(Request $request) {
        $annos = $request->get('annos');
        $autores = $request->get('autores');
        $categorias = $request->get('categorias');
        $descriptores = $request->get('descriptores');
        if ($annos===''){
            $annos=null;
        }
        if ($autores===''){
            $autores = null;
        }
        if ($categorias===''){
            $categorias=null;
        }
        if ($descriptores===''){
            $descriptores=null;
        }
        if ($annos!==null){
            $annos = explode(',', $annos);
        }
        if ($autores!==null){
            $autores = explode(',', $autores);
        }
        if ($categorias!==null){
            $categorias = explode(',', $categorias);
        }
        if ($descriptores!==null){
            $descriptores = explode(',', $descriptores);
        }

        $descriptores = Descriptores::obtenerDescriptoresDatatable($annos, $autores, $categorias, $descriptores);
        return Datatables::of($descriptores)->make(true);
    }

    public function obtenerAnnos(Request $request) {
        $annos = $request->get('annos');
        $autores = $request->get('autores');
        $categorias = $request->get('categorias');
        $descriptores = $request->get('descriptores');
        if ($annos===''){
            $annos=null;
        }
        if ($autores===''){
            $autores = null;
        }
        if ($categorias===''){
            $categorias=null;
        }
        if ($descriptores===''){
            $descriptores=null;
        }
        if ($annos!==null){
            $annos = explode(',', $annos);
        }
        if ($autores!==null){
            $autores = explode(',', $autores);
        }
        if ($categorias!==null){
            $categorias = explode(',', $categorias);
        }
        if ($descriptores!==null){
            $descriptores = explode(',', $descriptores);
        }

        $annos = Publicaciones::obtenerAnnosDatatable($annos, $autores, $categorias, $descriptores);
        return Datatables::of($annos)->make(true);
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
        $categoriasSeleccionadas1 = null;
        $etiquetasSeleccionadas1 = null;
        $categorias1 = Categorias::orderBy('tx_categoria')->get(['x_idcategoria', 'tx_categoria']);
        $autores1 = Autores::orderBy('tx_autorapellidos')->orderBy('tx_autor')->get(['idautor', 'tx_autor', 'tx_autorapellidos']);
        $editores1 = Editores::orderBy('tx_editor')->get(['x_ideditor','tx_editor']);
        if (! empty ($request->session()->get('autoresSeleccionados2'))) {
            $autoresSeleccionados1 = collect($request->session()->get('autoresSeleccionados2'));
        }
        if (! empty ($request->session()->get('editoresSeleccionados2'))) {
            $editoresSeleccionados1 = collect($request->session()->get('editoresSeleccionados2'));
        }
        if (! empty ($request->session()->get('categoriasSeleccionadas2'))) {
            $categoriasSeleccionadas1 = collect($request->session()->get('categoriasSeleccionadas2'));
        }
        if (! empty ($request->session()->get('etiquetasSeleccionadas2'))) {
            $etiquetasSeleccionadas1 = collect($request->session()->get('etiquetasSeleccionadas2'));
        }
        $vuelta = array('categorias' => $categorias1, 'autores' => $autores1, 'editores' => $editores1, 'autoresSeleccionados' => $autoresSeleccionados1,
            'editoresSeleccionados' => $editoresSeleccionados1, 'categoriasSeleccionadas' => $categoriasSeleccionadas1, 'etiquetasSeleccionadas' => $etiquetasSeleccionadas1);
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
        try{
            $validator = Validator::make($request->all(), [
                'titulo' => 'max:300',
                'doi' => 'max:500',
                'asunto' => 'max:200',
                'resumen' => 'max:200',
                'publicacion' => 'max:200',
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
                $editores2 = Editores::obtenerListaeditoresSeleccionados($request->seleccionadosEditores);
                $categorias2 = Categorias::obtenerListaCategoriasSeleccionadas($request->seleccionadosCategorias);
                $etiquetas2 = descriptores::obtenerDescriptoresSeleccionados($request->seleccionadosEtiquetas);
                $vuelta = array('autoresSeleccionados2'=>$autores2, 'editoresSeleccionados2'=>$editores2,
                    'categoriasSeleccionadas2'=>$categorias2, 'etiquetasSeleccionadas2'=>$etiquetas2);
                if ($request->imagenPublicacion!=null) {
                    $validator->errors()->add('imagenPublicacion', 'Debe subir la imagen de nuevo.');
                }
                return redirect()->to('publicacionesadmin')
                    ->withErrors($validator)
                    ->withInput()
                    ->with($vuelta);
            }


            $idGrupoAutor = autorGrupoAutor::agruparAutores($request->seleccionadosAutores);

            $idGrupoEditor = editorGrupoEditor::AgruparEditores($request->seleccionadosEditores);

            $idGrupoCategoria = categoriaGrupoCategoria::AgruparCategorias($request->seleccionadosCategorias);

            $idGrupoEtiqueta = descriptoresGrupoDescriptor::AgruparDescriptores($request->seleccionadosEtiquetas);
            $imagen = $request->imagenPublicacion;
            $nombreImagen=null;
            if ($imagen!=null){
                $nombreImagen = uniqid('img_', true).'.'.$imagen->clientExtension();
                Storage::put('public/'.$nombreImagen,File::get($imagen), 'public');
            }
            $publicacion= ['titulo'=>$request->titulo, 'doi'=>$request->doi,
                'asunto'=>$request->asunto, 'resumen'=>$request->resumen, 'publicacion'=>$request->publicacion,
                'descriptores'=>$request->descriptores, 'genero'=>$request->genero,
                'idCategoria'=>$idGrupoCategoria, 'isbn'=>$request->isbn, 'anno'=>$request->anno,
                'pais'=>$request->pais, 'idioma'=>$request->idioma, 'editorial'=>$request->editorial,
                'fechaPublicacion'=>$request->fechaPublicacion, 'paginas'=>$request->paginas,
                'enlacedoi'=>$request->enlacedoi, 'doi'=>$request->doi,
                'numPaginas'=>$request->numPaginas, 'idAutor'=>$idGrupoAutor, 'idEditor'=> $idGrupoEditor,
                'idDescriptor'=>$idGrupoEtiqueta, 'imagen'=>$nombreImagen];
            Publicaciones::guardarPublicacion($publicacion);

            $request->session()->flash('alert-success', 'Se ha creado la publicación');
            return redirect()->action('PublicacionesController@create')->with('alert-success', 'Se ha creado la publicación');
        }catch (Exception $e){
            Log::error($e);
            $autores2 = Autores::obtenerlistaAutoresSeleccionados($request->seleccionadosAutores);
            $editores2 = Editores::obtenerListaeditoresSeleccionados($request->seleccionadosEditores);
            $categorias2 = Categorias::obtenerListaCategoriasSeleccionadas($request->seleccionadosCategorias);
            $etiquetas2 = descriptores::obtenerDescriptoresSeleccionados($request->seleccionadosEtiquetas);
            $vuelta = array('alert-error'=>'Ha ocurrido un error al crear la publicación', 'autoresSeleccionados2'=>$autores2,
                'editoresSeleccionados2'=>$editores2, 'categoriasSeleccionadas2'=>$categorias2, 'etiquetasSeleccionasas2'=>$etiquetas2);
            if ($request->imagenPublicacion!=null) {
                $validator->errors()->add('imagenPublicacion', 'Debe subir la imagen de nuevo.');
            }
            return redirect()->action('PublicacionesController@create')
                ->withInput()
                ->with($vuelta);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publicacion = Publicaciones::where('x_idpublicacion', $id)->get(['tx_titulo', 'tx_isbn', 'tx_paginas', 'tx_editorial', 'tx_resumen']);
        return $publicacion;
    }

    /**
     * Reenvía los detalles de la publicación indcada por idPublicación por petición JQuery
     * @param Request $request
     */
    public function verDetallePublicacion(Request $request) {
        $idPublicacion= $request->idPublicacion;

        $publicacion = Publicaciones::obtenerInformacionDetalle($idPublicacion);
        if ($publicacion[0]->tx_imagen!=null){
            $publicacion[0]->tx_imagen=Storage::url($publicacion[0]->tx_imagen);
        }else{
            $publicacion[0]->tx_imagen=$this->imagenPublicacionDefecto;
        }
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
            $imagen = Storage::url($publicacion['tx_imagen']);
        }else{
            $imagen=$this->imagenPublicacionDefecto;
        }
        $publicacionVuelta= ['titulo'=>$publicacion['tx_titulo'], 'doi'=>$publicacion['tx_doi'],
            'asunto'=>$publicacion['tx_asunto'], 'resumen'=>$publicacion['tx_resumen'], 'publicacion'=>$publicacion['tx_publicacion'],
            'descriptores'=>$publicacion['tx_descriptores'], 'enlacedoi'=>$publicacion['tx_enlacedoi'],
            'idCategoria'=>$publicacion['gcat_x_idgrupocategoria'], 'isbn'=>$publicacion['tx_isbn'], 'anno'=>$publicacion['nu_anno'],
            'pais'=>$publicacion['tx_pais'], 'idioma'=>$publicacion['tx_idioma'], 'editorial'=>$publicacion['tx_editorial'],
            'fechaPublicacion'=>$publicacion['fh_fechapublicacion'], 'paginas'=>$publicacion['tx_paginas'],
            'numPaginas'=>$publicacion['nu_numPaginas'], 'idAutor'=>$publicacion['aga_x_idgrupoautor'], 'idEditor'=> $publicacion['ge_x_idgrupoeditor'],
            'imagenPublicacionAnt'=>$imagen, 'idPublicacion'=>$publicacion['x_idpublicacion'], 'idDescriptor'=>$publicacion['dgd_idGrupoDescriptor']];

        $categorias = Categorias::orderBy('tx_categoria')->get(['x_idcategoria', 'tx_categoria']);
        $autores = Autores::orderBy('tx_autorapellidos')->orderBy('tx_autor')->get(['idautor', 'tx_autor', 'tx_autorapellidos']);
        $editores = Editores::orderBy('tx_editor')->get(['x_ideditor','tx_editor']);
        $autoresSeleccionados=null;
        if ($publicacion['aga_x_idgrupoautor']!=null) {
            $autoresSeleccionados = autorGrupoAutor::obtenerAutoresPublicacion($publicacion['aga_x_idgrupoautor']);
        }
        $editoresSeleccionados=null;
        if ($publicacion['ge_x_idgrupoeditor']!=null) {
            $editoresSeleccionados = editorGrupoEditor::obtenerEditoresPublicacion($publicacion['ge_x_idgrupoeditor']);
        }

        $categoriasSeleccionadas=null;
        if ($publicacion['gcat_x_idgrupocategoria']!=null) {
            $categoriasSeleccionadas = categoriaGrupoCategoria::obtenerCategoriasPublicacion($publicacion['gcat_x_idgrupocategoria']);
        }

        $etiquetasSeleccionadas=null;
        if ($publicacion['dgd_idGrupoDescriptor']!=null){
            $etiquetasSeleccionadas = descriptoresGrupoDescriptor::obtenerDescriptoresPublicacion($publicacion['dgd_idGrupoDescriptor']);
        }

        $vuelta = array('publicacion' => $publicacionVuelta, 'categorias' => $categorias, 'autores' => $autores, 'editores' => $editores,
            'autoresSeleccionados' => $autoresSeleccionados, 'editoresSeleccionados' => $editoresSeleccionados,
            'categoriasSeleccionadas' => $categoriasSeleccionadas, 'etiquetasSeleccionadas' => $etiquetasSeleccionadas);
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
        try {
            $validator = Validator::make($request->all(), [
                'titulo' => 'max:300',
                'doi' => 'max:500',
                'asunto' => 'max:200',
                'resumen' => 'max:200',
                'publicacion' => 'max:200',
                'descriptores' => 'max:500',
                'enlacedoi' => 'max:30',
                'isbn' => 'max:80',
                'anno' => 'bail|date_format:Y|before:+1 year',
                'pais' => 'max:50',
                'idioma' => 'max:50',
                'editorial' => 'max:50',
                'fechaPublicacion' => 'bail|date_format:d/m/Y|before:today',
                'paginas' => 'max:16',
                'numPaginas' => 'bail|integer|max:99999999',

            ]);
            if ($validator->fails()){
                $autores2 = Autores::obtenerlistaAutoresSeleccionados($request->seleccionadosAutores);
                $editores2 = Editores::obtenerListaeditoresSeleccionados($request->seleccionadosEditores);
                $categorias2 = Categorias::obtenerListaCategoriasSeleccionadas($request->seleccionadosCategorias);
                $etiquetas2 = descriptores::obtenerDescriptoresSeleccionados($request->seleccionadosEtiquetas);

                $vuelta = array('autoresSeleccionados2'=>$autores2, 'editoresSeleccionados2'=>$editores2,
                    'categoriasSeleccionadas2'=>$categorias2, 'etiquetasSeleccionadas2'=>$etiquetas2);

                if ($request->imagenPublicacion!=null) {
                    $validator->errors()->add('imagenPublicacion', 'Debe subir la imagen de nuevo.');
                }

                return redirect()->to('publicacionesadmin')
                    ->withErrors($validator)
                    ->withInput()
                    ->with($vuelta);
            }

            $idGrupoAutor = autorGrupoAutor::agruparAutores($request->seleccionadosAutores);

            $idGrupoEditor = editorGrupoEditor::AgruparEditores($request->seleccionadosEditores);

            $idGrupoCategoria = categoriaGrupoCategoria::AgruparCategorias($request->seleccionadosCategorias);

            $idGrupoEtiqueta = descriptoresGrupoDescriptor::AgruparDescriptores($request->seleccionadosEtiquetas);

            $imagen = $request->imagenPublicacion;
            $nombreImagen=null;
            if ($imagen!=null){
                if ($request->imagenPublicacionAnt !=null){
                    Storage::delete($request->imagenPublicacionAnt);
                }
                $nombreImagen = uniqid('img_', true).'.'.$imagen->clientExtension();
                Storage::put('public/'.$nombreImagen,File::get($imagen), 'public');
            }else if ($request->imagenPublicacionAnt !=null){
                $nombreImagen = $request->imagenPublicacionAnt;
            }
            $publicacion= ['idPublicacion'=>$id,'titulo'=>$request->titulo, 'doi'=>$request->doi,
                'asunto'=>$request->asunto, 'resumen'=>$request->resumen, 'publicacion'=>$request->publicacion,
                'descriptores'=>$request->descriptores, 'enlacedoi'=>$request->enlacedoi,
                'idCategoria'=>$idGrupoCategoria, 'isbn'=>$request->isbn, 'anno'=>$request->anno,
                'pais'=>$request->pais, 'idioma'=>$request->idioma, 'editorial'=>$request->editorial,
                'fechaPublicacion'=>$request->fechaPublicacion, 'paginas'=>$request->paginas,
                'numPaginas'=>$request->numPaginas, 'idAutor'=>$idGrupoAutor, 'idEditor'=> $idGrupoEditor,
                'idDescriptor'=>$idGrupoEtiqueta, 'imagen'=>$nombreImagen];
            Publicaciones::actualizarPublicacion($publicacion);

            if ($request->idGrupoAutores!=null) {
                autorGrupoAutor::destroy($request->idGrupoAutores);
            }

            if ($request->idGrupoEditores!=null) {
                editorGrupoEditor::destroy($request->idGrupoEditores);
            }

            if ($request->idGrupoCategorias!=null) {
                categoriaGrupoCategoria::destroy($request->idGrupoCategorias);
            }

            if ($request->idGrupoEtiquetas!=null) {
                descriptoresGrupoDescriptor::destroy($request->idGrupoEtiquetas);
            }

            $request->session()->flash('alert-success', 'Se ha modificado la publicación');
            return redirect()->action('PublicacionesController@create')->with('alert-success', 'Se ha modificado la publicación');
        }catch (Exception $e){
            Log::error($e);
            $autores2 = Autores::obtenerlistaAutoresSeleccionados($request->seleccionadosAutores);
            $editores2 = Editores::obtenerListaeditoresSeleccionados($request->seleccionadosEditores);
            $categorias2 = Categorias::obtenerListaCategoriasSeleccionadas($request->seleccionadosCategorias);
            $etiquetas2 = descriptores::obtenerDescriptoresSeleccionados($request->seleccionadosEtiquetas);
            $vuelta = array('alert-error'=>'Ha ocurrido un error al modificar la publicación', 'autoresSeleccionados2'=>$autores2,
                'editoresSeleccionados2'=>$editores2, 'categoriasSeleccionadas2'=>$categorias2, 'etiquetasSeleccionadas2'=>$etiquetas2);
            if ($request->imagenPublicacion!=null) {
                $validator->errors()->add('imagenPublicacion', 'Debe subir la imagen de nuevo.');
            }
            return redirect()->action('PublicacionesController@create')
                ->withInput()
                ->with($vuelta);
        }
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
            $publicacion = Publicaciones::where('x_idpublicacion', $id)->first();
            if ($publicacion['tx_imagen']!=null && Storage::disk('local')->exists($publicacion['tx_imagen'])){
                Storage::delete($publicacion['tx_imagen']);
            }

            Publicaciones::destroy($id);

            if ($publicacion['aga_x_idgrupoautor']!=null) {
                autorGrupoAutor::destroy($publicacion['aga_x_idgrupoautor']);
            }

            if ($publicacion['ge_x_idgrupoeditor']!=null) {
                editorGrupoEditor::destroy($publicacion['ge_x_idgrupoeditor']);
            }

            if ($publicacion['gcat_x_idgrupocategoria']!=null) {
                categoriaGrupoCategoria::destroy($publicacion['gcat_x_idgrupocategoria']);
            }

            if ($publicacion['dgd_idGrupoDescriptor']!=null) {
                descriptoresGrupoDescriptor::destroy($publicacion['dgd_idGrupoDescriptor']);
            }
        }catch (Exception $e){
            Log::error($e);
            return redirect()->action('PublicacionesController@create')->with('alert-error', 'Ha ocurrido un error al borrar la publicación');
        }

        return redirect()->action('PublicacionesController@create')->with('alert-success', 'Se ha borrado la publicación');
    }

    public function obtenerDescriptores($etiqueta){
        return Descriptores::obtenerDescriptoresPorNombre($etiqueta);
    }
}



