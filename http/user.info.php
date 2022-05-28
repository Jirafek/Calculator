<?

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($id)) {
        getUserInfo($id);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    createUserInfo($_POST, $_SESSION['user']['user_id']);
}

?>