<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

/**
 * @property integer $x_idpublicacion
 * @property integer $aga_x_idgrupoautor
 * @property integer $gcat_x_idgrupocategoria
 * @property integer $ge_x_idgrupoeditor
 * @property integer $dgd_idGrupoDescriptor
 * @property string $tx_titulo
 * @property string $tx_isbn
 * @property string $nu_anno
 * @property string $tx_paginas
 * @property string $tx_editorial
 * @property string $tx_publicacion
 * @property string $tx_resumen
 * @property string $tx_descriptores
 * @property string $tx_imagen
 * @property string $tx_doi
 * @property string $tx_enlacedoi
 * @property string $tx_asunto
 * @property string $fh_fechapublicacion
 * @property string $tx_pais
 * @property string $tx_idioma
 * @property integer $nu_numPaginas
 * @property AutorGrupoautor $autorGrupoautor
 * @property categoriaGrupoCategoria $categoriaGrupoCategoria
 * @property EditorGrupoeditor $editorGrupoeditor
 */
class Publicaciones extends Model
{
    /** Tabla asociada con el modelo. */
    protected $table = 'publicaciones';

    /** Primary key de la tabla. */
    protected $primaryKey = 'x_idpublicacion';
    
    /**
     * @var array
     */
    protected $fillable = ['aga_x_idgrupoautor', 'gcat_x_idgrupocategoria', 'ge_x_idgrupoeditor', 'dgd_idGrupoDescriptor', 'tx_titulo', 'tx_isbn', 'nu_anno', 'tx_paginas', 'tx_editorial', 'tx_publicacion', 'tx_resumen', 'tx_descriptores', 'tx_imagen', 'tx_doi', 'tx_enlacedoi', 'tx_asunto', 'fh_fechapublicacion', 'tx_pais', 'tx_idioma', 'nu_numPaginas'];
    
    /**
     * Método para emparejar autor con grupoAutor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function autorGrupoautor()
    {
        return $this->belongsTo('App\autorGrupoautor', 'aga_x_idgrupoautor', 'ga_x_idgrupoautor');
    }
    
    /**
     * Método para obtener las categorías
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoriaGrupoCategoria()
    {
        return $this->belongsTo('App\categoriaGrupoCategoria', 'gcat_x_idgrupocategoria', 'gt_x_idGrupoCategoria');
    }
    
    /**
     * Método para emparejar editor con grupoEditor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editorGrupoeditor()
    {
        return $this->belongsTo('App\editorGrupoeditor', 'ge_x_idgrupoeditor', 'ge_x_idgrupoeditor');
    }

    /**
     * Método para emparejar editor con grupoEditor
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function descriptoresGrupoDescriptor()
    {
        return $this->belongsTo('App\descriptoresGrupoDescriptor', 'dgd_idGrupoDescriptor', 'x_idGrupoDescriptor');
    }

    /**
     * Método para obtener las iniciales de las publicaciones.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function obtenerLetrasSeccion(){
        $vuelta = DB::table('publicaciones')
        ->select(DB::raw('substring(upper(tx_titulo),1,1) as letras'))
        ->orderBy('letras')
        ->distinct()
        ->get();
        
        return collect($vuelta);
    }

    /**
     * Método para obtener las publicaciones según filtro.
     *
     * @param $valor
     * @param $tipo
     * @return \Illuminate\Support\Collection
     */
    public static function obtenerPublicaciones($valor, $tipo){
        $tipoValor = '';
        $operador = '=';
        $valorBuscar = $valor;
        
        
        switch($tipo){
            case 'cat':
                $tipoValor = "categoria_grupoCategoria.cat_x_idCategoria";
                break;
            case 'aut':
                $tipoValor = "autor_grupoautor.aut_x_idautor";
                break;
            case 'tit':
                $tipoValor = "tx_titulo";
                $operador = 'like';
                $valorBuscar= $valorBuscar.'%';
                break;
            
        }
        
        $vuelta = DB::table('publicaciones')
                      ->select('publicaciones.*')
                      ->leftjoin('autor_grupoautor', 'publicaciones.aga_x_idgrupoautor', '=', 'autor_grupoautor.ga_x_idgrupoautor')
                      ->leftjoin('categoria_grupoCategoria', 'publicaciones.gcat_x_idGrupoCategoria', '=', 'categoria_grupoCategoria.gt_x_idGrupoCategoria')
                      ->where($tipoValor, $operador, $valorBuscar)
                      ->distinct()
                      ->get();
        return collect($vuelta);
    }

