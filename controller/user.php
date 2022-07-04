<?
function getUser($id) {
    if (empty($id)) {
        http_response_code(403);
        $errors[] = 'Отсутсвует авторизация';

        echo json_encode([
            'message' => 'Отсутсвует авторизация',
            'status' => false
        ]);
        return;
    }

    $user = Globals::getData('user', 'user_id', $id);
    array_splice($user, 1, -3);

    json_encode($user);
}

function editPassword($id, $data) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $password = $data['password'];

    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = User::editPassword($id, $password);

    $message = [
        'message' => 'Произошла ошибка',
        'status' => false
    ];

    if ($query) {
        http_response_code(200);
        $message = [
            'message' => 'Пароль успешно изменён',
            'status' => true
        ];

        echo json_encode($message);
        return;
    }

    html_entity_decode(401);
    echo json_encode($message);
    return;
}

function editPersonalData($id, $data) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $login = $data['login'];
    $email= $data['email'];
    $telephone = $data['telephone'];

    $login = protectionData($login);
    $email= protectionData($email);
    $telephone = protectionData($telephone);

    $query = User::edit($id, $login, $email, $telephone);

    $message = [
        'message' => 'Данные не были изменены',
        'status' => false
    ];

    if ($query) {
        $message = [
            'message' => 'Данные обновлены',
            'status' => true
        ];

        echo json_encode($message);
        return;
    }

    http_response_code(403);

    echo json_encode($message);
}
?>