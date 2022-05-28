<?
require_once 'require.php';

$link = protectionData($_GET['link']);

joinLink($_SESSION['user']['user_id'], $link);

// if ($_SESSION['user']['user_id']) {

// } else {
//     echo '<script>alert("Авторизуйтесь, чтобы принять приглашение")</script>';
// }
?>

