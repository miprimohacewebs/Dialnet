<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $x_idusuario
 * @property integer $p_x_idperfil
 * @property string $tx_nombreusuario
 * @property string $tx_password
 * @property string $tx_email
 * @property Perfil $perfil
 */
class usuario extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'usuario';

    /**
     * @var array
     */
    protected $fillable = ['p_x_idperfil', 'tx_nombreusuario', 'tx_password', 'tx_email'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function perfil()
    {
        return $this->belongsTo('App\perfil', 'p_x_idperfil', 'x_idperfil');
    }
}
