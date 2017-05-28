<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $x_idtipoautor
 * @property string $tx_tipoautor
 * @property Autore[] $autores
 */
class tipoAutor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipoautor';

    /**
     * @var array
     */
    protected $fillable = ['tx_tipoautor'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function autores()
    {
        return $this->hasMany('App\autores', 'ta_x_idtipoautor', 'x_idtipoautor');
    }
}
