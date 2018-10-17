<?php
namespace Core;


use Core\ServicesContainer;

class Controller{

    protected $provider;
    public function __construct(){
        $config = ServicesContainer::getConfig();
        $loader = new \Twig_Loader_Filesystem(_APP_PATH_ . 'Views/');
        $this->provider = new \Twig_Environment($loader, array('cache' => !$config['cache']? false : _CACHE_PATH_, 'debug' => false));
        //echo '<script>console.log(' . '"' . $this->provider .'"' . ')</script>';
        $this->provider->addExtension(new \Twig_Extension_Debug());
        $this->addCustomFilter();
    }

    public function render(string $view, array $data = []):string{
        return $this->provider->render($view, $data);
    }

    public function addCustomFilter(){
        $this->provider->addFilter(new \Twig_SimpleFilter('public', ['App\\Helpers\\UrlHelper', 'public']));
        $this->provider->addFilter(new \Twig_SimpleFilter('url', ['App\\Helpers\\UrlHelper', 'base']));

    }



}