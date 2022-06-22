<?
function createEvent($data, $author_id, $group_id) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    if (Globals::getData('user', 'user_id', $author_id)['group_id']) {
        $get_access = Globals::getData('group_user', 'user_id', $author_id)['user_access'];
    } else {
        $get_access = 4;
    }
    
    $title = $data['title'];
    $description = $data['description'];
    $phone = $data['phone'];
    $color = $data['color'];
    $day = $data['day'];
    $month = $data['month'];
    $year = $data['year'];
    $time = $data['time'];
    $author_id = (int) $author_id;
    $group_id = $group_id ? (int) $group_id : '';

    $title = protectionData($title);
    $description = protectionData($description);
    $phone = protectionData($phone);
    $color = protectionData($color);
    $day = (int) $day;
    $month = (int) $month;
    $year = (int) $year;
    $time = protectionData($time);

    if (!$author_id) {
        http_response_code(401);

        $errors[] = 'Не пройдена авторизация';
    }

    if ($get_access < 3) {
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
        'message' => 'Событие создано',
        'status' => true
    ];

    $event = Event::createEvent($title, $description, $phone, $color, $day, $month, $year, $time, $author_id, $group_id);

    if (!$event) {
        $message = [
            'message' => 'Событие не добавлено',
            'status' => false,
        ];
        echo json_encode($message);
        return;
    }

    http_response_code(201);

    echo json_encode($message);
}

function getEvents($user_id, $group_id, $where_param, $limit, $offset) {
    $user_id = (int) $user_id;
    $group_id = $group_id ? (int) $group_id : '';

    $limit = $limit ? "LIMIT $limit" : "LIMIT 25";

    $offset = $offset ? "AND `event_id` > '$offset'" : " ";

    $events = Event::getEvents($user_id, $group_id, $where_param, $limit, $offset);

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

function updateEvent($data, $event_id, $author_id, $group_id) {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    
    $title = $data['title'];
    $description = $data['description'];
    $phone = $data['phone'];
    $color = $data['color'];
    $day = $data['day'];
    $month = $data['month'];
    $year = $data['year'];
    $time = $data['time'];
    $author_id = (int) $author_id;
    $group_id = $group_id ? (int) $group_id : '';

    $title = protectionData($title);
    $description = protectionData($description);
    $phone = protectionData($phone);
    $color = protectionData($color);
    $day = (int) $day;
    $month = (int) $month;
    $year = (int) $year;
    $time = protectionData($time);

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

    $event = Event::updateEvent($event_id, $title, $description, $phone, $color, $day, $month, $year, $time, $author_id, $group_id);

    if (!$event) {
        http_response_code(403);

        $message = [
            'message' => 'Вы не можете изменить данное событие',
            'status' => false,
        ];
        echo json_encode($message);
        return;
    }

    $message = [
        'message' => 'Событие изменено',
        'status' => true,
    ];
    echo json_encode($message);
}

function deleteEvent($event_id, $author_id, $group_id) {
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


    $delete = Event::deleteEvent($event_id, $author_id, $group_id);

    if (!$delete) {
        $message = [
            'message' => 'Событие не было удалено',
            'status' => false
        ];
        echo json_encode($message);
        return;
    }

    http_response_code(204);

    $message = [
        'message' => 'Событие удалено',
        'status' => true
    ];
    echo json_encode($message);
    return;
}
?>