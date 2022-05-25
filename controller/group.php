<?
require_once '../require.php';

function createGroup($user_id) {
    $link = checkDate('link');
    $code = substr(checkDate('code'), 6, 6);

    $group = Group::createGroup($user_id, $link, $code);

    if ($group) {
        $group_id = Group::getGroupData($link, $code)['group_id'];
        addUser($group_id, $user_id);
        addAdmin($group_id, $user_id);
    }
}

function checkDate($column) {
    $random = md5(time() . random_int(1000, 9999));

    for ($i = 0; $i < 1000; $i++) {
        $check = Group::checkData($column, $random);
        $random = md5(time() . random_int(1000, 9999));

        if (!$check) {
            break;
        }
    }

    return $random;
}

function addUser($group_id, $user_id) {
    if (GroupAdmin::checkAdmin($group_id, $user_id)) {
        GroupUser::addUser($group_id, $user_id);
    }
}

function addAdmin($group_id, $user_id) {
    if (GroupAdmin::checkAdmin($group_id, $user_id)) {
        GroupAdmin::addAdmin($group_id, $user_id);
    }
}

?>