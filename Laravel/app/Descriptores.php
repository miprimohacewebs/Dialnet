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
        foreach ($descriptores as $descriptor) {
            $descriptoresVuelta[]=['tx_descriptor'=>$descriptor];
        }
        //dd(DB::table('descriptores')->select('tx_descriptor')->get(), $descriptoresVuelta);
        return $descriptoresVuelta;

    }

    public static function obtenerDescriptoresDatatable($valoresAnio, $valoresAutores, $valoresCategorias, $valoresDescriptores, $busqueda)
    {
        $reemplazo1='';
        $reemplazo2='where p.tx_titulo like \'%'.$busqueda.'%\'';
        $query = 'SELECT count(dgd.desc_x_iddescriptor) numPublicaciones, dgd.desc_x_iddescriptor id, d.tx_descriptor nombre FROM descriptores_grupoDescriptor dgd LEFT JOIN descriptores d ON dgd.desc_x_iddescriptor = d.x_iddescriptor where dgd.x_idGrupoDescriptor in (select p.dgd_idGrupoDescriptor from publicaciones p LEFT JOIN autor_grupoautor a ON p.aga_x_idgrupoautor = a.ga_x_idgrupoautor LEFT JOIN autores a2 ON a.aut_x_idautor = a2.idAutor LEFT JOIN categoria_grupoCategoria C2 ON p.gcat_x_idgrupocategoria = C2.gt_x_idGrupoCategoria LEFT JOIN categorias c ON C2.cat_x_idCategoria = c.x_idcategoria &insert2) &insert GROUP BY dgd.desc_x_iddescriptor ORDER BY d.tx_descriptor';
        if ($valoresAnio!==null){
            $reemplazo2 = $reemplazo2.' and p.nu_anno in ('.$valoresAnio.')';
        }

        if ($valoresAutores!==null){
            if ($reemplazo2===''){
                $reemplazo2 = 'where a.aut_x_idautor in ('.$valoresAutores.')';
            }else{
                $reemplazo2 = $reemplazo2.' and a.aut_x_idautor in ('.$valoresAutores.')';
            }
        }

        if ($valoresCategorias!==null){
            if ($reemplazo2===''){
                $reemplazo2 = 'where C2.cat_x_idCategoria in ('.$valoresCategorias.')';
            }else{
                $reemplazo2 = $reemplazo2.' and C2.cat_x_idCategoria in ('.$valoresCategorias.')';
            }
        }

        if ($valoresDescriptores!==null){
            $reemplazo1 = ' and dgd.desc_x_iddescriptor in ('.$valoresDescriptores.')';
        }

        $query = str_replace('&insert2', $reemplazo2, $query);
        $query = str_replace('&insert', $reemplazo1, $query);

        return collect(DB::select (DB::raw($query)));
    }
}
