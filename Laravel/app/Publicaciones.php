<?php

namespace App; // change to this namespace
use Illuminate\Database\Eloquent\Model;

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
    protected $table = 'publicaciones';
    
    /**
     * @var array
     */
    protected $fillable = ['aga_x_idgrupoautor', 'cat_x_idcategoria', 'ge_x_idgrupoeditor', 'tx_titulo', 'tx_isbn', 'nu_anno', 'tx_paginas', 'tx_edicion', 'tx_obra', 'tx_resumen', 'tx_descriptores', 'tx_imagen', 'tx_subtitulo', 'tx_genero', 'tx_asunto', 'fh_fechapublicacion', 'tx_pais', 'tx_idioma', 'nu_numPaginas'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function autorGrupoautor()
    {
        return $this->belongsTo('App\autorGrupoautor', 'aga_x_idgrupoautor', 'ga_x_idgrupoautor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoria()
    {
        return $this->belongsTo('App\categorias', 'cat_x_idcategoria', 'x_idcategoria');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function editorGrupoeditor()
    {
        return $this->belongsTo('App\editorGrupoeditor', 'ge_x_idgrupoeditor', 'ge_x_idgrupoeditor');
    }
}
