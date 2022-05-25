<?

function createUser($login, $email, $password, $password_confirm) {
    $errors = [];

    if (strlen($login) < 5) {
        $errors[] = 'Логин меньше 5 символов';
    }

    if (strlen($password) < 8) {
        $errors[] = 'Пароль меньше 8 символов';
    }

    if (Authorization::checkLogin($login)) {
        $errors[] = 'Такой логин уже существует';
    }

    if ($password != $password_confirm) {
        $errors[] = 'Пароли не совпадают';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Недопустимый email';
    }

    if (!empty($errors)) {
        echo '<p>' . array_shift($errors) . '</p>';
        return;
    }

    $password = password_hash($password, PASSWORD_DEFAULT);
    $session = md5(random_int(1000, 9999) + time());

    $create_user = Authorization::createUser($login, $email, $password, $session, time());

    if (!$create_user) {
        echo '<p>Пользователь не создан</p>';
        return;
    }

    setcookie('login', $login, time()+60*60*24*30);
    setcookie('session', $session, time()+60*60*24*30);

    checkCookieSession($login, $session);

    echo '<p>Регистрация прошла успешно!</p>';
    header('Location: /');
}

function logUser($login, $password) {
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
        echo '<p>' . array_shift($errors) . '</p>';
        return;
    }

    $_SESSION['user'] = $user;

    setcookie('login', $_SESSION['user']['login'], time()+60*60*24*30);
    setcookie('session', $_SESSION['user']['session'], time()+60*60*24*30);

    echo '<p>Успешная авторизация</p>';
    header('Location: /');
}

function checkCookieSession($login, $session) {

    $session = Authorization::checkCookieSession($login, $session);

    if ($session) {
        $_SESSION['user'] = Authorization::getUser($login);
    }
}

?>