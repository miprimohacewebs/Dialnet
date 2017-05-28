<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $x_idtipoeditor
 * @property string $tx_tipoeditor
 * @property Editor $editor
 */
class tipoEditor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tipoeditor';

    /**
     * @var array
     */
    protected $fillable = ['tx_tipoeditor'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function editor()
    {
        return $this->hasOne('App\editor', 'te_x_idTipoEditor', 'x_idtipoeditor');
    }
}
