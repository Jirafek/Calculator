<?

class GroupUser {
    public static function addUser($group_id, $user_id, $user_access) {
        global $mysqli;

        return $mysqli->query("INSERT INTO `group_user` (`group_user_id`, `group_id`, `user_id`, `user_access`) VALUES (NULL, '$group_id', '$user_id', '$user_access')");
    }

    public static function deleteUser($group_id, $user_id) {
        global $mysqli;

        return $mysqli->query("DELETE FROM `group_user` WHERE `group_id` = '$group_id' AND `user_id` = '$user_id'");
    }

    static public function checkData($column, $param) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `user_info` WHERE `$column` = '$param'");
        $query = $query->fetch_assoc();

        return $query;
    }
}

?>