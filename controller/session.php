<?

session_start();

function sessionDeleteUser() {
    $_SESSION['user'] = null;
}

?>