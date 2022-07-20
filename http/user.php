<?

$type = $_GET['type'];

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH') {

    if ($type === 'edit_passsword') {
        editPassword($user_data['user_id'], $_POST);
    }
    
    if ($type === 'personal_data') {
        editPersonalData($user_data['user_id'], $_POST);
    }
}

?>