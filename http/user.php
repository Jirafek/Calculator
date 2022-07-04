<?

$type = $_GET['type'];

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH') {
    if ($type === 'password') {
        editPassword($_SESSION['user']['user_id'], $_POST);
    }
    
    if ($type === 'personal_data') {
        editPersonalData($_SESSION['user']['user_id'], $_POST);
    }
}

?>