    /**
     * Método para obtener las publicaciones según filtro.
     *
     * @param $valor
     * @param $tipo
     * @return \Illuminate\Support\Collection
     */
    public static function obtenerPublicacionesMultiplesPosibilidades($valoresAnio, $valoresAutores, $valoresCategorias, $valoresDescriptores){

        $query = DB::table('publicaciones')
            ->select('publicaciones.*')
            ->leftjoin('autor_grupoautor', 'publicaciones.aga_x_idgrupoautor', '=', 'autor_grupoautor.ga_x_idgrupoautor')
            ->leftjoin('categoria_grupoCategoria', 'publicaciones.gcat_x_idGrupoCategoria', '=', 'categoria_grupoCategoria.gt_x_idGrupoCategoria')
            ->leftjoin('descriptores_grupoDescriptor', 'publicaciones.dgd_idGrupoDescriptor', '=', 'descriptores_grupoDescriptor.x_idGrupoDescriptor');

        if ($valoresAnio!=null){
            $query->whereIn('publicaciones.nu_anno', $valoresAnio);
        }

        if ($valoresAutores!=null){
            $query->whereIn('autor_grupoautor.aut_x_idautor', $valoresAutores);
        }

        if ($valoresCategorias!=null){
            $query->whereIn('categoria_grupoCategoria.cat_x_idCategoria', $valoresCategorias);
        }

        if ($valoresDescriptores!=null){
            $query->whereIn('descriptores_grupoDescriptor.desc_x_iddescriptor', $valoresDescriptores);
        }


        $vuelta = $query->distinct()->distinct()->get();
        return collect($vuelta);
    }

    /**
     * Método para obtener datos de la vista publicaciones
     *
     * @return \Illuminate\Support\Collection
     */
    public static function obtenerInformacionDetalle($idPublicacion){
        $detallePublicacion = DB::table('v_publicaciones')->select('tx_titulo', 'tx_isbn', 'nu_anno','tx_paginas','tx_editorial','tx_publicacion',
            'tx_resumen','tx_descriptores','tx_imagen','tx_doi','tx_enlacedoi','tx_asunto','fh_fechapublicacion', 'tx_pais','tx_idioma',
            'nu_numPaginas','tx_categoria','autores','editores','descriptores')
            ->where('x_idpublicacion','=',$idPublicacion)
            ->get();
        return collect($detallePublicacion);
    }

    /**
     * Método para conseguir el número total de publicaciones
     *
     * @return número de publicaciones
     */
    public static function obtenerNumeroPublicaciones(){
        return DB::table('publicaciones')->count();
    }

    public static function obtenerAnnosDatatable ($valoresAnio, $valoresAutores, $valoresCategorias, $valoresDescriptores){

        $reemplazo1='';
        $reemplazo2='';
        $query = 'SELECT count(p.nu_anno) numPublicaciones, p.nu_anno nombre, p.nu_anno id FROM publicaciones p WHERE p.nu_anno IN (SELECT p.nu_anno FROM publicaciones p LEFT JOIN categoria_grupoCategoria C2 on p.gcat_x_idgrupocategoria = C2.gt_x_idGrupoCategoria LEFT JOIN categorias c ON C2.cat_x_idCategoria = c.x_idcategoria LEFT JOIN descriptores_grupoDescriptor dgd ON p.dgd_idGrupoDescriptor = dgd.x_idGrupoDescriptor LEFT JOIN descriptores d ON dgd.desc_x_iddescriptor = d.x_iddescriptor LEFT JOIN autor_grupoautor a on p.aga_x_idgrupoautor = a.ga_x_idgrupoautor LEFT JOIN autores a2 ON a.aut_x_idautor = a2.idAutor &insert2) &insert GROUP BY p.nu_anno ORDER BY p.nu_anno';
        if ($valoresAnio!==null){
            $reemplazo = ' and p.nu_anno in ('.$valoresAnio.')';
        }

        if ($valoresAutores!==null){
            $reemplazo2 = 'where a.aut_x_idautor in ('.$valoresAutores.')';
        }

        if ($valoresCategorias!==null){
            if ($reemplazo2===''){
                $reemplazo2 = 'where C2.cat_x_idCategoria in ('.$valoresCategorias.')';
            }else{
                $reemplazo2 = $reemplazo2.' and C2.cat_x_idCategoria in ('.$valoresCategorias.')';
            }
        }

        if ($valoresDescriptores!==null){
            if ($reemplazo2===''){
                $reemplazo2 = 'where dgd.desc_x_iddescriptor in ('.$valoresDescriptores.')';
            }else{
                $reemplazo2 = $reemplazo2.' and dgd.desc_x_iddescriptor in ('.$valoresDescriptores.')';
            }
        }

        $query = str_replace('&insert2', $reemplazo2, $query);
        $query = str_replace('&insert', $reemplazo1, $query);

        return collect(DB::select (DB::raw($query)));
    }



