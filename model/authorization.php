<?

class Authorization {
    static public function createUser($login, $email, $password, $session) {
        global $mysqli;
        return $mysqli->query("INSERT INTO `user` (`user_id`, `login`, `email`, `password`, `session`, `group_id`) VALUES (NULL, '$login', '$email', '$password', '$session', NULL)");
    }

    public static function checkLogin($login) {
        global $mysqli;
    
        $query = $mysqli->query("SELECT * FROM `user` WHERE `login` = '$login'");
        $query = $query->fetch_assoc($query);
        $query = $query["COUNT"];
    
        return $query;
    }

    static public function getUser($login) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `user` WHERE `login` = '$login'");        
        $query = $query->fetch_assoc();

        return $query;
    }

    static public function checkCookieSession($login, $session) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `user` WHERE `login` = '$login' and `session` = '$session'");
        $query = $query->fetch_assoc();

        return $query;
    }
} 

?>