<?
require_once '../require.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *, Authorization');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=utf-8');

$q = protectionData($_GET['q']);
$param = explode('/', $q);
$id = (int) $param[1];
$limit = (int) $_GET['limit'];
$offset = (int) $_GET['offset'];
$where_param = "";

foreach ($_GET as $req => $type) {
    if ($type === $q) {
        continue;
    }

    if ($type === $limit) {
        continue;
    }
    
    if ($type === $offset) {
        continue;
    }

    if ($type = 'event_id') {
        continue;
    }

    if ($type = 'group_id') {
        continue;
    }

    $req = protectionData($req);
    $type = protectionData($type);

    $where_param .= "AND `$req` = '$type' ";
}

$where_param = mb_substr($where_param, 0, -1);

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