<?php
require_once('./validation/BaseValidation.php');
class WithdrawValidation extends BaseValidation {
    public function check($input, $msg = null) {
        $shared_check = $this->sharedCheck($input) ;
        if(!($shared_check)) {
            return false;
        }
        if ($input > atm::WITHDRAW_LIMIT) {
            $msg = 'Сумма снятия превысила предел ' . atm::WITHDRAW_LIMIT . ' введите новую сумму';
            $this->setErrorMessage($msg);
        }
        if ($input == 0) {
            $msg = 'Минимальная сумма вывода ' . atm::ONE_HUNDRED_BILL . ' введите новую сумму';
            $this->setErrorMessage($msg);
        }
        if ($input  % atm::ONE_HUNDRED_BILL !== 0) {
            $msg = 'Банкомат выдает только купюры ' . atm::ONE_HUNDRED_BILL .  ' введите новую сумму';
            $this->setErrorMessage($msg);
        }
        if($msg) {
            return false;
        }
        return true;
    }
}

?>
