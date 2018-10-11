<?php

class IndexController extends ApplicationController {
    // protected $layout = 'frontend';

    public function indexAction() {
        $ret = array();

        $this->renderJsonEx($ret);
    }
}
