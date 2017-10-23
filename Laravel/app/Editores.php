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
class Editores extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'editor';

    /** Primary key de la tabla. */
    protected $primaryKey = 'x_ideditor';

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

    /**
     * Método para conseguir el número total de editores
     *
     * @return número de editores
     */
    public static function obtenerNumeroEditores(){
        return DB::table('editor')->count();
    }

    /**
     * Guarda editores en BD
     * @param $editor
     * @return mixed
     */
    public static function guardarEditor($editor){
        DB::table('editor')->insertGetId(
            ['tx_editor'=>$editor['editor'],'te_x_idTipoEditor'=>1]
        );

        return DB::getPdo()->lastInsertId();
    }

    /**
     * Actualiza el editor de BD
     * @param $editor
     */
    public static function actualizarEditor($editor){

        DB::table('editor')->where('x_ideditor', $editor['idEditor'])
            ->update(
                ['tx_editor'=>$editor['editor']]
            );
    }
}
