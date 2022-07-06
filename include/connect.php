<?

$db_config = [
    'hostname' => '127.0.0.1',
    'username' => 'root',
    'password' => 'root',
    'database' => 'calendar_db'
];

// $db_config = [
//     'hostname' => 'localhost',
//     'username' => 'bssvety7_123',
//     'password' => 'qwerty123456!',
//     'database' => 'bssvety7_123'
// ];

$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if (!$mysqli) {
    die('Отсутсвует подключение к бд');
}

// https://oauth.vk.com/authorize?client_id=8176755&display=page&redirect_uri=https://bsspo.store/authorization&scope=friends&response_type=token&v=5.131&state=123456

// https://REDIRECT_URI#access_token=533bacf01e11f55b536a565b57531ad114461ae8736d6506a3&expires_in=86400&user_id=8492&state=123456
// https://api.vk.com/method/users.get?access_token=93cb90ec280f97beb4

// https://api.vk.com/method/users.get?user_ids=226935348&fields=bdate&expires_in=86400&state=123456&access_token=a28462c0bcd82de5818cfd34473ee07d185ca9b09e5aa825acd14f128f0e0ce3f5e83b5c73f1731296cd7&v=5.131

// https://bsspo.store/authorization&expires_in=86400&state=123456

// user_ids=226935348&fields=bdate&expires_in=86400&state=123456&access_token=a28462c0bcd82de5818cfd34473ee07d185ca9b09e5aa825acd14f128f0e0ce3f5e83b5c73f1731296cd7&v=5.131
// access_token=f697a1abd0333ac3d23a81c383a6605a926dc5d6d7e98148a54ae605a0bb96c6110287c03a6b9b3564bef&expires_in=86400&user_id=226935348&state=123456
?>