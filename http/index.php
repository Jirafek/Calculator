<?
require_once '../require.php';
require_once 'vars.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *, Authorization');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

if ($param[0] === 'authorization') {
    require_once 'authorization.php';
}

if ($param[0] === 'event') {
    require_once 'event.php';
}

if ($param[0] === 'group') {
    require_once 'group.php';
}

if ($param[0] === 'note') {
    require_once 'note.php';
}

if ($param[0] === 'user_info') {
    require_once 'user.info.php';
}

if ($param[0] === 'group_user') {
    require_once 'group.user.php';
}

// if ($param[0] === 'session') {
//     echo json_encode($_SESSION['user']);
// }
?>