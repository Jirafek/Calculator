<?

function authorizationForm() {
    $login = protectionData($_REQUEST['login']);
    $email = protectionData($_REQUEST['email']);
    $password = protectionData($_REQUEST['password']);
    $password_confirm = protectionData($_REQUEST['password_confirm']);

    if (isset($_POST['do_registration'])) {
        createUser($login, $email, $password, $password_confirm);
    }

    if (isset($_POST['do_login'])) {
        logUser($login, $password);
    }

    if (isset($_POST['transition_registration'])) {
        $_SESSION['authorization']['registration'] = true;
    }

    if (isset($_POST['transition_login'])) {
        $_SESSION['authorization']['registration'] = false;
    }

    if ($_SESSION['authorization']['registration']) {
        echo '
        <label for="registrationLogin">Логин</label>
        <input class="authorization__input" type="text" id="registrationLogin" name="login">
        <label for="registrationEmail">Email</label>
        <input class="authorization__input" type="email" id="registrationEmail" name="email">
        <label for="registrationPassword">Пароль</label>
        <input class="authorization__input" type="password" id="registrationPassword" name="password">
        <label for="registrationPasswordConfirm">Подтвердите пароль</label>
        <input class="authorization__input" type="password" id="registrationPasswordConfirm" name="password_confirm">
        <div class="authorization__buttons">
            <button class="authorization__button" name="do_registration">
                Зарегистрироваться
            </button>
            <button class="authorization__button" name="transition_login">
                Войти
            </button>
        </div>';
    } else {
        echo '<label for="authorizationLogin">Логин</label>
        <input class="authorization__input" type="text" id="authorizationLogin" name="login">
        <label for="authorizationPassword">Пароль</label>
        <input class="authorization__input" type="password" id="authorizationPassword" name="password">
        <div class="authorization__buttons">
            <button class="authorization__button" name="do_login">
                Войти
            </button>
            <a href="?registration">
                <button class="authorization__button" name="transition_registration">
                    Зарегистрироваться
                </button>
            </a>
        </div>';
    }
}

?>