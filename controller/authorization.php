<?

function createUser($data) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $login = protectionData($data['login']);
    $email = protectionData($data['email']);
    $password = protectionData($data['password']);

    $errors = [];

    if (strlen($login) < 4) {
        $errors[] = 'Логин меньше 4 символов';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Пароль меньше 8 символов';
    }

    if (Authorization::checkLogin($login)) {
        $errors[] = 'Такой логин уже существует';
    }

    if (!preg_match('/^[a-z0-9]+$/i', $login)) {
        $errors[] = 'Недопустимый логин';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Недопустимый email';
    }

    if (!empty($errors)) {
        $message = [
            'message' => array_shift($errors),
            'status' => 'false'
        ];

        echo json_encode($message);
        return;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $session = md5(random_int(1000, 9999) + time());

    $create_user = Authorization::createUser($login, $email, $password, $session, time());

    if (!$create_user) {
        echo '<p>Пользователь не создан</p>';
        $message = [
            'message' => 'Пользователь не создан',
            'status' => 'true'
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

function logUser($data) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $login = protectionData($data['login']);
    $password = protectionData($data['password']);

    $errors = [];

    $user = Authorization::getUser($login);

    $password_hash = trim($user['password']);

    if (!$password_hash) {
        $errors[] = 'Такого логина не существует';
    }

    if (!password_verify($password, $password_hash)) {
        $errors[] = 'Неправильный пароль';
    }

    if (!empty($errors)) {
        $message = [
            'message' => array_shift($errors),
            'status' => 'false'
        ];

        echo json_encode($message);
        return;
    }

    $_SESSION['user'] = $user;

    setcookie('login', $_SESSION['user']['login'], time()+60*60*24*30);
    setcookie('session', $_SESSION['user']['session'], time()+60*60*24*30);

    $message = [
        'message' => 'Успешная авторизация!',
        'status' => 'true'
    ];

    echo json_encode($message);
}

function checkCookieSession($login, $session) {
    $login = protectionData($login);
    $session = protectionData($session);

    $session = Authorization::checkCookieSession($login, $session);

    if (!$session) {
        http_response_code(404);

        $message = [
            'message' => 'Сессии не существует',
            'status' => 'false'
        ];

        echo json_encode($message);
        return;
    }

    $_SESSION['user'] = Authorization::getUser($login);

    $message = [
        'message' => 'Успешная авторизация',
        'status' => 'true'
    ];

    echo json_encode($message);
    return;
}

?>