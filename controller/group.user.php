<?

function addGroupUser($code, $user_id) {
    $group = Globals::getData('group', 'code', $code);

    $errors = [];

    if (!$user_id) {
        http_response_code(401);

        $errors[] = 'Вы не авторизованы';
    }

    if (Globals::checkCount('group_user', 'user_id', $user_id) > 0) {
        $errors[] = 'Вы уже состоите в группе';
    }

    if (!$group) {
        $errors[] = 'Неверный код группы';
    }

    if ($group['is_private']) {
        $errors[] = 'Вы не можете присоединиться в эту группу';
    }

    if ($group['user_count'] >= $group['user_limit']) {
        $errors[] = 'В группе максимальное количество людей';
    }

    if (!empty($errors)) {
        $message = [
            'message' => array_shift($errors),
            'status' => false
        ];
        echo json_encode($message);
        return;
    }

    GroupUser::add($group['group_id'], $user_id, 1);
}

function deletUserInGroup($session_user_id, $group_id, $user_id) {
    $get_access = Globals::getData('group_user', 'user_id', $session_user_id)['user_access'];

    $errors = [];

    if (!$session_user_id) {
        http_response_code(401);

        $errors[] = 'Вы не авторизованы';
    }

    if ($get_access < 4) {
        http_response_code(403);

        $errors[] = 'У вас недостаточно прав';
    }

    if (!empty($errors)) {
        $message = [
            'message' => array_shift($errors),
            'status' => false
        ];
        echo json_encode($message);
        return;
    }

    $delete = GroupUser::delete($group_id, $user_id);

    if ($delete) {
        $message = [
            'message' => 'Пользователь удалён из группы',
            'status' => true
        ];
        echo json_encode($message);
        return;
    }

    $message = [
        'message' => 'Пользователь не был удалён из группы',
        'status' => false
    ];
    echo json_encode($message);
}

?>