<?php
/**
 * Created by PhpStorm.
 * User: peterzhang
 * Date: 4/4/16
 * Time: 12:47 PM
 */
namespace LM;

class AdminController extends ControllerEx {
    public function init() {
        parent::init();

        $this->getView()->setLayoutPath(
            $this->getConfig()->application->directory
            . "/modules" . "/Admin" . "/views" . "/layouts"
        );
    }
}
