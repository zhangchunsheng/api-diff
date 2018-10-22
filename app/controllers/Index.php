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

            $url = html_entity_decode($url);

            $timer = new \LM\Timer();
            $json = \LM\HttpRequest::post($url, array());
            $ms = $timer->getMs();
            \LM\LoggerHelper::INFO('API', $ms, 'GET', ['api' => $url, 'args' => current($args), 'result' => json_decode($json, true)]);

            echo $json;
            exit();
        } catch(Exception $e) {
            $this->processException(__CLASS__, __METHOD__, $e);
        }

    }
}
