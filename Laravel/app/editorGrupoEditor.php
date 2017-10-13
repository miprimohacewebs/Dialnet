<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

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

    public static function AgruparEditores($editoresGuardar){
        $id=null;
        if ($editoresGuardar!=null) {
            $idEditorGrupoEditor = DB::table('editor_grupoeditor')->select('ge_x_idgrupoeditor')->max('ge_x_idgrupoeditor');
            if ($idEditorGrupoEditor) {
                $id = $idEditorGrupoEditor+1;

                foreach ($editoresGuardar as $editor) {
                    DB::table('editor_grupoeditor')->insertGetId(
                        [
                            'ge_x_idgrupoeditor' => $id,
                            'ed_x_ideditor' => $editor
                        ]
                    );
                }
            }
        }

        return $id;
    }
}
