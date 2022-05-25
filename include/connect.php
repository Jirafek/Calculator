<?

// $db_config = [
//     'hostname' => '127.0.0.1',
//     'username' => 'root',
//     'password' => 'root',
//     'database' => 'calendar_db'
// ];

$db_config = [
    'hostname' => 'localhost',
    'username' => 'bssvety7_123',
    'password' => 'qwerty123456!',
    'database' => 'bssvety7_123'
];

$mysqli = new mysqli($db_config['hostname'], $db_config['username'], $db_config['password'], $db_config['database']);

if (!$mysqli) {
    die('Отсутсвует подключение к бд');
}

?>