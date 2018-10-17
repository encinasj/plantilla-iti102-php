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

echo "<script>console.log('klkñklñl');</script>";

class AuthController extends Controller{
  private $config;
  private $usuarioRep;

  public function __construct()
  {
    echo "<script>console.log('consteucut');</script>";
    parent::__construct();
    if(Auth::isLoggedIn()){
      UrlHelper::redirect();
    }
    $this->config=ServicesContainer::getConfig();
    $this->$usuarioRep=new UsuarioRepositories();
  }

  public function getindex(){
    $nrand=rand(1,5);
    return $this->render('auth/index.twig',[
      'title'=>'Autentificacion','fondo'=>$nrand, 'company_name'=>$this->config['company_name']
    ]);

}
