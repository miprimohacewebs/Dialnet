<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ta_x_idtipoautor
 * @property integer $idAutor
 * @property string $tx_autor
 * @property Tipoautor $tipoautor
 * @property AutorGrupoautor[] $autorGrupoautors
 */
class autores extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ta_x_idtipoautor', 'tx_autor'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoautor()
    {
        return $this->belongsTo('App\Tipoautor', 'ta_x_idtipoautor', 'x_idtipoautor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function autorGrupoautors()
    {
        return $this->hasMany('App\AutorGrupoAutor', 'aut_x_idautor', 'idAutor');
    }
}
