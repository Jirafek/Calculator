<?
require_once '../require.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *, Authorization');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

$q = protectionData($_GET['q']);
$param = explode('/', $q);
$id = (integer) $param[1];

if ($param[0] === 'authorization') {
    require_once 'authorization.php';
}

if ($param[0] === 'event') {
    require_once 'event.php';
}

if ($param[0] === 'group') {
    require_once 'group.php';
}

if ($param[0] === 'user_info') {
    require_once 'user.info.php';
}
?>