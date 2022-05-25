<?

require_once '../require.php';

class Group {
    public static function createGroup($user_id, $link, $code) {
        global $mysqli;

        return $mysqli->query("INSERT INTO `group` (`group_id`, `author_id`, `link`, `code`) VALUES (NULL, '$user_id', '$link', '$code')");
    }

    public static function getGroupData($link, $code) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `group` WHERE `link` = '$link' AND  `code` = '$code");
        $query = $query->fetch_assoc();

        return $query;
    }

    public static function checkData($column, $data) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `group` WHERE `$column` = '$data'");
        $query = $query->fetch_assoc();
        $query = $query["COUNT"];

        return $query;
    }
}

class GroupUser {
    public static function addUser($group_id, $user_id) {
        global $mysqli;

        return $mysqli->query("INSERT INTO `group_user` (`group_user_id`, `group_id`, `user_id`) VALUES (NULL, '$group_id', '$user_id')");
    }

    public static function deleteUser($group_id, $user_id) {
        global $mysqli;

        return $mysqli->query("DELETE FROM `group_user` WHERE `group_id` = '$group_id' AND `user_id` = '$user_id'");
    }
}

class GroupAdmin {
    public static function addAdmin($group_id, $user_id) {
        global $mysqli;

        return $mysqli->query("INSERT INTO `group_admin` (`group_admin_id`, `group_id`, `admin_id`) VALUES (NULL, '$group_id', '$user_id'))");
    }

    public static function checkAdmin($group_id, $user_id) {
        global $mysqli;

        return $mysqli->query("SELECT * FROM `group_admin` WHERE `group_id` = '$group_id' AND `admin_id` = '$user_id'");
    }

    public static function deleteAdmin($group_id, $user_id) {
        global $mysqli;

        return $mysqli->query("DELETE FROM `group_user` WHERE `group_id` = '$group_id' AND `admin_id` = '$user_id'");
    }
}

?>