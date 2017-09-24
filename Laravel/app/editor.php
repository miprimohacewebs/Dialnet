<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

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

    public static function obtenerListaEditoresSeleccionados($editores){
        if ($editores!=null) {
            return DB::table('editor')->select('x_ideditor','tx_editor')->whereIn('x_ideditor', $editores)->orderBy('tx_editor')->get();
        }
        return null;
    }
}
