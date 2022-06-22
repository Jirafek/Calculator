<?
require_once 'require.php';

// checkCookieSession($_COOKIE['login'], $_COOKIE['session']);

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
    <title>Вход</title>
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
                        <!-- https://login.yandex.ru/info?format=json&jwt_secret=49c4ca67494641bab188436d3efe578e&oauth_token=AQAAAAARyWP8AAftwcgAxbV6LU8vl8QFG9Dd1Tk -->
                        <a class="authorization__href" href="https://oauth.yandex.ru/authorize?client_id=f3a489077b5443fc98ac80a538070717&response_type=token&redirect_uri=https://bsspo.store/authorization">
                            Войти через Яндекс
                        </a>
                        <a class="authorization__href" href="https://oauth.vk.com/authorize?client_id=8176755&display=page&redirect_uri=https://bsspo.store/authorization&scope=friends&response_type=token&v=5.131&state=123456">
                            Войти через Вконтакте
                        </a>
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
        const expires_in = /expires_in=([^&]+)/.exec(document.location.hash)[1];
        const user_id = /user_id=([^&]+)/.exec(document.location.hash)[1];
        const state = /state=([^&]+)/.exec(document.location.hash)[1];

        if (token && !expires_in) {
            fetch(`https://login.yandex.ru/info?format=json&jwt_secret=49c4ca67494641bab188436d3efe578e&oauth_token=${token}`)
            .then(res => res.json())
            .then(res => {
                fetch(`${URL_BACKEND_TEST}/http/authorization.php`, {
                    method: 'POST',
                    body: JSON.stringify(res)
                })
                .then(res => {
                    location.reload();
                })
            })
            
        }

        if (expires_in) {
            fetch(`https://api.vk.com/method/users.get?user_ids=${user_id}&fields=bdate&expires_in=${expires_in}&state=${state}&access_token=${token}&v=5.131`)
                .then(res => res.json())
                .then(res => {
                    fetch(`${URL_BACKEND_TEST}/http/authorization.php`, {
                        method: 'POST',
                        body: JSON.stringify(res)
                    })
                    .then(res => {
                        location.reload();
                    })
                })
        }
    </script>
</body>
</html>