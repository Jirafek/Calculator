<?

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    getEvents($user_data['user_id'], $user_data['group_id'], $where_param, $limit, $offset);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    createEvent($_POST, $user_data['user_id'], $user_data['group_id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH') {
    updateEvent($_POST, $id, $user_data['user_id'], $user_data['group_id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    deleteEvent($id, $user_data['user_id'], $user_data['group_id']);
}
?>