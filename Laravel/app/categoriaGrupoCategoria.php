<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

/**
 * @property integer gt_x_idGrupoCategoria
 * @property integer $cat_x_idCategoria
 * @property Categorias $categorias
 * @property Publicaciones[] $publicaciones
 */
class categoriaGrupoCategoria extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'categoria_grupoCategoria';

    /** Primary key de la tabla. */
    protected $primaryKey = 'gt_x_idGrupoCategoria';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicaciones()
    {
        return $this->hasMany('App\publicaciones', 'gcat_x_idgrupocategoria', 'gt_x_idGrupoCategoria');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categorias()
    {
        return $this->belongsTo('App\categorias', 'cat_x_idCategoria', 'x_idcategoria');
    }

    public static function agruparCategorias($categoriasGuardar){
        $id=null;
        if ($categoriasGuardar!=null) {
            $idCategoriaGrupoCategoria = DB::table('categoria_grupoCategoria')->select('gt_x_idGrupoCategoria')->max('gt_x_idGrupoCategoria');
            if ($idCategoriaGrupoCategoria) {
                $id = $idCategoriaGrupoCategoria+1;

                foreach ($categoriasGuardar as $categoria) {
                    DB::table('autor_grupoautor')->insertGetId(
                        [
                            'gt_x_idGrupoCategoria' => $id,
                            'cat_x_idCategoria' => $categoria
                        ]
                    );
                }
            }
        }

        return $id;
    }

    public static function obtenerCategoriasPublicacion($idGrupoCategoria){
        return DB::table('v_categorias')->select('x_categoria', 'tx_categoria')->where('idGrupo', '=', $idGrupoCategoria)->orderBy('tx_categoria')->get();
    }
}
