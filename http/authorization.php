<?

$type = $_GET['type'];

$session = protectionData($_COOKIE['session']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($type == "registration") {
        createUser($_POST);    
    }

    if ($type === "log") {
        logUser($_POST);
    }

    if ($type === "social") {
        AuthorizationSocial::createUser($_POST, $session);
    }

    if ($type === "session") {
        checkCookieSession($_COOKIE['login'], $_COOKIE['session']);
    }

    if ($type === 'exit') {
        sessionDeleteUser();
    }
}

?>