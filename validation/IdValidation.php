<?php
require_once('./validation/BaseValidation.php');
class IdValidation extends BaseValidation {
    public function check($input) {
        $shared_check = $this->sharedCheck($input);
        if(!($shared_check)) {
            return false;
        }
        if(!User::checkUserList($input)) {
            $msg = 'Пожалуйста, введите зарегистрированный ID пользователя';
            $this->setErrorMessage($msg);
            return false;
        }
        return true;
    }
}
?>