<?php

/*BY: Encinas Ramos Jose angel
    Año: 2018,
    Materia: Desarrollo Aplicaciones WEB,
    Maestro: Noe Cazares,
    Descripcion: 
*/
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Permiso extends Model{

  use SoftDeletes;

    protected $table = 'permisos';

    public function negado(){
        return $this->hasMany('app\Models\PermisoNegado');
    }
}
