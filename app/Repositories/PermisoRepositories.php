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
use App\Models\Permiso;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class PermisoRepositories{
    private $permiso;

    public function __construct(){
        $this->permiso = new Permiso();
    }

    public function listar():Collection{   //Obtener el contenido de la tabla.
        $data = [];

        try{
            $data = $this->permiso->get();
        }catch (\Exception $ex){
            Log::error(RolRepositories::class, $ex->getMessage());
        }
        return $data;
    }

    public function obtener($id):Permiso{
        $model = new Permiso();
        try{
            $model = $this->permiso->where('id',$id)->get()->first();
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
            $this->permiso = $model;
            $this->permiso->exists = (isset($model->id))? true: false;
            $this->permiso->save();
            $rh->setResponse(true, 'Nuevo resgistro de permiso realizado correctamente...');
        }catch(\Exception $ex){
            Log::error(PermisoRepositories::class, $ex->getMessage());
        }

        return $rh;
    }
}
