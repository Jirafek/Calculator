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
    <title>Профиль</title>
</head>
<body>
    <div class="wrapper">
        <header class="header">
            <div class="container">
                <div class="header__container">
                    <div class="header__logo">
                        <div class="header__logo_img">
                            <svg width="100%" height="100%" viewBox="0 0 144 144" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="144" height="144" fill="#C4C4C4"/>
                            </svg>                        
                        </div>
                        <h1 class="header__logo_h1">
                            Календарь
                        </h1>
                    </div>
                </div>
            </div>
        </header>
        <main class="main">
            <div class="container">
                <div class="main__container">
                    <div class="profile authorization">
                    <label for="profileLogin">Логин</label>
                    <input class="authorization__input" type="text" id="profileLogin" name="login" value="<?= $_SESSION['user']['login'] ?>">
                    <label for="profileEmail">Email</label>
                    <input class="authorization__input" type="email" id="profileEmail" name="email" value="<?= $_SESSION['user']['email'] ?>">
                    <label for="profileGroup">Группа</label>
                    <input class="authorization__input" type="email" id="profileGroup" name="group">
                    <label for="profilePassword">Поменять пароль</label>
                    <input class="authorization__input" type="password" id="profilePassword" name="password">
                    <label for="profilePasswordConfirm">Введите пароль, чтобы подтвердить изменения</label>
                    <input class="authorization__input" type="password" id="profilePasswordConfirm" name="password_confirm">
                    <div class="profile__buttons">
                        <button class="authorization__button" name="save_profile">
                            Сохранить
                        </button>
                        <button class="authorization__button" name="save_profile">
                            Выйти из аккаунта
                        </button>
                    </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script async src="js/script.js"></script>
</body>
</html>