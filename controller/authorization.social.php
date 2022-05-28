<?

class AuthorizationSocial {
    static public function createUser($data, $session) {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);

        $login = protectionData($data['login']);
        $email = protectionData($data['default_email']);

        
        $psuid = md5(protectionData($data['id']));

        if (Authorization::checkLogin($login)) {
            AuthorizationSocial::logUser($login, $psuid);
            return;
        }
    
        $password = password_hash(md5(random_int(1000, 9999) . time()), PASSWORD_DEFAULT);
        $session = md5(random_int(1000, 9999) + time());
    
        $create_user = Authorization::createUser($login, $email, $password, $session, $psuid);
    
        if (!$create_user) {
            $message = [
                'message' => 'Пользователь не создан',
                'status' => 'false'
            ];
    
            echo json_encode($message);
            return;
        }
    
        setcookie('login', $login, time()+60*60*24*30);
        setcookie('session', $session, time()+60*60*24*30);
    
        checkCookieSession($login, $session);
    
        $message = [
            'message' => 'Регистрация прошла успешно!',
            'status' => 'true'
        ];

        echo json_encode($message);
    }

    static public function logUser($login, $psuid) {
        $auth = Authorization::logUserAuth2($login, $psuid);
        
        if ($auth) {
            setcookie('login', $_SESSION['user']['login'], time()+60*60*24*30);
            setcookie('session', $_SESSION['user']['session'], time()+60*60*24*30);

            $_SESSION['user'] = Authorization::getUser($login);
        }
    }
}

?>