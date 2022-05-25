<?

session_start();

function sessionDeleteUser() {
    $_SESSION['user'] = null;
    setcookie('login', '', 0);
    setcookie('session', '', 0);
}

?>