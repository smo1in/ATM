<?php
require_once('./validation/BaseValidation.php');
class MenuValidation extends BaseValidation {
    public function check($input) {
        $shared_check = $this->sharedCheck($input);
        if(!($shared_check)) {
            return false;
        }
        if (!($input >= 1 && $input <= 3)) {
            if (!($input == 9)) {
                $msg = 'Пожалуйста, введите 1, 2, 3 или 9.';
                $this->setErrorMessage($msg);
                return false;
            }
        }
        return true;
    }
}
?>