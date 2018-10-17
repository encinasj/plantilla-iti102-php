<?php
declare(strict_types=1);  //Opción para depurar.

namespace App\Controller;
/**
 *
 */
 use Core\Controller;
 use Core\ServicesContainer;
 use Core\Auth;
 use App\Helpers\UrlHelper;
 use App\Repositories\UsuarioRepositories;


class AuthController extends Controller{
  private $config;
  private $usuarioRep;

  public function __construct()
  {
    parent::__construct();
    if(Auth::isLoggedIn()){
      UrlHelper::redirect();
    }
    $this->config=ServicesContainer::getConfig();
    $this->usuarioRep=new UsuarioRepositories();
  }

  public function getindex()
  {
      $nrand = rand(1, 5);
      return $this->render('auth/index.twig', [
          'title' => 'Autentificacion',
          'fondo' => $nrand,
          'company_name' => $this->config['company_name']
      ]);
  }

}
