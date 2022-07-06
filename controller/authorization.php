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
            'status' => false
        ];

        echo json_encode($message);
        return;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $session = md5(random_int(1000, 9999) + time());

    $create_user = Authorization::createUser($login, $email, $password, $session, time());

    if (!$create_user) {
        $message = [
            'message' => 'Пользователь не создан',
            'status' => false
        ];
    
        echo json_encode($message);
        return;
    }

    $message = [
        'message' => 'Регистрация прошла успешно!',
        'status' => true,
        'login' => $login,
        'session' => $session
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
        http_response_code(404);

        $message = [
            'message' => array_shift($errors),
            'status' => false
        ];

        echo json_encode($message);
        return;
    }

    $_SESSION['user'] = $user;

    $message = [
        'message' => 'Успешная авторизация!',
        'status' => true,
        'login' => $_SESSION['user']['login'],
        'session' => $_SESSION['user']['session']
    ];

    echo json_encode($message);
}

function updateUser($data, $user_id) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $login = protectionData($data['login']);
    $email = protectionData($data['email']);
    $password = protectionData($data['password']);

    if (!$user_id) {
        http_response_code(404);

        $message = [
            'message' => 'Сессии не существует',
            'status' => false
        ];

        echo json_encode($message);
        return;
    }

    if (!empty($errors)) {
        $message = [
            'message' => array_shift($errors),
            'status' => false
        ];

        echo json_encode($message);
        return;
    }

    $query = updateUser($login, $email, $password, $user_id);

    if (!$query) {
        $message = [
            'message' => 'Произошла ошибка',
            'status' => false
        ];

        echo json_encode($message);
        return;
    }

    $_SESSION['user'] = Globals::getData('user', 'user_id', $user_id);
}

function checkCookieSession($data) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $login = protectionData($data['login']);
    $session = protectionData($data['session']);

    $session = Authorization::checkCookieSession($login, $session);

    if (!$session) {
        http_response_code(400);

        $message = [
            'message' => 'Сессии не существует',
            'status' => false,
        ];

        echo json_encode($message);
        return;
    }

    $_SESSION['user'] = Authorization::getUser($login);

    $message = [
        'message' => 'Успешная авторизация',
        'status' => true
    ];

    echo json_encode($message);
    return;
}

?>