<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Controller
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Dispatcher
 *
 * This class attempts to dispatch a specific controller as gained by the router
 *
 * @package Bwork
 * @subpackage Bwork_Controller
 * @version v 0.4
 */
namespace Bwork\Controller;
use ReflectionClass, App;
class Dispatcher
{

    /**
     * This will dispatch a controller and will perform some checks to prevent
     * failing
     *
     * @param Bwork_Router_Router $router
     * @throws Bwork_Controller_Exception
     * @access public
     * @return void
     */
    public function dispatch(\Bwork\Router\Router $router)
    {
        
        $config = \Bwork\Core\Registry::getInstance()->getResource('Bwork\Config\Confighandler');    

        $controller = $router->controller;
        $action     = $router->action;
        $module     = $router->module;

        if(empty($controller)) {
            throw new Exception('Controller was not set by the router.');
        }
        
        if(empty($action)) {
            throw new Exception('Action was not set by the router.');
        }
        
        $controllerName = $controller.'Controller';
        $filename       = $controller.'.php';
        if(isset($module)) {
            $configModule   = $config->get($module);
            $controllerPath = $config->get('module_path').strtolower($module).DIRECTORY_SEPARATOR.$configModule['controller_path'];
        }
        else {
            $controllerPath = $config->get('controller_path');
        }

        if(\Bwork_Loader_ApplicationAutoloader::fileExists(($filePath = $controllerPath.$filename)) === false) {
            throw new Exception(sprintf('[%s] does not exists', $filePath));
        }

        require_once $filePath;

        
        $reflectionClass = new ReflectionClass($controllerName);

        if($reflectionClass->isSubclassOf('\Bwork\Controller\Action') === false) {
            throw new Exception(sprintf('[%s] have to be an instance of \Bwork\Controller\Action', $controllerName));
        }

        $controllerClass = $reflectionClass->newInstance();
        $controllerClass->invoke($router);
        $controllerClass->getResponse()->outputStatus();
        
    }
    
}