<?

function createGroup($data, $user_id) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $group_name = protectionData($data['group_name']);

    $link = md5(time() . random_int(1000, 9999));
    $code = substr(md5(time() . random_int(1000, 9999)), 6, 6);

    $errors = [];

    if (!$user_id) {
        http_response_code(403);
        $errors[] = 'Не пройдена авторизация';
    }

    if (strlen($group_name) < 4) {
        $errors[] = 'Название группы меньше 4 символов';
    }

    if (Globals::checkCount('group_user', 'user_id', $user_id) > 0) {
        $errors[] = 'Вы уже состоите в группе';
    }

    if (Globals::checkCount('group', 'group_name', $group_name) > 0) {
        $errors[] = 'Название группы уже существует';
    }

    if (!empty($errors)) {
        $message = [
            'message' => array_shift($errors),
            'status' => 'false'
        ];

        echo json_encode($message);
        return;
    }

    $group = Group::createGroup($group_name, $user_id, $link, $code);

    if ($group) {
        http_response_code(201);

        $message = [
            'message' => 'Группа создана',
            'status' => 'true'
        ];

        echo json_encode($message);
        return;
    }
}

// function addUser($group_id, $user_id, $user_access) {
    
// }

function joinLink($user_id, $link) {
    $group = Globals::getData('group', 'link', $link);

    if ($group['is_private']) {
        $errors[] = 'Вы не сможете присоединиться к этой группе';
    }

    if (Globals::checkCount('group_user', 'user_id', $user_id) > 0) {
        $errors[] = 'Вы уже состоите в группе';
    }

    if (!empty($errors)) {
        $message = [
            'message' => array_shift($errors),
            'status' => 'false'
        ];

        echo json_encode($message);
        return;
    }

    GroupUser::addUser($group['group_id'], $user_id, 1);
}

?>