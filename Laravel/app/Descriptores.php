<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


/**
 * @property integer $x_iddescriptor
 * @property string $tx_descriptor
 * @property DescriptoresGrupoDescriptor[] $descriptoresGrupoDescriptor
 */
class descriptores extends Model
{
    /** Tabla asociada con el modelo. */
    protected $table = 'descriptores';

    /** Primary key de la tabla. */
    protected $primaryKey = 'x_iddescriptor';

    /**
     * Guarda categoria en BD
     * @param $categoria
     * @return mixed
     */
    public static function guardarDescriptor($descriptor){
        DB::table('descriptores')->insertGetId(
            ['tx_descriptor'=>$descriptor]
        );

        return DB::getPdo()->lastInsertId();
    }

    /**
     * Actualiza la categoría de BD
     * @param $categoria
     */
    public static function actualizarDescriptor($descriptor){

        DB::table('descriptores')->where('x_iddescriptor', $descriptor['idDescriptor'])
            ->update(
                ['tx_descriptor'=>$descriptor['descriptor']]
            );
    }

    public static function obtenerDescriptoresPorNombre($descriptor){
        if ($descriptor!=null) {
            return DB::table('descriptores')->select('tx_descriptor')->whereRaw("LOWER(tx_descriptor) like '$descriptor%'")->orderBy('tx_descriptor')->pluck('tx_descriptor');
        }
        return null;
    }

    public static function obtenerCrearDescriptorPorNombre($descriptor){
        if ($descriptor!=null) {
            $descriptorObtenido = DB::table('descriptores')->select('x_iddescriptor')->where('tx_descriptor', 'like', $descriptor)->pluck('x_iddescriptor');
            if ($descriptorObtenido == null) {
                $descriptorObtenido = self::guardarDescriptor($descriptor);
            } else {
                $descriptorObtenido = $descriptorObtenido[0];
            }
        }
        return $descriptorObtenido;
    }

    public static function obtenerDescriptoresSeleccionadosModificacion ($descriptores){
        $descriptoresVuelta = Array();
        foreach ($descriptores as $descriptor) {
            $descriptoresVuelta[]=['tx_descriptor'=>$descriptor->tx_descriptor];
        }
        //dd(DB::table('descriptores')->select('tx_descriptor')->get(), $descriptoresVuelta);
        return $descriptoresVuelta;
    }

    public static function obtenerDescriptoresSeleccionados ($descriptores){

        $descriptoresVuelta = Array();
        if ($descriptores!==null){
			foreach ($descriptores as $descriptor) {
				$descriptoresVuelta[]=['tx_descriptor'=>$descriptor];
			}
		}
        //dd(DB::table('descriptores')->select('tx_descriptor')->get(), $descriptoresVuelta);
        return $descriptoresVuelta;

    }

    public static function obtenerDescriptoresDatatable($valoresAnio, $valoresAutores, $valoresCategorias, $valoresDescriptores, $busqueda, $tipoBusqueda)
    {
        if ($tipoBusqueda==='0'){
            $reemplazo='where p.tx_titulo like \'%'.$busqueda.'%\'';
        }elseif ($tipoBusqueda==='1'){
            $reemplazo='where concat(concat(a2.tx_autor,\' \'),a2.tx_autorapellidos) like \'%'.$busqueda.'%\'';
        }
        $query = 'SELECT count(dgd.desc_x_iddescriptor) numPublicaciones, dgd.desc_x_iddescriptor id, d.tx_descriptor nombre FROM descriptores_grupoDescriptor dgd LEFT JOIN descriptores d ON dgd.desc_x_iddescriptor = d.x_iddescriptor where dgd.x_idGrupoDescriptor in (select p.dgd_idGrupoDescriptor from publicaciones p LEFT JOIN autor_grupoautor a ON p.aga_x_idgrupoautor = a.ga_x_idgrupoautor LEFT JOIN autores a2 ON a.aut_x_idautor = a2.idAutor LEFT JOIN categoria_grupoCategoria C2 ON p.gcat_x_idgrupocategoria = C2.gt_x_idGrupoCategoria LEFT JOIN categorias c ON C2.cat_x_idCategoria = c.x_idcategoria LEFT JOIN descriptores_grupoDescriptor dgd ON p.dgd_idGrupoDescriptor = dgd.x_idGrupoDescriptor LEFT JOIN descriptores d ON dgd.desc_x_iddescriptor = d.x_iddescriptor &insert) GROUP BY dgd.desc_x_iddescriptor ORDER BY d.tx_descriptor';
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
