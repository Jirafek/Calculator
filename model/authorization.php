<?

class Authorization {
    static public function createUser($login, $email, $password, $session, $psuid) {
        global $mysqli;

        return $mysqli->query("INSERT INTO `user` (`user_id`, `login`, `email`, `password`, `session`, `psuid`) VALUES (NULL, '$login', '$email', '$password', '$session', '$psuid')");
    }

    public static function checkLogin($login) {
        global $mysqli;
    
        $query = $mysqli->query("SELECT COUNT(*) FROM `user` WHERE `login` = '$login'");
        $query = $query->fetch_assoc();
        $query = $query["COUNT(*)"];

	    return $query;
    }

    static public function getUser($login) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `user` WHERE `login` = '$login'");        
        $query = $query->fetch_assoc();

        return $query;
    }

    static public function logUserAuth2($login, $psuid) {
        global $mysqli;

        $query = $mysqli->query("SELECT * FROM `user` WHERE `login` = '$login' AND `psuid` = '$psuid'");        
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