<?php

namespace LM;

use Yaf\Controller_Abstract;
use CrmCommon\OperatorModel;
use CrmCommon\CrmAppModel;
use CrmCommon\OperatorTrackModel;

class ControllerEx extends ApiControllerEx {
    const DEFAULT_APP_ID = 47;

    const RET_OK = 200;

    const RET_NOT_FOUND = 404;
    const RET_FORBIDDEN = 403;
    const RET_UNKNOWN = 500;
    const RET_INVALID_PARAM = 400;
    const RET_EXPIRE = 408;

    public function init() {
        $controllerName = $this->getRequest()->getControllerName();
        $actionName = $this->getRequest()->getActionName();
    }

    protected function render($tpl, array $parameters = array()) {
        parent::display($tpl, $parameters);
        \Yaf\Dispatcher::getInstance()->disableView();
    }

    public function redirect($done) {
        parent::redirect($done);
        exit(0);
    }

    protected function _isPost() {
        return isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST';
    }
    
    public function _error($msg) {
        $result = array(
            "code" => 500,
            "msg" => $msg,
        );
        echo json_encode($result);
        exit();
    }
}
