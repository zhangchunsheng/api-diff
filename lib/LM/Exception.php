<?php

namespace LM;

class Exception extends \Exception {

    protected $_result;

    public function setResult($result) {
        $this->_result = $result;
        return $this;
    }

    public function getResult() {
        return !empty($this->_result) ? $this->_result : '';
    }

}
