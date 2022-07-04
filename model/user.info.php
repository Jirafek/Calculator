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

    static public function updateAvatar($user_id, $avatar) {
        global $mysqli;

        return $mysqli->query("UPDATE `user_info` SET `avatar` = '$avatar' WHERE `user_id` = '$user_id'");
    }

    static public function get($id) {
        global $mysqli;

        $query = $mysqli->query("SELECT `user`.`user_id`, `user`.`login`, `user`.`email`, `user`.`group_id`, `user`.`group_id`,`user_info`.* FROM `user` INNER JOIN `user_info` ON `user`.`user_id` = `user_info`.`user_id` WHERE `user`.`user_id` = '$id';");
        $query = $query->fetch_assoc();

        return $query;
    }
}

?>