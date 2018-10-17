<?php

/*BY: Encinas Ramos Jose angel
    Año: 2018,
    Materia: Desarrollo Aplicaciones WEB,
    Maestro: Noe Cazares,
    Descripcion:
*/

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PermisoNegado extends Model{
    protected $table = 'permisos_negados';

    public function permiso(){
        return $this->belongsTo('App\Models\Permiso');
    }

    public function rol(){
        return $this->belongsTo('App\Models\Rol');
    }
}
