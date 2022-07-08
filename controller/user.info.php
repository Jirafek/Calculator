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
    $data = UserInfo::get($user_id);

    if ($data) {
        echo json_encode($data);
        return;
    }

    http_response_code(404);

    $message = [
        'message' => 'Пользователь не найден',
        'status' => false
    ];

    echo json_encode($message);
}

// function updateUserInfo($data, $image, $user_id) {
//     $data = file_get_contents('php://input');
//     $data = json_decode($data, true);

//     $first_name = protectionData($data['first_name']);
//     $last_name = protectionData($data['last_name']);
//     $birthday = protectionData($data['birthday']);

    
// }

function editAvatar($user_id, $image) {
    $errors = [];

    if (!$user_id) {
        $errors[] = 'Нет авторизации';
    }

    if ($image['name'] !== '') {
        $errors[] = 'Нет картинки';
    }

    if ($image['type'] !== 'image/jpeg' && $image['type'] !== 'image/png' && $image['type'] !== "") {
        $errors[] = 'Не поддерживается формат картинки';
    }

    if (!empty($errors)) {
        http_response_code(400);

        $message = [
            'message' => array_shift($errors),
            'status' => false
        ];

        echo json_encode($message);
        return;
    }

    $path_img = '../img';
    $upload_img = random_int(10000, 99999) . time() . '.png';

    if (!move_uploaded_file($image['tmp_name'], $path_img . $upload_img)) {
        http_response_code(400);

        $message = [
            'message' => 'Изображение не загрузилось',
            'status' => false
        ];

        echo json_encode($message);
        return;
    }

    $edit_avatar = UserInfo::updateAvatar($user_id, $upload_img);

    if (!$edit_avatar) {
        http_response_code(400);

        $message = [
            'message' => 'Изображение не загрузилось',
            'status' => false
        ];

        echo json_encode($message);
        return;
    }

    http_response_code(201);

    $message = [
        'message' => 'Изображение обновлено',
        'status' => true
    ];

    echo json_encode($message);
    return;
}

?>