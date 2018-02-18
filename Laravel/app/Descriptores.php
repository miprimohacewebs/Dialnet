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

    public static function obtenerDescriptoresDatatable($valoresAnio, $valoresAutores, $valoresCategorias, $valoresDescriptores)
    {
        $query = DB::table('publicaciones AS p')
            ->rightJoin('descriptores_grupoDescriptor AS dgd', 'p.dgd_idGrupoDescriptor', '=', 'dgd.x_idGrupoDescriptor')
            ->leftJoin('descriptores AS d', 'dgd.desc_x_iddescriptor', '=', 'd.x_iddescriptor')
            ->leftJoin('autor_grupoautor AS a', 'p.aga_x_idgrupoautor', '=', 'a.ga_x_idgrupoautor')
            ->leftJoin('autores AS a2', 'a.aut_x_idautor', '=', 'a2.idAutor')
            ->leftJoin('categoria_grupoCategoria AS C2', 'p.gcat_x_idgrupocategoria', '=', 'C2.gt_x_idGrupoCategoria')
            ->leftJoin('categorias AS c', 'C2.cat_x_idCategoria', '=', 'c.x_idcategoria')
            ->select(DB::raw('dgd.desc_x_iddescriptor numPublicaciones, d.tx_descriptor nombre, d.x_iddescriptor id'))
            ->groupBy('dgd.desc_x_iddescriptor')
            ->orderBy('nombre');

        if ($valoresAnio!=null){
            $query->whereIn('p.nu_anno', $valoresAnio);
        }

        if ($valoresAutores!=null){
            $query->whereIn('a.aut_x_idautor', $valoresAutores);
        }

        if ($valoresCategorias!=null){
            $query->whereIn('C2.cat_x_idCategoria', $valoresCategorias);
        }

        if ($valoresDescriptores!=null){
            $query->whereIn('dgd.desc_x_iddescriptor', $valoresDescriptores);
        }

        return collect($query->get());
    }
}
