<?

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    addGroupUser($code, $_SESSION['user']['user_id']);
}

?>