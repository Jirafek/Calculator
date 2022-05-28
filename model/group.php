<?

class Group {
    public static function createGroup($group_name, $user_id, $link, $code) {
        global $mysqli;

        return $mysqli->query("INSERT INTO `group` (`group_id`, `group_name`,`author_id`, `link`, `code`) VALUES (NULL, '$group_name', '$user_id', '$link', '$code')");
    }

    public static function getGroupData($link, $code) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `group` WHERE `link` = '$link' AND `code` = '$code");
        $query = $query->fetch_assoc();

        return $query;
    }

    public static function checkData($column, $data) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `group` WHERE `$column` = '$data'");
        $query = $query->fetch_assoc();

        return $query;
    }
}

?>