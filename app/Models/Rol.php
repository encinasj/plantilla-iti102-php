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

class Rol extends Model {

    use SoftDeletes;

    protected $table = 'roles';

    public function usuario(){
        return $this->hasMany('App\Models\Usuario');
    }

    public function permiso_negado(){
        return $this->hasMany('App\Models\PermisoNegado');
    }
}
