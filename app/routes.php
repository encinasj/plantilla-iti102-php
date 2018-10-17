<?php

    // $router->group(['before'=>'auth'],function($router){
    //
    //   $router->controller('mantenimiento', 'App\\Controller\\MantenimientoController');
    // });

    // $router->controller('auth', 'App\\Controller\\AuthController');
    echo "<script>console.log('Debug');</script>";

    $router->controller('home', 'App\\Controller\\HomeController');

    /*BY: Encinas Ramos José Angel
        Año: 2018,
        Materia: Desarrollo de Aplicaciones Web,
        Maestro: CAZAREZ CAMARGO NOE,
        Descripcion: Controlador para mostrar el mantenimiento usando el MantenimientoController, al mantenimiento se le conoce tambien como admin.
    */
    //$router->controller('mantenimiento', 'App\\Controller\\MantenimientoController');
    $router->controller('mantenimiento/usuarios', 'App\\Controller\\MantenimientoController');



    $router->controller('mantenimiento/roles', 'App\\Controller\\RolController');

    $router->controller('mantenimiento/permisos', 'App\\Controller\\PermisoController');

    echo "<script>console.log('wefwe');</script>";
    $router->controller('auth', 'App\\Controller\\AuthController');
    echo "<script>console.log('passo');</script>";

    /*BY: Encinas Ramos José Angel
        Año: 28/Sep/2018,
        Materia: Desarrollo de Aplicaciones Web,
        Maestro: CAZAREZ CAMARGO NOE,
        Descripcion: Controlador para mostrar los roles usando el RolController.
    */
    //$router->controller('roles', 'App\\Controller\\RolController');

    $router->get('/', function(){
        \App\Helpers\UrlHelper::redirect('home');
      // if(Core\Auth::isLoggedIn()){
      //   \App\Helpers\UrlHelper::redirect('home');
      // }else{
      //   \App\Helpers\UrlHelper::redirect('auth');
      // }
    });

    $router->get('/help', function(){
        return "Desarrollado por: Ing. encians ramos";
    }, ['before'=>'auth']);
