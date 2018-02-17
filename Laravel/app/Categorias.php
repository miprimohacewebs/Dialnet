<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


/**
 * @property integer $x_idcategoria
 * @property string $tx_categoria
 * @property Publicacione[] $publicaciones
 */
class categorias extends Model
{
    /** Tabla asociada con el modelo. */
    protected $table = 'categorias';

    /** Primary key de la tabla. */
    protected $primaryKey = 'x_idcategoria';

    /**
     * Método para conseguir el número total de categorias
     *
     * @return número de categorias
     */
    public static function obtenerNumeroCategorias()
    {
        return DB::table('categorias')->count();
    }

    /**
     * Guarda categoria en BD
     * @param $categoria
     * @return mixed
     */
    public static function guardarCategoria($categoria)
    {
        DB::table('categorias')->insertGetId(
            ['tx_categoria' => $categoria['categoria']]
        );

        return DB::getPdo()->lastInsertId();
    }

    /**
     * Actualiza la categoría de BD
     * @param $categoria
     */
    public static function actualizarCategoria($categoria)
    {

        DB::table('categorias')->where('x_idcategoria', $categoria['idCategoria'])
            ->update(
                ['tx_categoria' => $categoria['categoria']]
            );
    }

    public static function obtenerListaCategoriasSeleccionadas($categoria)
    {
        if ($categoria != null) {
            return DB::table('categorias')->select('x_idcategoria', 'tx_categoria')->whereIn('x_idcategoria', $categoria)->orderBy('tx_categoria')->get();
        }
        return null;
    }

    public static function obtenerCategoriasDatatable()
    {
        return collect(DB::table('publicaciones AS p')
            ->leftJoin('descriptores_grupoDescriptor AS dgd', 'p.dgd_idGrupoDescriptor', '=', 'dgd.x_idGrupoDescriptor')
            ->leftJoin('descriptores AS d', 'dgd.desc_x_iddescriptor', '=', 'd.x_iddescriptor')
            ->leftJoin('autor_grupoautor AS a', 'p.aga_x_idgrupoautor', '=', 'a.ga_x_idgrupoautor')
            ->leftJoin('autores AS a2', 'a.aut_x_idautor', '=', 'a2.idAutor')
            ->rightJoin('categoria_grupoCategoria AS C2', 'p.gcat_x_idgrupocategoria', '=', 'C2.gt_x_idGrupoCategoria')
            ->leftJoin('categorias AS c', 'C2.cat_x_idCategoria', '=', 'c.x_idcategoria')
            ->select(DB::raw('count(C2.cat_x_idCategoria) numPublicaciones, c.tx_categoria nombre, c.x_idcategoria id'))
            ->groupBy('C2.cat_x_idCategoria')
            ->orderBy('nombre')->get());
    }
}
