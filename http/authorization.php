<?
require_once '../require.php';

$session = protectionData($_COOKIE['session']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    AuthorizationHttpYandex::createUser($_POST, $session);
}

?>