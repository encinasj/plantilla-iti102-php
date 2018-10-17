<?php

/*BY: Encinas Ramos Jose angel
    Año: 2018,
    Materia: Desarrollo Aplicaciones WEB,
    Maestro: Noe Cazares,
    Descripcion:
*/

declare(strict_types=1);  //Opción para depurar.

namespace App\Repositories;


use App\Helpers\ResponseHelper;
use App\Models\Rol;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class RolRepositories{
    private $rol;

    public function __construct(){
        $this->rol = new Rol();
    }

    public function listar():Collection{   //Obtener el contenido de la tabla.
        $data = [];

        try{
            $data = $this->rol->get();
        }catch (\Exception $ex){
            Log::error(RolRepositories::class, $ex->getMessage());
        }
        return $data;
    }

    public function obtener($id):Rol{
        $model = new Rol();
        try{
            $model = $this->rol->where('id',$id)->get()->first();
        }catch (\Exception $ex){
            Log::error(RolRepositories::class, $ex->getMessage());
        }
        return $model;
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para guardar elrol en la base de datos.
       Fecha: 28/Sep/2018
    */
    public function guardar($model):ResponseHelper{
        $rh = new ResponseHelper();
        try{
            $this->rol = $model;
            $this->rol->exists = (isset($model->id))? true: false;
            $this->rol->save();
            $rh->setResponse(true, 'Nuevo resgistro de rol realizado correctamente...');
        }catch(\Exception $ex){
            Log::error(RolRepositories::class, $ex->getMessage());
        }

        return $rh;
    }
}
