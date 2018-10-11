<?php

class IndexController extends ApplicationController {
    // protected $layout = 'frontend';

    public function indexAction() {
        $ret = array();

        $this->renderJsonEx($ret);
    }

    public function requestAction() {
        try {
            $url = \LM\Input::post("url");
            \LM\Checker::notempty($url, "url");

            $json = \LM\HttpRequest::post($url, array());

            echo $json;
            exit();
        } catch(Exception $e) {
            $this->processException(__CLASS__, __METHOD__, $e);
        }

    }
}
