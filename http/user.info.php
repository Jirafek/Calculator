<?

$type = $_GET['type'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($id)) {
        getUserInfo($id);
    } else {
        if ($user_data) {
            getUserInfo($user_data['user_id']);
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
    if (!$type) {
        createUserInfo($_POST, $user_data['user_id']);
    }

    if ($type === 'edit_avatar') {
        editAvatar($user_data['user_id'], $_FILES);
    }
}

?>