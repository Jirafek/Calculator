<?
function createNote($data, $author_id, $group_id) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    $get_access = Globals::getData('group_user', 'user_id', $author_id)['user_access'];
    
    $title = $data['title'];
    $description = $data['description'];
    $phone = $data['phone'];
    $color = $data['color'];
    $day = $data['day'];
    $month = $data['month'];
    $year = $data['year'];
    $author_id = (int) $author_id;
    $group_id = $group_id ? (int) $group_id : '';

    $title = protectionData($title);
    $description = protectionData($description);
    $phone = protectionData($phone);
    $color = protectionData($color);
    $day = (int) $day;
    $month = (int) $month;
    $year = (int) $year;

    if ($group_id) {
        $group = Globals::getData('group', 'group_id', $group_id);

        if ($group['note_limit'] >= $group['note_count']) {
            http_response_code(400);

            $errors[] = 'Достигнут лимит создания записей';
        }
    } else {
        $user = Globals::checkCount('note', 'author_id', $author_id);

        if ($user >= 4) {
            http_response_code(400);

            $errors[] = 'Достигнут лимит создания записей';
        }
    }

    if (!$author_id) {
        http_response_code(401);

        $errors[] = 'Не пройдена авторизация';
    }

    if ($get_access < 2) {
        http_response_code(403);

        $errors[] = 'Нет доступа';
    }

    if (!empty($errors)) {
        $message = [
            'message' => array_shift($errors),
            'status' => false
        ];
        echo json_encode($message);
        return;
    }

    $message = [
        'message' => 'Запись создана',
        'status' => true
    ];

    $event = Note::create($title, $description, $phone, $color, $day, $month, $year, $author_id, $group_id);

    if (!$event) {
        $message = [
            'message' => 'Запись не добавлена',
            'status' => false,
        ];
        echo json_encode($message);
        return;
    }

    http_response_code(201);

    echo json_encode($message);
}

function getNotes($user_id, $group_id, $where_param, $limit, $offset) {
    $user_id = (int) $user_id;
    $group_id = $group_id ? (int) $group_id : '';

    $limit = $limit ? "LIMIT $limit" : "LIMIT 25";

    $offset = $offset ? "AND `event_id` > '$offset'" : " ";

    $events = Note::get($user_id, $group_id, $where_param, $limit, $offset);

    if ($events) {
        http_response_code(200);

        echo json_encode($events);
        return;
    }

    http_response_code(404);

    $message = [
        'message' => 'События не найдены',
        'status' => false
    ];

    echo json_encode($message);
}

function updateNote($data, $note_id, $author_id, $group_id) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    
    $title = $data['title'];
    $description = $data['description'];
    $phone = $data['phone'];
    $color = $data['color'];
    $day = $data['day'];
    $month = $data['month'];
    $year = $data['year'];
    $author_id = (int) $author_id;
    $group_id = $group_id ? (int) $group_id : '';

    $title = protectionData($title);
    $description = protectionData($description);
    $phone = protectionData($phone);
    $color = protectionData($color);
    $day = (int) $day;
    $month = (int) $month;
    $year = (int) $year;

    if (!$author_id) {
        http_response_code(401);

        $errors[] = 'Не пройдена авторизация';
    }

    if (!empty($errors)) {
        $message = [
            'message' => array_shift($errors),
            'status' => false
        ];
        echo json_encode($message);
        return;
    }

    $note = Note::update($note_id, $title, $description, $phone, $color, $day, $month, $year, $author_id, $group_id);

    if (!$note) {
        http_response_code(403);

        $message = [
            'message' => 'Вы не можете изменить данную запись',
            'status' => false,
        ];
        echo json_encode($message);
        return;
    }

    $message = [
        'message' => 'Запись изменена',
        'status' => true,
    ];
    echo json_encode($message);
}

function deleteNote($note_id, $author_id, $group_id) {
    $errors = [];

    if (!$author_id) {
        http_response_code(401);

        $errors[] = 'Не пройдена авторизация';
    }

    if (!empty($errors)) {
        $message = [
            'message' => array_shift($errors),
            'status' => false
        ];
        echo json_encode($message);
        return;
    }


    $delete = Note::delete($note_id, $author_id, $group_id);

    if (!$delete) {
        $message = [
            'message' => 'Запись не была удалена',
            'status' => false
        ];
        echo json_encode($message);
        return;
    }

    http_response_code(204);

    $message = [
        'message' => 'Запись удалена',
        'status' => true
    ];
    echo json_encode($message);
    return;
}
?>