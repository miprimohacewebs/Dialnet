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

    public static function obtenerCategoriasDatatable($valoresAnio, $valoresAutores, $valoresCategorias, $valoresDescriptores, $busqueda, $tipoBusqueda)
    {
        if ($tipoBusqueda==='0'){
            $reemplazo='where p.tx_titulo like \'%'.$busqueda.'%\'';
        }elseif ($tipoBusqueda==='1'){
            $reemplazo='where concat(concat(a2.tx_autor,\' \'),a2.tx_autorapellidos) like \'%'.$busqueda.'%\'';
        }
        $query = 'SELECT count(C2.cat_x_idCategoria) numPublicaciones, C2.cat_x_idCategoria id, c.tx_categoria nombre FROM categoria_grupoCategoria C2 LEFT JOIN categorias c ON C2.cat_x_idCategoria = c.x_idcategoria where C2.gt_x_idGrupoCategoria in (select p.gcat_x_idgrupocategoria from publicaciones p LEFT JOIN autor_grupoautor a ON p.aga_x_idgrupoautor = a.ga_x_idgrupoautor LEFT JOIN autores a2 ON a.aut_x_idautor = a2.idAutor LEFT JOIN descriptores_grupoDescriptor dgd on p.dgd_idGrupoDescriptor = dgd.x_idGrupoDescriptor LEFT JOIN descriptores d ON dgd.desc_x_iddescriptor = d.x_iddescriptor LEFT JOIN categoria_grupoCategoria C2 ON p.gcat_x_idgrupocategoria = C2.gt_x_idGrupoCategoria LEFT JOIN categorias c ON C2.cat_x_idCategoria = c.x_idcategoria &insert) GROUP BY C2.cat_x_idCategoria ORDER BY c.tx_categoria';
        if ($valoresAnio!==null){
            $anios = explode(',',$valoresAnio);
			$reemplazo = $reemplazo.' and (';
			foreach ($anios as $anio){
				$reemplazo = $reemplazo.'p.nu_anno = '.$anio;
				$reemplazo = $reemplazo.' or ';
			}
			$reemplazo = substr($reemplazo, 0, -4).')'; 
        }

        if ($valoresAutores!==null){
            $autores = explode(',',$valoresAutores);
			$reemplazo = $reemplazo.' and (';
			foreach ($autores as $autor){
				$reemplazo = $reemplazo.'a.aut_x_idautor = '.$autor;
				$reemplazo = $reemplazo.' or ';
			}
			$reemplazo = substr($reemplazo, 0, -4).')'; 
        }

        if ($valoresCategorias!==null){
            $categorias = explode(',',$valoresCategorias);
			$reemplazo = $reemplazo.' and (';
			foreach ($categorias as $categoria){
				$reemplazo = $reemplazo.'C2.cat_x_idCategoria = '.$categoria;
				$reemplazo = $reemplazo.' or ';
			}
			$reemplazo = substr($reemplazo, 0, -4).')'; 
        }

        if ($valoresDescriptores!==null){
            $descriptores = explode(',',$valoresDescriptores);
			$reemplazo = $reemplazo.' and (';
			foreach ($descriptores as $descriptor){
				$reemplazo = $reemplazo.'dgd.desc_x_iddescriptor = '.$descriptor;
				$reemplazo = $reemplazo.' or ';
			}
			$reemplazo = substr($reemplazo, 0, -4).')'; 
			
        }
        $query = str_replace('&insert', $reemplazo, $query);

        return collect(DB::select (DB::raw($query)));
    }
}
