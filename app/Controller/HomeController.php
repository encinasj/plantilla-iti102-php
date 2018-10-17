<?php

namespace App\Controller;

use Core\Controller;
use Core\ServicesContainer;
/*BY: Encinas Ramos Jose angel
    Año: 2018,
    Materia: Desarrollo Aplicaciones WEB,
    Maestro: Noe Cazares,
    Descripcion: Codigo para el manejo de las vistas.
*/
class HomeController extends Controller {
    private $config;

    public function __construct(){
        parent::__construct();
        $this->config = ServicesContainer::getConfig();


    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para renderizar el archivo llamado index.twig del modulo home para ser mostrado al usuario final.
       Fecha: 19/Sep/2018
    */
    public function getindex(){
        return $this->render('home/index.twig', ['title' => $this->config['company_name']]);
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para renderizar el archivo llamado contacto.twig del modulo home para ser mostrado al usuario final.
       Fecha: 21/Sep/2018
    */
    public function getcontacto(){
        return $this->render('home/contacto.twig');
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para renderizar el archivo llamado nosotros.twig del modulo home para ser mostrado al usuario final.
       Fecha: 21/Sep/2018
    */
    public function getnosotros(){
        return $this->render('home/nosotros.twig');
    }

    /* Autor: Encinas Ramos Jose angel
       Descripcion: Funcion para renderizar el archivo llamado productos.twig del modulo home para ser mostrado al usuario final.
       Fecha: 21/Sep/2018
    */
    public function getproductos(){
        return $this->render('home/productos.twig');
    }
}
