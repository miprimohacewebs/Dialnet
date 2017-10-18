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
    public static function obtenerNumeroCategorias(){
        return DB::table('categorias')->count();
    }

    /**
     * Guarda categoria en BD
     * @param $categoria
     * @return mixed
     */
    public static function guardarCategoria($categoria){
        DB::table('categorias')->insertGetId(
            ['tx_categoria'=>$categoria['categoria']]
        );

        return DB::getPdo()->lastInsertId();
    }
}
