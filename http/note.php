<?

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    getNotes($_SESSION['user']['user_id'], $_SESSION['user']['group_id'], $where_param, $limit, $offset);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    createNote($_POST, $_SESSION['user']['user_id'], $_SESSION['user']['group_id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH') {
    updateNote($_POST, $id, $_SESSION['user']['user_id'], $_SESSION['user']['group_id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    deleteNote($id, $_SESSION['user']['user_id'], $_SESSION['user']['group_id']);
}
?>