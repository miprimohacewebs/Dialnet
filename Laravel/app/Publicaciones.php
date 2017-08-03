<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

/**
 * @property integer $x_idpublicacion
 * @property integer $aga_x_idgrupoautor
 * @property integer $cat_x_idcategoria
 * @property integer $ge_x_idgrupoeditor
 * @property string $tx_titulo
 * @property string $tx_isbn
 * @property string $nu_anno
 * @property string $tx_paginas
 * @property string $tx_edicion
 * @property string $tx_obra
 * @property string $tx_resumen
 * @property string $tx_descriptores
 * @property string $tx_imagen
 * @property string $tx_subtitulo
 * @property string $tx_genero
 * @property string $tx_asunto
 * @property string $fh_fechapublicacion
 * @property string $tx_pais
 * @property string $tx_idioma
 * @property integer $nu_numPaginas
 * @property AutorGrupoautor $autorGrupoautor
 * @property Categoria $categoria
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
    protected $fillable = ['aga_x_idgrupoautor', 'cat_x_idcategoria', 'ge_x_idgrupoeditor', 'tx_titulo', 'tx_isbn', 'nu_anno', 'tx_paginas', 'tx_edicion', 'tx_obra', 'tx_resumen', 'tx_descriptores', 'tx_imagen', 'tx_subtitulo', 'tx_genero', 'tx_asunto', 'fh_fechapublicacion', 'tx_pais', 'tx_idioma', 'nu_numPaginas'];
    
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
    public function categoria()
    {
        return $this->belongsTo('App\categorias', 'cat_x_idcategoria', 'x_idcategoria');
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
                $tipoValor = "cat_x_idcategoria";
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
                      ->where($tipoValor, $operador, $valorBuscar)
                      ->distinct()
                      ->get();
        return collect($vuelta);
    }

    /**
     * Método para obtener datos de la vista publicaciones
     *
     * @return \Illuminate\Support\Collection
     */
    public static function obtenerInformacionDetalle($idPublicacion){
        $detallePublicacion = DB::table('v_publicaciones')->select('tx_titulo', 'tx_isbn', 'nu_anno','tx_paginas','tx_edicion','tx_obra',
            'tx_resumen','tx_descriptores','tx_imagen','tx_subtitulo','tx_genero','tx_asunto','fh_fechapublicacion', 'tx_pais','tx_idioma',
            'nu_numPaginas','tx_categoria','autores','editores')
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
}
