<?

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($id)) {
        getUserInfo($id);
    } else {
        if ($_SESSION['user']) {
            getUserInfo($_SESSION['user']['user_id']);
        } else {
            http_response_code(403);

            $message = [
                'message' => 'Нет авторизации',
                'status' => false
            ];

            echo json_encode($message);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    createUserInfo($_POST, $_SESSION['user']['user_id']);
}

?>