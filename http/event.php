<?

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    getEvents($_SESSION['user']['user_id'], $_SESSION['user']['group_id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    createEvent($_POST, $_SESSION['user']['user_id'], $_SESSION['user']['group_id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    deleteEvent($_POST, $_SESSION['user']['user_id'], $_SESSION['user']['group_id']);
}
?>