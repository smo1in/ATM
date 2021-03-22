<?php
class User {
    private static $user_list = array(
        1 => array(
            "id" => "1",
            "password" => "1111",
            "name" => "user1",
            "balance" => "5000"
        ),
        2 => array(
            "id" => "2",
            "password" => "2222",
            "name" => "user2",
            "balance" => "10000"
        ),
    );

    public function checkUserList($id) {
        for($i = 1; $i <= atm::USER_COUNT; $i++) {
            if(self::$user_list[$i]['id'] === $id) {
                return true;
            }
        }
        return false;
    }

    public function getUserById($id) {
        return self::$user_list[$id];
    }
}

?>
