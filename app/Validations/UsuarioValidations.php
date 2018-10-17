<?php

/*  by: Encinas Ramos Jose Angel
    año: 10/9/18,
    Materia: DESWEB,
    Maestro: Noe,
    Descripcion: Clase que nos permitira realizar validaciones necesarias para los usuarios.
*/

namespace App\Validations;

use Respect\Validation\Validator as v;
use App\Helpers\ResponseHelper;

class UsuarioValidations{

    public static function validate(array $model){
        try{
            $v = v::key(
                'nombre',
                v::stringType()->notEmpty()
            )->key(
                'apaterno',
                v::stringType()->notEmpty()
            )->key(
                'amaterno',
                v::stringType()->notEmpty()
            )->key(
                'correo',
                v::stringType()->notEmpty()
            );



            $v->assert($model);
        }catch(\Exception $ex){
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $ex->findMessages([
                //'nombre' => 'Campo {{nombre}} requerido',   //Para imprimir el nombre de la variable
                'nombre' => 'Campo requerido',
                'apaterno' => 'Campo requerido',
                'amaterno' => 'Campo requerido',
                'correo' => 'Campo requerido',
                'password' => 'Campo requerido'
            ]);
            exit(json_encode($rh));
        }
    }

}
