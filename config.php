<?php
return [
    'database' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'database' => 'iti102',
        'username' => 'jencinas',
        'password' => '1q2w3e4r5t6y',
        'port' => 3306,
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '' //Prefijo para los campos
    ],
    'session-time' => 10, //Tiempo de cierre de la session.
    'session-name' => 'application-auth',
    'secret-key' => 'MeGuStAnLaSkEkAs',
    'enviroment' => 'dev', //Desarrollo = dev, Produccion = prod o Pagina Suspendida = stop
    'timezone' => 'America/Hermosillo',
    'cache' => false,
    'company_name' => 'PLANTILLA'
];
