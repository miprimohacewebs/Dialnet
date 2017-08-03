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
    /**
     * @var array
     */
    protected $fillable = ['tx_categoria'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicaciones()
    {
        return $this->hasMany('App\publicaciones', 'cat_x_idcategoria', 'x_idcategoria');
    }

    /**
     * Método para conseguir el número total de categorias
     *
     * @return número de categorias
     */
    public static function obtenerNumeroCategorias(){
        return DB::table('categorias')->count();
    }
}
