<?

class UserInfo {
    static public function create($first_name, $last_name, $birthday, $user_id) {
        global $mysqli;

        return $mysqli->query("INSERT INTO `user_info` (`user_info_id`, `first_name`, `last_name`, `birthday`, `avatar`, `user_id`) VALUES ('', '$first_name', '$last_name', '$birthday', NULL, '$user_id')");
    }

    static public function update($first_name, $last_name, $birthday, $user_id) {
        global $mysqli;

        return $mysqli->query("UPDATE `user_info` SET `first_name` =  '$first_name', `last_name` = '$last_name', `birthday` = '$birthday' WHERE `user_id` = '$user_id'");
    }

    static public function getData($column, $param) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `user_info` WHERE `$column` = '$param'");
        $query = $query->fetch_assoc();

        return $query;
    }
}

?>