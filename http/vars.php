<?

$q = protectionData($_GET['q']);

$param = explode('/', $q);

$id = (int) $param[1];
$limit = (int) $_GET['limit'];
$offset = (int) $_GET['offset'];
$code = protectionData($_GET['code']);

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

?>