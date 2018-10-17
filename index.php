<?php

    declare(strict_types=1);  //Opción para depurar.

    //level = > severidad
    function exception_error_handler($level, $message, $file, $line ){
        if(!(error_reporting() && $level)){
            return;
        }
        throw new ErrorException($message, 0, $level, $line);
    }

    //Delegado
    set_error_handler('exception_error_handler');

    /* composer psr-4 */
    require_once('vendor/autoload.php');

    /* Asignar la configuracion (archivo config.php) */
    \Core\ServicesContainer::setConfig(require_once 'config.php');

    /*  Inicializamos el DbContect  */
    \Core\ServicesContainer::initializeDbContext();

    $config = \Core\ServicesContainer::getConfig();

    /*  Establecer zona horaria*/
    date_default_timezone_set($config['timezone']);


    ini_set('memory_limit', '-1');

    /* url base */
    $base_url = '';
    $base_folder = strtolower(str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']));

    if(isset($_SERVER['HTTP_HOST'])){
        $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off' ? 'https' : 'http';
        $base_url .= '://' . $_SERVER['HTTP_HOST'];
        $base_url .= $base_folder;
    }



    define('_BASE_HTTP_', $base_url);
    define('_BASE_PATH_', __DIR__.'/');
    define('_LOG_PATH_', __DIR__. '/log/');
    define('_CACHE_PATH_', __DIR__. '/cache/');
    define('_APP_PATH_', __DIR__. '/app/');
    define('_CURRENT_URI_', str_replace($base_folder, '', $_SERVER['REQUEST_URI'])); // <-- CAMBIAR AQUI...

    if($config['enviroment'] == 'stop'){
        exit('Sistema Temporalmente fuera de linea, favor de regresar mas tarde ...');
    }

    if($config['enviroment'] == 'dev'){
        error_reporting(0);
    }

    /* FIN DE LA CONFIGURACION */

    /* ROUTING */
    $router = new \Phroute\Phroute\RouteCollector();

    include_once 'app/routes.php';

    $dispacher = new \Phroute\Phroute\Dispatcher($router->getData());

    $response = $dispacher->dispatch($_SERVER['REQUEST_METHOD'], _CURRENT_URI_);
    //echo $base_folder;
    echo $response;