    public static function guardarPublicacion($publicacion){
        $convert_date = null;
        if ($publicacion['fechaPublicacion']!='') {
            $convert_date = date("Y-m-d", strtotime($publicacion['fechaPublicacion']));
        }
        DB::table('publicaciones')->insertGetId(
            ['tx_titulo'=>$publicacion['titulo'], 'gcat_x_idgrupocategoria'=>$publicacion['idCategoria'],
                'tx_doi'=>$publicacion['doi'], 'tx_isbn'=>$publicacion['isbn'], 'tx_asunto'=>$publicacion['asunto'], 'nu_anno'=>$publicacion['anno'],
                'tx_resumen'=>$publicacion['resumen'], 'tx_pais'=>$publicacion['pais'], 'tx_idioma'=>$publicacion['idioma'], 'tx_publicacion'=>$publicacion['publicacion'],
                'tx_editorial'=>$publicacion['editorial'], 'tx_descriptores'=>$publicacion['descriptores'], 'fh_fechapublicacion'=>$convert_date,
                'tx_enlacedoi'=>$publicacion['enlacedoi'], 'tx_paginas'=>$publicacion['paginas'], 'nu_numPaginas'=>$publicacion['numPaginas'], 'tx_imagen'=>$publicacion['imagen'],
                'aga_x_idgrupoautor'=>$publicacion['idAutor'],'ge_x_idgrupoeditor'=>$publicacion['idEditor'],'dgd_idGrupoDescriptor'=>$publicacion['idDescriptor']
            ]
        );

        return DB::getPdo()->lastInsertId();
    }

    public static function actualizarPublicacion($publicacion){
        $convert_date = null;
        if ($publicacion['fechaPublicacion']!='') {
            $convert_date = date("Y-m-d", strtotime($publicacion['fechaPublicacion']));
        }
        DB::table('publicaciones')->where('x_idpublicacion', $publicacion['idPublicacion'])
            ->update(
            ['tx_titulo'=>$publicacion['titulo'], 'gcat_x_idgrupocategoria'=>$publicacion['idCategoria'],
                'tx_doi'=>$publicacion['doi'], 'tx_isbn'=>$publicacion['isbn'], 'tx_asunto'=>$publicacion['asunto'], 'nu_anno'=>$publicacion['anno'],
                'tx_resumen'=>$publicacion['resumen'], 'tx_pais'=>$publicacion['pais'], 'tx_idioma'=>$publicacion['idioma'], 'tx_publicacion'=>$publicacion['publicacion'],
                'tx_editorial'=>$publicacion['editorial'], 'tx_descriptores'=>$publicacion['descriptores'], 'fh_fechapublicacion'=>$convert_date,
                'tx_enlacedoi'=>$publicacion['enlacedoi'], 'tx_paginas'=>$publicacion['paginas'], 'nu_numPaginas'=>$publicacion['numPaginas'], 'tx_imagen'=>$publicacion['imagen'],
                'aga_x_idgrupoautor'=>$publicacion['idAutor'],'ge_x_idgrupoeditor'=>$publicacion['idEditor'],'dgd_idGrupoDescriptor'=>$publicacion['idDescriptor']
            ]
        );
    }
}
