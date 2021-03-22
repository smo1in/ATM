<?php
require_once('./User.php');
require_once('./validation/MenuValidation.php');
require_once('./validation/DepositValidation.php');
require_once('./validation/WithdrawValidation.php');
require_once('./validation/IdValidation.php');
require_once('./validation/PasswordValidation.php');

class ATM {
    // Авторизация пользователя
    private $select_user;
    // Ограничение количества ошибок PIN-кода (только числовой ввод)
    private const PASSWORD_COUNT = 3;
    private const MENU_LIST = "1-Депозит 2-Снятие 3-Запрос баланса 9-Выход" . PHP_EOL;
    //Меню: 1 Депозит 2 Снятие 3 Проверить баланс
    private const MENU_TYPE_DEPOSIT = 1;
    private const MENU_TYPE_WITHDRAWAL = 2;
    private const MENU_TYPE_BALANCE = 3;
    //Меню: 9 Выход
    private const MENU_TYPE_END = 9;
    //Информация о пользователе
    private const NAME ='name';
    private const ID ='id';
    private const PASSWORD = 'password';
    private const BALANCE = 'balance';
    private const MENU = 'menu';
    private const DEPOSIT = 'deposit';
    private const WITHDRAW = 'withdraw';
    //Лимит депозита, лимит снятия, купюры
    public const DEPOSIT_LIMIT = 1000;
    public const WITHDRAW_LIMIT = 1000;
    public const ONE_HUNDRED_BILL = 100;


    //Количество пользователей
    public const USER_COUNT = 2;

    public function  __construct() {
        $this->login();
        echo $this->select_user[self::NAME] . ' Пожалуйста, введите желаемый номер меню.' . PHP_EOL;
    }

    private function login() {       
        echo 'Пожалуйста, введите ваш ID пользователя' . PHP_EOL;
        $id = $this->input(self::ID);
        //Получите данные пользователя с помощью ключевого числа, которое представляет собой комбинацию / id и числа.
        $this->select_user = User::getUserById($id);
        $this->checkPassword();
        return;
    }
    //Проверка PIN-кода
    public function checkPassword() {
        for ($i=1; $i <= self::PASSWORD_COUNT; $i++) {
            echo 'Пожалуйста, введите ваш PIN' . PHP_EOL;
            $password = $this->input(self::PASSWORD);
            if($this->select_user[self::PASSWORD] !== $password)  {
                echo 'PIN-код не верный' . PHP_EOL;
            }
            if ($this->select_user[self::PASSWORD] === $password) {
                return true;
            }
            if ($i === self::PASSWORD_COUNT) {
                exit('Превышено колво попыток ввода PIN.' .PHP_EOL);
            }
        }
    }

    //Основное меню
    public function play() {
        echo self::MENU_LIST;
        echo ': ';
        $selectMenu = $this->input(self::MENU);
        if ($selectMenu == self::MENU_TYPE_DEPOSIT) {
            $this->deposit();
            return $this->play();
        }
        if ($selectMenu == self::MENU_TYPE_WITHDRAWAL) {
            $this->atmWithdraw();
            return $this->play();
        }
        if ($selectMenu == self::MENU_TYPE_BALANCE) {
            $this->atmShow();
            return $this->play();
        }
        if ($selectMenu == self::MENU_TYPE_END) {
            $this->atmEnd();
            return $this->play();
        }
    }
    //Ввод
    public function input($type) {
        // читает одну строку из потока STDIN
        $input = trim(fgets(STDIN));
        if($type === self::MENU) {
            $validation = new MenuValidation();
            $check = $validation->check($input);
        }
        if($type === self::DEPOSIT) {
            $validation = new DepositValidation();
            $check = $validation->check($input);
        }
        if($type === self::WITHDRAW) {
            $validation = new WithdrawValidation();
            $check = $validation->check($input);
        }
        if($type === self::ID) {
            $validation = new IdValidation();
            $check = $validation->check($input);
        }
        if($type === self::PASSWORD) {
            $validation = new PasswordValidation();
            $check = $validation->check($input);
        }
        if(!$check) {
            $msgs = $validation->getErrorMessages();
            $this->showErrorMessages($msgs);
            return $this->input($type);
        }
        return $input;
    }
    //оплата
    public function deposit() {
        $this->select_user[self::BALANCE];
        echo 'Пожалуйста, введите сумму депозита кратную ' . atm::ONE_HUNDRED_BILL . PHP_EOL;
        echo ': ';
        $depositMoney = $this->input(self::DEPOSIT);
        $this->select_user[self::BALANCE] += $depositMoney;
        echo number_format($depositMoney);
        echo ' Ваш баланс успешно обновлен.' . PHP_EOL;
        return;
    }
    //Снятие
    public function atmWithdraw() {
        $this->checkPassword();
        $this->select_user[self::BALANCE];
        echo 'Пожалуйста, введите желаемую сумму.' . PHP_EOL;
        echo ': ';
        $withdrawMoney = $this->input(self::WITHDRAW);
        if ($this->select_user[self::BALANCE] < $withdrawMoney) {
            echo 'Сумма превышает Ваш баланс ' .PHP_EOL;
            return $this->input(self::WITHDRAW);
        }
        $this->select_user[self::BALANCE] -= $withdrawMoney;
        echo number_format($withdrawMoney);
        echo ' Пожалуйста, не забудьте взять деньги.' . PHP_EOL;
        return;
    }
    //Запрос баланса
    public function atmShow() {
        $balance = $this->select_user[self::BALANCE];
        echo "$" . number_format($balance) .PHP_EOL;
        return;
    }
    //Конец
    public function atmEnd() {
        exit('Спасибо за использование.' . PHP_EOL);
    }
    //индикация ошибки
    public function showErrorMessages($msgs) {
        foreach($msgs as $msg) {
            echo $msg . PHP_EOL;
        }
    }
}

$ATM = new ATM();
$ATM -> play();
?>