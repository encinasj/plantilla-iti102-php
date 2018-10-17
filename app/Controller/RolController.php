<?php
/*BY: Encinas Ramos Jose angel
    Año: 28/Sep/2018,
    Materia: Desarrollo de Aplicaciones Web,
    Maestro: CAZAREZ CAMARGO NOE,
    Descripcion: Modulo de roles para dar de alta los roles.
*/

namespace App\Controller;


use App\Models\Rol;
use App\Repositories\RolRepositories;
use App\Validations\RolValidations;
use Core\Controller;
use Core\ServicesContainer;
use App\Helpers\ResponseHelper;

class RolController extends Controller {

    private $config;

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion constructura con el constructor de la clase que hereda que es Controller.
       Fecha: 28/Sep/2018
    */
    public function __construct(){
        parent::__construct();
        $this->config = ServicesContainer::getConfig();
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Vista por default del modulo rol.
       Fecha: 28/Sep/2018
    */
    public function getindex(){
        $obj = new RolRepositories();
        $data = ['title' => $this->config['company-name'], 'roles' => $obj->listar()];
        return $this->render('mantenimiento/roles/index.twig', $data);
    }


    /* Autor: Encinas Ramos Jose angel
       Descripcion: Mostrar la vista en que se encuentra el formulario para dar de alta un nuevo rol en el sistema.
       Fecha: 28/Sep/2018
    */
    public function getagregarr(){
        $data = ['title' => $this->config['company-name']];
        return $this->render('mantenimiento/roles/nuevo.twig', $data);
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para el registro de un nuevo rol en el sistema.
       Fecha: 28/Sep/2018
    */
    public function postguardarr(){
        RolValidations::validar($_POST);
        //echo "lol";
        $model = new Rol();
        $model->nombre = $_POST['nombre'];
        $rolRepo = new RolRepositories();
        $rh = $rolRepo->guardar($model);
        if($rh->response){
            $rh->href = 'mantenimiento/roles/';
        }
        print_r(json_encode($rh));
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para redirigir a la pagina de eliminacion de un rol.
       Fecha: 11/Oct/2018
    */
    public function geteliminarr($id = 0){

        if($id <= 0)
            UrlHelper::redirect('mantenimiento/roles');
        $rol = new RolRepositories();
        $model = $rol->obtener($id);
        return $this->render('mantenimiento/roles/eliminar.twig', [
            'title' => 'Eliminando...',
            'rol' => $model
        ]);
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion que utiliza el modelo para hacer un soft delete de un registro de la base de datos de la tabla roles.
       Fecha: 11/Oct/2018
    */

    public function posteliminarr(){
        $objRep = new RolRepositories();
        $model = $objRep->obtener($_POST['id']);
        //$model->activo = (!$model->activo)? 1 : 0;
        $model->delete();
        $rh = new ResponseHelper();
        $rh->setResponse(true,'Se elimino el rol correctamente');

        //$rh = $objRep->guardar($model);
        if($rh->response){
            $rh->href = 'mantenimiento/roles/';
        }
        print_r(json_encode($rh));
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para obtener la vista con el formulario lleno con los datos de la base de datos de la tabla roles.
       Fecha: 11/Oct/2018
    */
    public function getactualizarr($id = 0){

        if($id <= 0)
            UrlHelper::redirect('mantenimiento/roles');
        $rol = new RolRepositories();
        $model = $rol->obtener($id);
        return $this->render('mantenimiento/roles/actualizar.twig', [
            'title' => 'Actualizando...',
            'model' => $model
        ]);
    }


    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion donde llegan los datos del formulario para modificarlos en la base de datos.
       Fecha: 11/Oct/2018
    */
    public function postactualizarr(){
        RolValidations::validar($_POST);
        $objRepo = new RolRepositories();
        $model = $objRepo->obtener($_POST['id']);
        if(isset($_POST['nombre'])) $model->nombre = $_POST['nombre'];


        $rh = $objRepo->guardar($model);
        if($rh->response){  //Validar si la operacion se realizo correctamente
            $rh->href = 'mantenimiento/roles';
        }
        print_r(json_encode($rh));
    }

}
