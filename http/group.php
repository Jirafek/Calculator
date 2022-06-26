<?

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($id)) {
        getGroup($id);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    createGroup($_POST, $_SESSION['user']['user_id']);
}

?>