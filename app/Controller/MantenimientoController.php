<?php
/*BY: Encinas Ramos Jose angel
    Año: 2018,
    Materia: Desarrollo de Aplicaciones Web,
    Maestro: CAZAREZ CAMARGO NOE,
    Descripcion: Modulo de mantenimiento, alta de usuarios, catalogos, etc.
*/

declare(strict_types=1);

namespace App\Controller;


use App\Helpers\ResponseHelper;
use App\Helpers\UrlHelper;
use App\Models\Usuario;
use App\Repositories\RolRepositories;
use App\Repositories\UsuarioRepositories;
use Core\Controller;
use Core\ServicesContainer;
use App\Validations\UsuarioValidations;


class MantenimientoController extends Controller {

    private $config;
    //TODO: Declarar variable de repository de usuario y rol.


    //private $usuarioRepo;
    /* Autor: Encinas Ramos Jose angel
       Descripcion: Constructor
       Fecha: 25/Sep/2018
    */
    public function __construct(){
        parent::__construct();
        $this->config = ServicesContainer::getConfig();
        //$this->usuarioRepo = new UsuarioRepositories();
    }

    /* Autor: Encinas Ramos Jose angel
    Descripcion: Vista de default, principal del modulo.
    Fecha: 25/Sep/2018
    */
    public function getindex(){
        $obj = new UsuarioRepositories();

        return $this->render('mantenimiento/usuarios/index.twig', [
            'title' => $this->config['company_name'],
            'usuarios' => $obj->listar()]);
        }



        //region FUNCIONES PARA AGREGAR USUARIO
        /* Autor: Encinas Ramos Jose angel
        Descripcion: Mostrar la vista del formulario para el registro del usuario nuevo.
        Fecha: 25/Sep/2018
        */
        public function getagregaru(){

            $obj = new RolRepositories();

        return $this->render('mantenimiento/usuarios/nuevo.twig', [
            'title' => $this->config['company_name'],
            'roles' => $obj->listar()]);
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para el registro de usuarios al sistema.
       Fecha: 26/Sep/2018
    */
    public function postguardarusuario(){
        UsuarioValidations::validate($_POST);

        $model = new Usuario();
        $model->nombre = $_POST['nombre'];
        $model->apaterno = $_POST['apaterno'];
        $model->amaterno = $_POST['amaterno'];
        $model->correo = $_POST['correo'];
        $model->password = $_POST['password'];
        $model->rol_id = $_POST['rol_id'];

        $usuarioRepo = new UsuarioRepositories();
        $rh = $usuarioRepo->guardar($model);
        if($rh->response){  //Validar si la operacion se realizo correctamente
            $rh->href = 'mantenimiento/usuarios/';
        }
        print_r(json_encode($rh));
    }
    //endregion

    #region FUNCIONES PARA ACTUALIZAR
    /* Autor: Encinas Ramos Jose angel
       Descripcion: Vista para actualizar usuario.
       Fecha: 02/Oct/2018
    */
    public function getactualizaru($id = 0){
        if($id <= 0)
            UrlHelper::redirect('mantenimiento/usuarios');
        $usuario = new UsuarioRepositories();
        $model = $usuario->obtener($id);
        return $this->render('mantenimiento/usuarios/actualizar.twig', [
            'title' => 'Actualizando...',
            'model' => $model,
            'roles' => (new RolRepositories())->listar()
        ]);
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para aplicar la actualizacion de un usuario mediante su id.
       Fecha: 02/Oct/2018
    */
    public function postactualizaru(){
        UsuarioValidations::validate($_POST);
        $objRepo = new UsuarioRepositories();
        $model = $objRepo->obtener($_POST['id']);
        if(isset($_POST['nombre'])) $model->nombre = $_POST['nombre'];
        if(isset($_POST['apaterno'])) $model->apaterno = $_POST['apaterno'];
        if(isset($_POST['amaterno'])) $model->amaterno = $_POST['amaterno'];
        if(isset($_POST['rol_id'])) $model->rol_id = $_POST['rol_id'];
        $model->password = null;

        $rh = $objRepo->guardar($model);
        if($rh->response){  //Validar si la operacion se realizo correctamente
            $rh->href = 'mantenimiento/usuarios';
        }
        print_r(json_encode($rh));
    }
    #endregion

    #region FUNCIONES PARA ELIMINAR UN USUARIO

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para mostrar la vista de eliminar un usuario.
       Fecha: 02/Oct/2018
    */
    public function geteliminaru($id = 0){

        if($id <= 0)
            UrlHelper::redirect('mantenimiento/usuarios');
        $usuario = new UsuarioRepositories();
        $model = $usuario->obtener($id);
        return $this->render('mantenimiento/usuarios/eliminar.twig', [
            'title' => 'Eliminando...',
            'model' => $model,
            'roles' => (new RolRepositories())->listar()
        ]);
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para cambiar el valor de activo del usuario a false[0].
       Fecha: 02/Oct/2018
    */
    public function posteliminaru(){
        $objRep = new UsuarioRepositories();
        $model = $objRep->obtener($_POST['id']);
        //$model->activo = (!$model->activo)? 1 : 0;
        $model->delete();
        $rh = new ResponseHelper();
        $rh->setResponse(true,'Se elimino el usuario correctamente');

        //$rh = $objRep->guardar($model);
        if($rh->response){
            $rh->href = 'mantenimiento/usuarios/';
        }
        print_r(json_encode($rh));
    }

    //PROFE METODO
    /* Autor: Encinas Ramos Jose angel
       Descripcion:
       Fecha: 03/Oct/2018
    */
    public function postborraru(){
        $objRep = new UsuarioRepositories();
        $model = $objRep->obtener($_POST['id']);
        $model->activo = (!$model->activo)? 1 : 0;
        $rh = $objRep->guardar($model);
        if($rh->response){
            $rh->href = 'mantenimiento/usuarios';
        }
        print_r(json_encode($rh));
    }

    #endregion

    #region TESTEO DE AJAX

    /* Autor: Encinas Ramos Jose angel
       Descripcion:
       Fecha: 05/Oct/2018
    */
    public function gettest(){
        return $this->render(
            'mantenimiento/test.twig',
            []
        );
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion:
       Fecha: 05/Oct/2018
    */
    public function posttest2(){

        UsuarioValidations::validate($_POST);

        $rh = new ResponseHelper();
        $rh->setResponse(true);
        $rh->result = $_POST;
        print_r(json_encode($rh));
    }

    #endregion
}
