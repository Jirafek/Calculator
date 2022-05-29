<?

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    getEvents($_SESSION['user']['user_id'], $_SESSION['user']['group_id'], $where_param, $limit, $offset);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    createEvent($_POST, $_SESSION['user']['user_id'], $_SESSION['user']['group_id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH') {
    updateEvent($_POST, $id, $_SESSION['user']['user_id'], $_SESSION['user']['group_id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    deleteEvent($id, $_SESSION['user']['user_id'], $_SESSION['user']['group_id']);
}
?>