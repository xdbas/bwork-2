<?php

class HomeController extends \Bwork\Controller\Action {
    
    public function indexAction() {

    	$mode = new TestModel();
    	print_r($mode->test());

        return new \Bwork\View\PHP();
    }
    
}
