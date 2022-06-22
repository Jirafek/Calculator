<?
require_once 'require.php';

if (!$_SESSION['user']) {
    header('Location: authorization');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Календарь</title>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="container">
                <div class="header__container">
                </div>
            </div>
        </header>
        <main class="main">
        <div class="main__container">
        </div>
        </main>
    </div>
    <script async src="js/script.js"></script>
</body>
</html>