<?php
require_once('./validation/BaseValidation.php');
class DepositValidation extends BaseValidation {
    public function check($input ,$msg = null) {
        $shared_check = $this->sharedCheck($input) ;
        if(!($shared_check)) {
            return false;
        }
        if ($input > atm::DEPOSIT_LIMIT) {
            $msg = 'Превышен лимит депозита ' . atm::DEPOSIT_LIMIT;
            $this->setErrorMessage($msg);
        }
        if ($input == 0) {
            $msg = 'Минимальный депозит ' . atm::ONE_HUNDRED_BILL ;
            $this->setErrorMessage($msg);
        }
        if ($input % atm::ONE_HUNDRED_BILL !== 0) {
            $msg = 'Банкомат принимает только купюры ' . atm::ONE_HUNDRED_BILL . ' введите новую сумму';
            $this->setErrorMessage($msg);
        }
        if($msg) {
            return false;
        }
        return true;
    }
}

?>
