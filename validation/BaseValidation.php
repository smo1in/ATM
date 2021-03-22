<?php
class BaseValidation { 
    private $error_messages = array();
    public function sharedCheck($input) {
        if($input === '') {
            $msg = 'Ввод не может быть пустым';
            $this->setErrorMessage($msg);
            return false;
        }
        if(!(is_numeric($input))) {
            $msg = 'Введите число';
            $this->setErrorMessage($msg);
            return false;
        }
        return true;
    }

    public function setErrorMessage($msg) {
        $this->error_messages[] = $msg;
        return;
    }

    public function getErrorMessages() {
            return $this->error_messages;
    }
}
?>