<?
function getUser($id) {
    if (empty($id)) {
        http_response_code(403);
        $errors[] = 'Отсутсвует авторизация';

        echo json_encode([
            'message' => 'Отсутсвует авторизация',
            'status' => false
        ]);
        return;
    }

    $user = Globals::getData('user', 'user_id', $id);
    array_splice($user, 1, -3);

    json_encode($user);
}
?>