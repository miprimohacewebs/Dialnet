<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $x_idperfil
 * @property string $tx_perfil
 * @property string $tx_permisos
 * @property Usuario[] $usuarios
 */
class perfil extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'perfil';

    /**
     * @var array
     */
    protected $fillable = ['tx_perfil', 'tx_permisos'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarios()
    {
        return $this->hasMany('App\usuario', 'p_x_idperfil', 'x_idperfil');
    }
}
