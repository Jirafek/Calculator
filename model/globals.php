<?

class Globals {
    static public function checkCount($table, $column, $param) {
        global $mysqli;

        $query = $mysqli->query("SELECT COUNT(*) FROM `$table` WHERE `$column` = '$param'");
        $query = $query->fetch_assoc();
        $query = $query["COUNT(*)"];

        return $query;
    }

    static public function getData($table, $column, $param) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `$table` WHERE `$column` = '$param'");
        $query = $query->fetch_assoc();

        return $query;
    }
}

?>