<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $x_ideditor
 * @property string $tx_editor
 * @property integer $te_x_idTipoEditor
 * @property Tipoeditor $tipoeditor
 */
class editor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'editor';

    /**
     * @var array
     */
    protected $fillable = ['tx_editor', 'te_x_idTipoEditor'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipoeditor()
    {
        return $this->belongsTo('App\tipoEditor', 'te_x_idTipoEditor', 'x_idtipoeditor');
    }
}
