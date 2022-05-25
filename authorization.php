<?
require_once 'require.php';

checkCookieSession($_COOKIE['login'], $_COOKIE['session']);

if ($_SESSION['user']) {
    header('Location: /');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://yastatic.net/s3/passport-sdk/autofill/v1/sdk-suggest-with-polyfills-latest.js"></script>
    <title>Календарь</title>
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
                    <form class="authorization" action="#" method="POST">
                        <?
                            authorizationForm();
                        ?>
                        <button class="getData">
                            <!-- https://login.yandex.ru/info?format=json&jwt_secret=49c4ca67494641bab188436d3efe578e&oauth_token=AQAAAAARyWP8AAftwcgAxbV6LU8vl8QFG9Dd1Tk -->
                            <a class="authorization-yandex" href="https://oauth.yandex.ru/authorize?client_id=f3a489077b5443fc98ac80a538070717&response_type=token&redirect_uri=https://bsspo.store/authorization">
                                Войти
                            </a>
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script async src="js/script.js"></script>
    <script>
        const URL_BACKEND_TEST = 'https://bsspo.store';

        const authorizationYandex = document.querySelector('.authorization-yandex');

	    const token = /access_token=([^&]+)/.exec(document.location.hash)[1];

        if (token) {
            fetch(`https://login.yandex.ru/info?format=json&jwt_secret=49c4ca67494641bab188436d3efe578e&oauth_token=${token}`)
            .then(res => res.json())
            .then(res => {
                fetch(`${URL_BACKEND_TEST}/http/authorization.php`, {
                    method: 'POST',
                    body: JSON.stringify(res)
                })
            });
        }
    </script>
</body>
</html>