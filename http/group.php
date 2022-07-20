<?

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!empty($id)) {
        getGroup($id);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    createGroup($_POST, $user_data['user_id']);
}

?>