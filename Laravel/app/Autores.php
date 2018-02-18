<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;


/**
 * @property integer $ta_x_idtipoautor
 * @property integer $idAutor
 * @property string $tx_autor
 * @property string $tx_autorApellidos
 * @property Tipoautor $tipoautor
 * @property AutorGrupoautor[] $autorGrupoautors
 */
class autores extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['ta_x_idtipoautor', 'tx_autor', 'tx_autorApellidos'];

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
     * Método para conseguir el número total de autores
     *
     * @return número de autores
     */
    public static function obtenerNumeroAutores(){
        return DB::table('autores')->count();
    }

    /**
     * Método para obtener los autores seleccionados
     * @param $autores
     * @return null
     */
    public static function obtenerlistaAutoresSeleccionados($autores){
        if ($autores!=null) {
            return DB::table('autores')->select('idAutor','tx_autor', 'tx_autorApellidos')->whereIn('idAutor', $autores)->orderBy('tx_autorApellidos')->get();
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
            ['tx_autor'=>$autor['autor'],'tx_autorApellidos'=>$autor['autorApellidos'],'ta_x_idtipoautor'=>1]
        );

        return DB::getPdo()->lastInsertId();
    }

    /**
     * Actualiza el autor de BD
     * @param $autor
     */
    public static function actualizarAutor($autor){
;
        DB::table('autores')->where('idAutor', $autor['idAutor'])
            ->update(
                ['tx_autor'=>$autor['autor'],
                'tx_autorApellidos'=>$autor['autorApellidos']]
            );
    }

    public static function obtenerAutoresDatatable($valoresAnio, $valoresAutores, $valoresCategorias, $valoresDescriptores)
    {
        $reemplazo1='';
        $reemplazo2='';
        $query = 'SELECT count(a.aut_x_idautor) numPublicaciones, concat(concat(a2.tx_autorApellidos,\', \'), a2.tx_autor) nombre, a.aut_x_idautor id FROM autor_grupoautor a LEFT JOIN autores a2 ON a.aut_x_idautor = a2.idAutor WHERE a.ga_x_idgrupoautor IN (SELECT p.aga_x_idgrupoautor FROM publicaciones p LEFT JOIN categoria_grupoCategoria C2 on p.gcat_x_idgrupocategoria = C2.gt_x_idGrupoCategoria LEFT JOIN categorias c ON C2.cat_x_idCategoria = c.x_idcategoria LEFT JOIN descriptores_grupoDescriptor dgd ON p.dgd_idGrupoDescriptor = dgd.x_idGrupoDescriptor LEFT JOIN descriptores d ON dgd.desc_x_iddescriptor = d.x_iddescriptor &insert2) &insert GROUP BY a.aut_x_idautor ORDER BY concat(concat(a2.tx_autorApellidos,\', \'), a2.tx_autor)';
        if ($valoresAnio!==null){
            $reemplazo2 = 'where p.nu_anno in ('.$valoresAnio.')';
        }

        if ($valoresAutores!==null){
            $reemplazo1 = ' and a.aut_x_idautor in ('.$valoresAutores.')';
        }

        if ($valoresCategorias!==null){
            if ($reemplazo2===''){
                $reemplazo2 = 'where C2.cat_x_idCategoria in ('.$valoresCategorias.')';
            }else{
                $reemplazo2 = $reemplazo2.' and C2.cat_x_idCategoria in ('.$valoresCategorias.')';
            }
        }

        if ($valoresDescriptores!==null){
            if ($reemplazo2===''){
                $reemplazo2 = 'where dgd.desc_x_iddescriptor in ('.$valoresDescriptores.')';
            }else {
                $reemplazo2 = $reemplazo2 . ' and dgd.desc_x_iddescriptor in (' . $valoresDescriptores . ')';
            }
        }

        $query = str_replace('&insert2', $reemplazo2, $query);
        $query = str_replace('&insert', $reemplazo1, $query);

        return collect(DB::select (DB::raw($query)));
    }
}
