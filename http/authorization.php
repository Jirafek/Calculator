<?
require_once '../require.php';

$session = protectionData($_COOKIE['session']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    AuthorizationHttp::createUser($_POST, $session);
}

?>