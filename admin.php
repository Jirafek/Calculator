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
                    <div class="header__top">
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
                        <a class="header__href" href="profile">
                            Профиль
                        </a>
                    </div>
                    <div class="header__date">
                        <div class="header__today">
                            Сегодня
                        </div>
                        <div class="header__week">
                            пн
                        </div>
                        <div class="header__day">
                            17
                        </div>
                        <div class="header__month-year">
                            Апрель 2022
                        </div>
                        <div class="header__input">
                            <input placeholder="Поиск даты" type="text">
                        </div>
                        <div class="header__search_img">
                            <svg width="100%" height="100%" viewBox="0 0 77 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M75.6771 66.7959L62.995 54.5784C67.7617 48.6803 70.3419 41.4762 70.3419 33.893C70.3419 24.8352 66.6685 16.3251 60.0213 9.92143C46.3334 -3.30715 23.9867 -3.30715 10.2987 9.92143C-3.43291 23.15 -3.43291 44.6359 10.2987 57.8224C16.9459 64.226 25.7796 67.7649 35.1819 67.7649C43.141 67.7649 50.7065 65.195 56.8289 60.5608L69.511 72.7783C70.3856 73.6208 71.4789 74 72.6159 74C73.753 74 74.8462 73.5787 75.7209 72.7783C77.4264 71.1352 77.4264 68.4811 75.7209 66.838L75.6771 66.7959ZM16.4649 51.8822C6.14426 41.9397 6.14426 25.8041 16.4649 15.9038C21.6252 10.9325 28.4035 8.4469 35.1381 8.4469C41.8728 8.4469 48.6511 10.9325 53.8114 15.9038C58.9717 20.875 61.5519 27.1102 61.5519 33.893C61.5519 40.6758 58.7968 47.0794 53.8114 51.8822C48.8261 56.6849 42.1789 59.339 35.1381 59.339C28.0974 59.339 21.4502 56.6849 16.4649 51.8822Z" fill="#900AB1"/>
                            </svg>                                
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main class="main">
        <div class="main__container">
                <div class="event-modal _invisibility">
                    <form class="event-add" method="POST">
                        <date class="event-add__date">
                            <div class="event-add__week">
                                ПН
                            </div>
                            <div class="event-add__day">
                                17
                            </div>
                            <div class="event-add__month-year">
                                Апрель 2022
                            </div>
                        </date>
                        <div class="event-add__short-form">
                            <div class="event-add__title">
                                <input type="text" placeholder="Добавьте название">
                            </div>
                            <div class="event-add__time">11:00</div>
                            <div class="event-add__phone">
                                <input type="text" placeholder="+7">
                            </div>
                        </div>
                        <ul class="event-add__colours">
                            <li class="event-add__colour" style="--colour-code: #498263;"></li>
                            <li class="event-add__colour" style="--colour-code: #1E4EC8;"></li>
                            <li class="event-add__colour" style="--colour-code: #CF5E1E;"></li>
                            <li class="event-add__colour" style="--colour-code: #C80808;"></li>
                            <li class="event-add__colour" style="--colour-code: #CFC818;"></li>
                            <li class="event-add__colour" style="--colour-code: #720D0D;"></li>
                            <li class="event-add__colour" style="--colour-code: #B21BBF;"></li>
                            <li class="event-add__colour" style="--colour-code: #1CD4A8;"></li>
                        </ul>
                        <div class="event-add__descrption">
                            <textarea placeholder="Добавьте Описание"></textarea>
                        </div>
                        <div class="event-add__buttons">
                            <button class="event-add__button event-add__button-cancel">
                                Отменить
                            </button>
                            <button class="event-add__button event-add__button-save" type="submit">
                                Сохранить
                            </button>
                            <button class="event-add__button" type="reset">
                                Очистить
                            </button>
                            <button class="event-add__button event-add__button-delete" type="submit">
                                Удалить
                            </button>
                        </div>
                    </form>
                </div>
                    <div class="main__left-arrow"></div>
                    <div class="container">
                        <div class="calendar">
                            <div class="calendar__title">
                                Май 2022
                            </div>
                            <div class="calendar__days">
                                <div class="calendar__days_week">
                                    пн
                                </div>
                                <div class="calendar__day">
                                    17
                                </div>
                            </div>
                            <div class="calendar__days">
                                <div class="calendar__days_week">
                                    вт
                                </div>
                                <div class="calendar__day">
                                    18
                                </div>
                            </div>
                            <div class="calendar__days">
                                <div class="calendar__days_week">
                                    ср
                                </div>
                                <div class="calendar__day">
                                    19
                                </div>
                            </div>
                            <div class="calendar__days">
                                <div class="calendar__days_week">
                                    чт
                                </div>
                                <div class="calendar__day">
                                    20
                                </div>
                            </div>
                            <div class="calendar__days">
                                <div class="calendar__days_week">
                                    пт
                                </div>
                                <div class="calendar__day">
                                    21
                                </div>
                            </div>
                            <div class="calendar__days">
                                <div class="calendar__days_week">
                                    сб
                                </div>
                                <div class="calendar__day">
                                    22
                                </div>
                            </div>
                            <div class="calendar__days">
                                <div class="calendar__days_week">
                                    вс
                                </div>
                                <div class="calendar__day">
                                    23
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main__right-arrow"></div>
                </div>
        </main>
    </div>
    <script async src="js/script.js"></script>
</body>
</html>