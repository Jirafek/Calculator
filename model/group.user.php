<?

class GroupUser {
    public static function add($group_id, $user_id, $user_access) {
        global $mysqli;

        return $mysqli->query("INSERT INTO `group_user` (`group_user_id`, `group_id`, `user_id`, `user_access`) VALUES (NULL, '$group_id', '$user_id', '$user_access')");
    }

    public static function updateAccess($group_id, $user_id, $user_access) {
        global $mysqli;

        return $mysqli->query("UPDATE `group_user` SET `user_access`='$user_access' WHERE `group_id` = '$group_id' AND `user_id` = '$user_id'");
    }

    public static function delete($group_id, $user_id) {
        global $mysqli;

        return $mysqli->query("DELETE FROM `group_user` WHERE `group_id` = '$group_id' AND `user_id` = '$user_id'");
    }
}

?>