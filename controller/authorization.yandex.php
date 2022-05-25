<?

class AuthorizationHttpYandex {
    static public function createUser($data, $session) {
        $data = file_get_contents('php://input');
        $data = json_decode($data, true);

        $login = protectionData($data['login']);
        $email = protectionData($data['default_email']);

        $errors = [];

        if (Authorization::checkLogin($login)) {
            $errors[] = 'Такой логин уже существует';
            return AuthorizationHttpYandex::logUser($login, $session);
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Недопустимый email';
        }
    
        if (!empty($errors)) {
            echo '<p>' . array_shift($errors) . '</p>';
            return;
        }
    
        $password = password_hash(md5(random_int(1000, 9999) . time()), PASSWORD_DEFAULT);
        $session = md5(random_int(1000, 9999) + time());
    
        $create_user = Authorization::createUser($login, $email, $password, $session);
    
        if (!$create_user) {
            echo '<p>Пользователь не создан</p>';
            return;
        }
    
        setcookie('login', $login, time()+60*60*24*30);
        setcookie('session', $session, time()+60*60*24*30);
    
        checkCookieSession($login, $session);
    
        echo '<p>Регистрация прошла успешно!</p>';
        header('Refresh: 3');
    }

    static public function logUser($login, $session) {

        $session = Authorization::checkCookieSession($login, $session);

        if ($session) {
            $_SESSION['user'] = Authorization::getUser($login);
        }
    }
}

?>