<?php

class Zend_Controller_Router_Route_Redirect extends Zend_Controller_Router_Route
{
    public function match($path, $partial = false)
    {
        if ($route = parent::match($path, $partial)) {
            $helper = new Zend_Controller_Action_Helper_Redirector();
            $helper->setCode(301);
            $helper->gotoRoute($route);
        }
    }
}