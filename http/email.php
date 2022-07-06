<?

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($type === 'create_code') {
        EmailCode::create($_POST);
    }
}

?>