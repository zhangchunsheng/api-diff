<?php

class ErrorController extends \Yaf\Controller_Abstract {
    
    public function errorAction($exception) {
        eYaf\Logger::getLogger()->logException($exception);

        switch ($exception->getCode()) {
            case YAF\ERR\AUTOLOAD_FAILED:
            case YAF\ERR\NOTFOUND\MODULE:
            case YAF\ERR\NOTFOUND\CONTROLLER:
            case YAF\ERR\NOTFOUND\ACTION:
                $ret = array(
                    "code" => 404,
                    "msg" => "Not Found",
                );
                break;
            case 401:
                $ret = array(
                    "code" => 401,
                    "msg" => "Not Authentication",
                );
                break;
            default:
                $ret = array(
                    "code" => 500,
                    "msg" => "Internal Server Error",
                );
                break;
        }

        eYaf\Logger::stopLogging();

        echo json_encode($ret);
        exit();
    }
}
