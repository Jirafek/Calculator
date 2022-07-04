<?

class User {
    public static function edit($user_id, $login, $email, $telephone) {
        global $mysqli;

        return $mysqli->query("UPDATE `user` SET `login`='$login', `email`='$email', `telephone`='$telephone' WHERE `user_id` = '$user_id'");
    }

    public static function editPassword($user_id, $password) {
        global $mysqli;

        return $mysqli->query("UPDATE `user` SET `password`='$password' WHERE `user_id` = '$user_id'");
    }
}

?>