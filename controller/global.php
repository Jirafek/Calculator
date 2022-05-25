<?

function protectionData($data) {
    return trim(htmlspecialchars(addslashes($data)));
}

?>