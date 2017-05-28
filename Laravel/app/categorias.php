<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
