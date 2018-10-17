<?php

namespace App\Helpers;


class UrlHelper{

    /*BY: Encinas Ramos Jose angel
        Año: 2018,
        Materia: Desarrollo de Aplicaciones Web,
        Maestro: CAZAREZ CAMARGO NOE,
        Descripcion: Funcion estatica para redireccionar al url base concatenandole una url dada por el usuario mediante su parametro $url.
    */
    public static function redirect(string $url = ''){
        header(sprintf("Location: %s%s", _BASE_HTTP_, $url));
    }

    /*BY: Encinas Ramos Jose angel
        Año: 2018,
        Materia: Desarrollo de Aplicaciones Web,
        Maestro: CAZAREZ CAMARGO NOE,
        Descripcion: Funcion estatica para concatenar una ruta a la url base del sistema web.
    */
    public static function base(string $route = ''): string{
        return _BASE_HTTP_ . $route;
    }

    /*BY: Encinas Ramos Jose angel
        Año: 2018,
        Materia: Desarrollo de Aplicaciones Web,
        Maestro: CAZAREZ CAMARGO NOE,
        Descripcion: Funcion estatica para concatenar para obtener acceso a la carpeta public y usar archivos.
    */
    public static function public(string $route = ''): string{
        return _BASE_HTTP_ . 'public/' . $route;
    }

}
