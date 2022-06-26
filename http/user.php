<?
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //getUser($_SESSION['user']['user_id']);
    $input = array("user_id", "login", "email", "session", "213", "psuid", "321");
    array_splice($input, 1, -3);
    var_dump($input);
}
?>