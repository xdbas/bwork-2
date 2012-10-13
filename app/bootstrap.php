<?php

namespace App;

class Bootstrap extends \Bwork\Bootstrap\AbstractBootstrap {
       
    public function _initConfig()
    {
        $config = \Bwork\Core\Registry::getInstance()
                ->getResource('Bwork\Config\Confighandler')
                ->loadFile(APPLICATION_PATH.'config'.DIRECTORY_SEPARATOR.'route.php');
    }
    
    public function _initLayout()
    {
        $layout = new \Bwork\Layout\PHP();
        $layout->setLayout('layout.php');

        return new \Bwork\Bootstrap\Alias('Bwork\Layout\Layout', $layout);
    }
    
    public function _initHelper()
    {
        //Bwork_Helper_Handler::registerNamespace('Bwork_Helper');
    }

    public function _initModule()
    {
        $module = new \Bwork\Module\Manager();
        $module->addModule('admin');

        return $module;
    }
}