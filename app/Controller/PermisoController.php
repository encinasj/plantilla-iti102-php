<?php
/*BY: Encinas Ramos Jose angel
    Año: 28/Sep/2018,
    Materia: Desarrollo de Aplicaciones Web,
    Maestro: CAZAREZ CAMARGO NOE,
    Descripcion: Modulo de roles para dar de alta los roles.
*/

namespace App\Controller;


use App\Models\Permiso;
use App\Repositories\PermisoRepositories;
use App\Validations\PermisoValidations;
use Core\Controller;
use Core\ServicesContainer;
use App\Helpers\ResponseHelper;

class PermisoController extends Controller {

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
        $obj = new PermisoRepositories();
        $data = ['title' => $this->config['company-name'], 'permisos' => $obj->listar()];
        return $this->render('mantenimiento/permisos/index.twig', $data);
    }


    /* Autor: Encinas Ramos Jose angel
       Descripcion: Mostrar la vista en que se encuentra el formulario para dar de alta un nuevo rol en el sistema.
       Fecha: 28/Sep/2018
    */
    public function getagregarp(){
        $data = ['title' => $this->config['company-name']];
        return $this->render('mantenimiento/permisos/nuevo.twig', $data);
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para el registro de un nuevo rol en el sistema.
       Fecha: 28/Sep/2018
    */
    public function postguardarp(){
        PermisoValidations::validar($_POST);
        //echo "lol";
        $model = new Permiso();
        $model->nombre = $_POST['nombre'];
        $permisoRepo = new PermisoRepositories();
        $rh = $permisoRepo->guardar($model);
        if($rh->response){
            $rh->href = 'mantenimiento/permisos/';
        }
        print_r(json_encode($rh));
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para redirigir a la pagina de eliminacion de un rol.
       Fecha: 11/Oct/2018
    */
    public function geteliminarp($id = 0){

        if($id <= 0)
            UrlHelper::redirect('mantenimiento/permisos');
        $permiso = new PermisoRepositories();
        $model = $permiso->obtener($id);
        return $this->render('mantenimiento/permisos/eliminar.twig', [
            'title' => 'Eliminando...',
            'permiso' => $model
        ]);
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion que utiliza el modelo para hacer un soft delete de un registro de la base de datos de la tabla roles.
       Fecha: 11/Oct/2018
    */

    public function posteliminarp(){
        $objRep = new PermisoRepositories();
        $model = $objRep->obtener($_POST['id']);
        //$model->activo = (!$model->activo)? 1 : 0;
        $model->delete();
        $rh = new ResponseHelper();
        $rh->setResponse(true,'Se elimino el permiso correctamente');

        //$rh = $objRep->guardar($model);
        if($rh->response){
            $rh->href = 'mantenimiento/permisos/';
        }
        print_r(json_encode($rh));
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para obtener la vista con el formulario lleno con los datos de la base de datos de la tabla roles.
       Fecha: 11/Oct/2018
    */
    public function getactualizarp($id = 0){

        if($id <= 0)
            UrlHelper::redirect('mantenimiento/permisos');
        $permiso = new PermisoRepositories();
        $model = $permiso->obtener($id);
        return $this->render('mantenimiento/permisos/actualizar.twig', [
            'title' => 'Actualizando...',
            'model' => $model
        ]);
    }


    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion donde llegan los datos del formulario para modificarlos en la base de datos.
       Fecha: 11/Oct/2018
    */
    public function postactualizarp(){
        PermisoValidations::validar($_POST);
        $objRepo = new PermisoRepositories();
        $model = $objRepo->obtener($_POST['id']);
        if(isset($_POST['nombre'])) $model->nombre = $_POST['nombre'];


        $rh = $objRepo->guardar($model);
        if($rh->response){  //Validar si la operacion se realizo correctamente
            $rh->href = 'mantenimiento/permisos';
        }
        print_r(json_encode($rh));
    }

}
