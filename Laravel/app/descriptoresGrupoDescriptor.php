<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

/**
 * @property integer x_idGrupoDescriptor
 * @property integer $desc_x_iddescriptor
 * @property Descriptores $descriptores
 * @property Publicaciones[] $publicaciones
 */
class descriptoresGrupoDescriptor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cdescriptores_grupoDescriptor';

    /** Primary key de la tabla. */
    protected $primaryKey = 'x_idGrupoDescriptor';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicaciones()
    {
        return $this->hasMany('App\publicaciones', 'dgd_idGrupoDescriptor', 'x_idGrupoDescriptor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function descriptores()
    {
        return $this->belongsTo('App\descriptores', 'desc_x_iddescriptor', 'x_iddescriptor');
    }

    public static function agruparDescriptores($descriptoresGuardar){
        $id=null;
        if ($descriptoresGuardar!=null) {
            $idDescriptorGrupoDescriptor = DB::table('descriptores_grupoDescriptor')->select('x_idGrupoDescriptor')->max('x_idGrupoDescriptor');
            if ($idDescriptorGrupoDescriptor) {
                $id = $idDescriptorGrupoDescriptor+1;

                foreach ($descriptoresGuardar as $descriptor) {
                    DB::table('descriptores_grupoDescriptor')->insertGetId(
                        [
                            'x_idGrupoDescriptor' => $id,
                            'desc_x_iddescriptor' => $descriptor
                        ]
                    );
                }
            }
        }

        return $id;
    }

    public static function obtenerDescriptoresPublicacion($idGrupoDescriptor){
        return DB::table('v_descriptores')->select('x_iddescriptor', 'tx_descriptor')->where('idGrupo', '=', $idGrupoDescriptor)->orderBy('tx_descriptor')->get();
    }
}
