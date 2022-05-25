<?

function createGroup($group_name, $user_id) {
    $link = md5(time() . random_int(1000, 9999));
    $code = substr(md5(time() . random_int(1000, 9999)), 6, 6);

    $group = Group::createGroup($group_name, $user_id, $link, $code);

    if ($group) {
        $group_id = Group::getGroupData($link, $code)['group_id'];
        addUser($group_id, $user_id);
        addAdmin($group_id, $user_id);
    }
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