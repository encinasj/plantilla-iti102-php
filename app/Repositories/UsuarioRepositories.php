<?php
/*BY: Encinas Ramos Jose Angel
    Año: 26/Sep/2018,
    Materia: Desarrollo de Aplicaciones Web,
    Maestro: CAZAREZ CAMARGO NOE,
    Descripcion: Codigo para el manejo de los datos en la tabla de usuarios (save, update, delete, search).
*/
namespace App\Repositories;

use App\Helpers\ResponseHelper;
use App\Models\Usuario;
use Core\Log;
use Illuminate\Database\Eloquent\Collection;

class UsuarioRepositories{
    private $usuario;
    public function __construct(){
        $this->usuario = new Usuario();
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funccion para listar los usuarios que estan en la base de datos.
       Fecha: 26/Sep/2018
    */
    public function listar():Collection{

        $datos = [];
        try{
            $datos = $this->usuario->get();
        }catch(\Exception $ex){
            print_r($ex);
            Log::error(UsuarioRepositories::class, $ex->getMessage());
        }
        return $datos;
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para obtener el objeto de un usuario.
       Fecha: 02/Oct/2018
    */
    public function obtener($id): ?Usuario{
        $dato = null;
        try{
            $dato = $this->usuario->find($id);
        }catch(\Exception $ex){
            Log::error(UsuarioRepositories::class, $ex->getMessage());
        }
        return $dato;
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para buscar un usuario por correo electronico.
       Fecha: 02/Oct/2018
    */
    public function buscarByEmail($email):ResponseHelper{
        $rh = new ResponseHelper();
        try{
            $tmp = $this->usuario->where('correo', $email)->first();
            if(is_object($tmp)){
                $rh->setResponse(true);
                $rh->result = $tmp;
            }else{
                $rh->setResponse(false, 'No existen registros que cumplan con la condicion ingresada.');
            }
        }catch(\Exception $ex){
            Log::error(UsuarioRepositories::class, $ex->getMessage());
        }

        return $rh;
    }


    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para guardar un nuevo usuario a la base de datos.
       Fecha: 26/Sep/2018
    */
    public function guardar($model):ResponseHelper{
        $rh = new ResponseHelper();

        try{
            $this->usuario = $model;
            $this->usuario->exists = (isset($model->id))? true : false;

            if(isset($model->id)){
                $this->usuario->exists = true;
            }

            if(isset($this->usuario->password)){
                $this->usuario->password = sha1($model->password);
            }
            $this->usuario->save();
            $rh->setResponse(true,
                'Registro guardado correctamente...');
        }catch(\Exception $ex){
            Log::error(UsuarioRepositories::class,
                $ex->getMessage() . 'Linea: ' . $ex->getLine());
        }

        return $rh;
    }


}
