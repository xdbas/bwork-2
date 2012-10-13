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
 * Action
 *
 * This is a class supposed to be extended by a controller to inherit its
 * methods and get access to the Http Request and Http Response
 *
 * @package Bwork
 * @subpackage Bwork_Controller
 * @version v 0.1
 * @abstract
 */
namespace Bwork\Controller;
use ReflectionMethod;
abstract class Action
{
    
    /**
     * Hold the Http Request object
     *
     * @var Bwork_Http_Request $request
     */
    protected $request;
    
    /**
     * Hold the http response Object
     *
     * @var Bwork_Http_Response $response
     */
    protected $response;
    
    /**
     * Hold the mock params set by a routing service
     *
     * @var array $mockParams;
     */
    protected $mockParams;
    
    /**
     * Hold the layout enabled setting
     *
     * @var boolean $layoutEnabled
     */
    protected $layoutEnabled = true;


    /**
     * The construction method used to assign the Request and Response objects
     * to their variables
     *
     * @access public
     * @return Bwork_Controller_Action
     */
    public function __construct()
    {
        $this->setRequest(
            \Bwork\Core\Registry::getInstance()->getResource('Bwork\Http\Request')
        ); 
        
        $this->setResponse(
            \Bwork\Core\Registry::getInstance()->getResource('Bwork\Http\Response')
        );
    }
    
    /**
     * This will set the Request variable
     *
     * @param Bwork_Http_Request $request
     * @access public
     * @return Bwork_Controller_Action
     */
    public function setRequest(\Bwork\Http\Request $request)
    {
        $this->request = $request;

        return $this;
    }
    
    /**
     * This will return the request variable
     *
     * @access public
     * @return Bwork_Http_Request 
     */
    public function getRequest()
    {
        return $this->request;
    }
    
    /**
     * This will set the Response variable
     *
     * @param Bwork_Http_Response $response 
     * @access public
     * @return Bwork_Controller_Action
     */
    public function setResponse(\Bwork\Http\Response $response)
    {
        $this->response = $response;

        return $this;
    }
    
    /**
     * This will return the response variable
     *
     * @access public
     * @return Bwork_Http_Response 
     */
    public function getResponse()
    {
        return $this->response;
    }
    
    /**
     * This will set the mockParams from the Router
     *
     * @param Bwork_Router_Router $router 
     * @access protected
     * @return Bwork_Controller_Action
     */
    protected function setMockParams(\Bwork\Router\Router $router)
    {
        $this->mockParams = $router->mockParams;

        return $this;
    }

    /**
     * This will invoke an action
     *
     * @param Bwork_Router_Router $router
     * @access public
     * @throws Bwork_Controller_Exception
     * @return void
     */
    public function invoke(\Bwork\Router\Router $router)
    {
        \Bwork\Controller\Action::__construct();
        $this->setMockParams($router);
        
        $action = $router->action.'Action';
        if(in_array($action, get_class_methods($this)) == false) {
           $this->__call($action, array());
        }
        
        if(is_callable(array($this, $action)) == false) {
            throw new Exception(sprintf('Unable to call action [%s]', $action));
        }
        
        $methodReflection = new ReflectionMethod($this, $action);
        $returnData       = $methodReflection->invoke($this, isset($this->mockParams)? $this->mockParams : null);
        
        if(is_string($returnData) 
            || is_null($returnData)){
            $this->handleString($returnData);
        }
        else if(is_object($returnData)) {
           $this->handleView($returnData); 
        }
        else {
            throw new Exception('Return type from controllerAction should either be a string or an object');
        }
    }
    
    /**
     * This will handle a string return value retrieved from the action method
     *
     * @param null|string $content
     * @access protected
     * @return void
     */
    protected function handleString($content = null)
    {
        $this->response->setBody($content);
    }

    /**
     * This will handle the return data retrieved from the action method
     *
     * @param Bwork_View_View $view
     * @throws Bwork_Controller_Exception
     * @access protected
     * @return void
     */
    protected function handleView(\Bwork\View\View $view)
    {
        if($view instanceof \Bwork\View\View == false) {
            throw new Exception('ControllerAction return value should be an instance of Bwork_View_View');
        }
        
        $content = $view->fetch();

        if($this->layoutEnabled == true) {
            $layout = \Bwork\Core\Registry::getInstance()->getResource('Bwork\Layout\Layout');
            
            $layout->mergeVariables($view->getVariables());
            $layout->setContent($content);
            
            $content = $layout->fetch();
        }
        
        $this->response->setBody($content);
    }

    /**
     * Called when invoking on an undefined method
     *
     * @param string $name
     * @param array $arguments
     * @throws Bwork_Controller_Exception
     * @return void
     */
    public function __call($name, $arguments)
    {
        if(substr($name, -6) == 'Action') {
            throw new Exception(sprintf('Action %s does not exists and has been caught by __call', $name), 404);
        }
                
        throw new Exception(sprintf('Method %s does not exists and has been caught by __call', $name));
    }
    
}