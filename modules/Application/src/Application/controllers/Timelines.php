<?php
namespace Application\controllers;

use Core\Application\application;
use Core\Application\Router\model\parseUrl;
use Application\Services;

class Timelines
{
    public $layout = 'none.phtml';
    
    public function index()
    {
       $config = application::getConfig();
       $method = $_SERVER['REQUEST_METHOD']; 

        $router = parseUrl::parseURL();
       
        $service = new Services\Timelines();
        return $service->$method($router['params']);
    }
   
    
}





