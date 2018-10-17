<?php
/**
 * Created by PhpStorm.
 * User: Encinas Ramos Jose Angel
 * Date: 11/Oct/2018
 * Time: 22:05
 */

namespace App\Validations;

use App\Helpers\ResponseHelper;
use Respect\Validation\Validator as v;


class PermisoValidations{

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para validar los campos de el rol.
       Fecha: 11/Oct/2018
    */
    public static function validar(array $model){
        try{

            $v = v::key(
                'nombre',
                v::stringType()->notEmpty()->length(1, 200)
                //v::stringType()->length(5)
            );
            $v->assert($model);
        }catch (\Exception $ex){
            $rh = new ResponseHelper();
            $rh->setResponse(false, null);
            $rh->validations = $ex->findMessages([
                'nombre' => 'Campo requerido'
            ]);
            exit(json_encode($rh));
        }

    }

}
