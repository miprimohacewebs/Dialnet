<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'autores';

    /** Primary key de la tabla. */
    protected $primaryKey = 'idAutor';

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

    /**
     * Método para conseguir el número total de publicaciones
     *
     * @return número de autores
     */
    public static function obtenerNumeroAutores(){
        return DB::table('autores')->count();
    }

    public static function obtenerlistaAutoresSeleccionados($autores){
        if ($autores!=null) {
            return DB::table('autores')->select('idAutor','tx_autor')->whereIn('idAutor', $autores)->orderBy('tx_autor')->get();
        }
        return null;
    }

    /**
     * Guarda categoria en BD
     * @param $categoria
     * @return mixed
     */
    public static function guardarAutor($autor){
        DB::table('autores')->insertGetId(
            ['tx_autor'=>$autor['autor'],'ta_x_idtipoautor'=>1]
        );

        return DB::getPdo()->lastInsertId();
    }

    /**
     * Actualiza el autor de BD
     * @param $autor
     */
    public static function actualizarAutor($autor){

        DB::table('autores')->where('idAutor', $autor['idAutor'])
            ->update(
                ['tx_autor'=>$autor['autor']]
            );
    }
}
