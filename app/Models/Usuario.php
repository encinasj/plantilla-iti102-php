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

class Usuario extends Model{

    //TODO: Utilizar softdelete de Eloquent.

    use SoftDeletes;

    protected $table = 'usuarios';

    public function rol(){
        return $this->belongsTo('App\Models\Rol');
    }
}
