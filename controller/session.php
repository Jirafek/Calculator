<?

session_start();

function sessionDeleteUser() {
    $_SESSION['user'] = null;
    setcookie('login', '', 0);
    setcookie('session', '', 0);

    $message = [
        'message' => 'Вы вышли из аккаунта',
        'status' => 'true'
    ];
    echo json_encode($message);
}

?>