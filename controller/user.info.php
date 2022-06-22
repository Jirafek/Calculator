<?

function createUserInfo($data, $user_id) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $first_name = protectionData($data['first_name']);
    $last_name = protectionData($data['last_name']);
    $birthday = protectionData($data['birthday']);

    UserInfo::create($first_name, $last_name, $birthday, $user_id);
}

function getUserInfo($user_id) {
    $data = UserInfo::getData('user_id', $user_id);

    if ($data) {
        echo json_encode($data);
        return;
    }

    http_response_code(404);

    $message = [
        'message' => 'Пользовател не найден',
        'status' => false
    ];

    echo json_encode($message);
}

function updateUserInfo($data, $image, $user_id) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $first_name = protectionData($data['first_name']);
    $last_name = protectionData($data['last_name']);
    $birthday = protectionData($data['birthday']);

    
}

?>