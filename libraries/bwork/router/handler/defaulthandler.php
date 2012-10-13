<?php
/**
 * Bwork Framework
 *
 * @package Bwork
 * @subpackage Bwork_Router_Handler
 * @author Bas van Manen <basje1[at]gmail.com>
 * @version $id: Bwork Framework v 0.1
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

/**
 * Default
 *
 * This class is a handler for the router and will attempt to resolve routes via
 * the config class
 *
 * @package Bwork
 * @subpackage Bwork_Router_Handler
 * @version v 0.2
 */
namespace Bwork\Router\Handler;

final class DefaultHandler
    implements \Bwork\Router\Handler
{
    
    /**
     * Will store the route with the parameters gained when resolving a route
     *
     * @var array
     * @access protected
     */
    protected $route;

    /**
     * Will check if a route is set for this uri
     *
     * @see Bwork_Router_Handler_Interface::checkRoute()
     * @param array $uri
     * @return bool
     */
    public function checkRoute(array $uri)
    {
        $uri    = implode('/', $uri);
        $config = \Bwork\Core\Registry::getInstance()->getResource('Bwork\Config\Confighandler');
        
        if($config->exists('route')) {
            $routes = $config->get('route');
            if(array_key_exists($uri, $routes)) {

                $route = $routes[$uri];
                $this->route = new \Bwork\Router\Route(
                    $route['controller'],
                    $route['action'],
                    $route['module'],
                    $route['mockParams']
                );

                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Will return the resolved Params used for dispatching
     *
     * @see Bwork_Router_Handler::getParams()
     * @return Bwork_Router_Route
     */
    public function getParams()
    {
        return $this->route;
    }
}
