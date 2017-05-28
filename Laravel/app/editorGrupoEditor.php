<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $ge_x_idgrupoeditor
 * @property integer $ed_x_ideditor
 * @property Publicacione[] $publicaciones
 */
class editorGrupoEditor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'editor_grupoeditor';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicaciones()
    {
        return $this->hasMany('App\publicaciones', 'ge_x_idgrupoeditor', 'ge_x_idgrupoeditor');
    }
}
