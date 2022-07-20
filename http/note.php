<?

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    getNotes($user_data['user_id'], $user_data['group_id'], $where_param, $limit, $offset);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    createNote($_POST, $user_data['user_id'], $user_data['group_id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH') {
    updateNote($_POST, $id, $user_data['user_id'], $user_data['group_id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    deleteNote($id, $user_data['user_id'], $user_data['group_id']);
}
?>