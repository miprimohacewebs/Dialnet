<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

/**
 * @property integer $aut_x_idautor
 * @property integer $ga_x_idgrupoautor
 * @property Autore $autore
 * @property Publicacione[] $publicaciones
 */
class autorGrupoAutor extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'autor_grupoautor';

    /**
     * @var array
     */
    protected $fillable = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function autore()
    {
        return $this->belongsTo('App\autores', 'aut_x_idautor', 'idAutor');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function publicaciones()
    {
        return $this->hasMany('App\publicaciones', 'aga_x_idgrupoautor', 'ga_x_idgrupoautor');
    }

    public static function agruparAutores($autoresGuardar){
        $id=null;
        if ($autoresGuardar!=null) {
            $idAutorGrupoAutor = DB::table('autor_grupoautor')->select('ga_x_idgrupoautor')->max('ga_x_idgrupoautor');
            if ($idAutorGrupoAutor) {
                $id = $idAutorGrupoAutor+1;

                foreach ($autoresGuardar as $autor) {
                    DB::table('autor_grupoautor')->insertGetId(
                        [
                            'ga_x_idgrupoautor' => $id,
                            'aut_x_idautor' => $autor
                        ]
                    );
                }
            }
        }

        return $id;
    }
}
