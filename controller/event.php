<?
function createEvent($data, $author_id, $group_id) {
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
    $day = protectionData($day);
    $month = protectionData($month);
    $year = protectionData($year);
    $time = protectionData($time);

    http_response_code(201);

    // echo json_encode([
    //     'title' => "$title",
    //     'description' => "$description",
    //     'phone' => "$phone",
    //     'color' => "$color",
    //     'day' => "$day",
    //     'month' => "$month",
    //     'year' => " $year",
    //     'time' => "$time",
    //     'author_id' =>  "$author_id",
    //     'group_id' => "$group_id"
    // ]);

    $message = [
        'message' => 'Event created',
        'status' => 'true'
    ];

    $event = Event::createEvent($title, $description, $phone, $color, $day, $month, $year, $time, $author_id, $group_id);

    if (!$event) {
        $message = [
            'message' => 'Event was not created',
            'status' => 'false',
        ];
    }

    echo json_encode($message);
}

function getEvents($user_id, $group_id) {
    $user_id = (int) $user_id;
    $group_id = $group_id ? (int) $group_id : '';

    $events = Event::getEvents($user_id, $group_id);

    if ($events) {
        http_response_code(200);

        echo json_encode($events);
        return;
    }

    http_response_code(404);

    $message = [
        'message' => 'Events not found',
        'status' => 'false'
    ];

    echo json_encode($message);
}

function deleteEvent($event_id, $author_id, $group_id) {
    $event_id = file_get_contents('php://input');
    $event_id = json_decode($event_id, true);
    $event_id = (int) $event_id['event_id'];

    $delete = Event::deleteEvent($event_id, $author_id, $group_id);

    if (!$delete) {
        http_response_code(403);

        $message = [
            'message' => 'Event not deleted',
            'status' => 'false'
        ];
        echo json_encode($message);
        return;
    }

    http_response_code(204);
}
?>