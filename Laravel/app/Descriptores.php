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
}
