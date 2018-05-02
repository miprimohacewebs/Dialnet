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
            return DB::table('autores')->select('idAutor','tx_autor', 'tx_autorapellidos')->whereIn('idAutor', $autores)->orderBy('tx_autorapellidos')->get();
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

    public static function obtenerAutoresDatatable($valoresAnio, $valoresAutores, $valoresCategorias, $valoresDescriptores, $busqueda, $tipoBusqueda)
    {
        if ($tipoBusqueda==='0'){
            $reemplazo='where p.tx_titulo like \'%'.$busqueda.'%\'';
        }elseif ($tipoBusqueda==='1'){
            $reemplazo='where concat(concat(a2.tx_autor,\' \'),a2.tx_autorapellidos) like \'%'.$busqueda.'%\'';
        }elseif ($tipoBusqueda==='2'){
            $reemplazo='where d.tx_descriptor like \'%'.$busqueda.'%\'';
        }elseif ($tipoBusqueda==='3'){
            $reemplazo='where p.nu_anno like \'%'.$busqueda.'%\'';
        }
        $query = 'SELECT count(a.aut_x_idautor) numPublicaciones, concat(concat(a2.tx_autorApellidos,\', \'), a2.tx_autor) nombre, a.aut_x_idautor id FROM autor_grupoautor a LEFT JOIN autores a2 ON a.aut_x_idautor = a2.idAutor WHERE a.ga_x_idgrupoautor IN (SELECT p.aga_x_idgrupoautor FROM publicaciones p LEFT JOIN categoria_grupoCategoria C2 on p.gcat_x_idgrupocategoria = C2.gt_x_idGrupoCategoria LEFT JOIN categorias c ON C2.cat_x_idCategoria = c.x_idcategoria LEFT JOIN descriptores_grupoDescriptor dgd ON p.dgd_idGrupoDescriptor = dgd.x_idGrupoDescriptor LEFT JOIN descriptores d ON dgd.desc_x_iddescriptor = d.x_iddescriptor LEFT JOIN autor_grupoautor a ON p.aga_x_idgrupoautor = a.ga_x_idgrupoautor LEFT JOIN autores a2 ON a.aut_x_idautor = a2.idAutor &insert) GROUP BY a.aut_x_idautor ORDER BY concat(concat(a2.tx_autorApellidos,\', \'), a2.tx_autor)';
        
		if ($valoresAnio!==null){
            $anios = explode(',',$valoresAnio);
			$reemplazo = $reemplazo.' and (';
			foreach ($anios as $anio){
				$reemplazo = $reemplazo.'p.nu_anno = '.$anio;
				$reemplazo = $reemplazo.' or ';
			}
			$reemplazo = substr($reemplazo, 0, -4).')'; 
        }

        if ($valoresAutores!==null){
            $autores = explode(',',$valoresAutores);
			$reemplazo = $reemplazo.' and (';
			foreach ($autores as $autor){
				$reemplazo = $reemplazo.'a.aut_x_idautor = '.$autor;
				$reemplazo = $reemplazo.' or ';
			}
			$reemplazo = substr($reemplazo, 0, -4).')'; 
        }

        if ($valoresCategorias!==null){
            $categorias = explode(',',$valoresCategorias);
			$reemplazo = $reemplazo.' and (';
			foreach ($categorias as $categoria){
				$reemplazo = $reemplazo.'C2.cat_x_idCategoria = '.$categoria;
				$reemplazo = $reemplazo.' or ';
			}
			$reemplazo = substr($reemplazo, 0, -4).')'; 
        }

        if ($valoresDescriptores!==null){
            $descriptores = explode(',',$valoresDescriptores);
			$reemplazo = $reemplazo.' and (';
			foreach ($descriptores as $descriptor){
				$reemplazo = $reemplazo.'dgd.desc_x_iddescriptor = '.$descriptor;
				$reemplazo = $reemplazo.' or ';
			}
			$reemplazo = substr($reemplazo, 0, -4).')'; 
			
        }
        $query = str_replace('&insert', $reemplazo, $query);

        return collect(DB::select (DB::raw($query)));
    }

    public static function obtenerAutoresPorNombre($autor){
        if ($autor!=null) {
            return DB::table('autores')->selectRaw('concat(concat(LOWER(tx_autorapellidos),\', \'),LOWER(tx_autor)) as tx_autor')->whereRaw("concat(concat(LOWER(tx_autorapellidos),', '),LOWER(tx_autor)) like '$autor%'")->orderBy('tx_autorapellidos')->pluck('tx_autor');
        }
        return null;
    }
}
