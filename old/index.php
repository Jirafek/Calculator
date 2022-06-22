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
<div class="wrapper calendar">
<div class="calendar__inner">
        <div class="overlay"></div>

        <header class="header calendar__header">
            <div class="squere grey"></div>
            <p class="header-name">Календарь</p>
            <div class="header-menu">
                <button class="menu_today d-h grey">Сегодня</button>
                <div class="menu_day d-h grey"></div>
                <div class="menu_number d-h grey"></div>
                <div class="menu_full d-h grey"></div>
                <button class="menu_searching-btn grey">
                    <svg width="95%" height="95%" viewBox="0 0 77 74" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M75.6771 66.7959L62.995 54.5784C67.7617 48.6803 70.3419 41.4762 70.3419 33.893C70.3419 24.8352 66.6685 16.3251 60.0213 9.92143C46.3334 -3.30715 23.9867 -3.30715 10.2987 9.92143C-3.43291 23.15 -3.43291 44.6359 10.2987 57.8224C16.9459 64.226 25.7796 67.7649 35.1819 67.7649C43.141 67.7649 50.7065 65.195 56.8289 60.5608L69.511 72.7783C70.3856 73.6208 71.4789 74 72.6159 74C73.753 74 74.8462 73.5787 75.7209 72.7783C77.4264 71.1352 77.4264 68.4811 75.7209 66.838L75.6771 66.7959ZM16.4649 51.8822C6.14426 41.9397 6.14426 25.8041 16.4649 15.9038C21.6252 10.9325 28.4035 8.4469 35.1381 8.4469C41.8728 8.4469 48.6511 10.9325 53.8114 15.9038C58.9717 20.875 61.5519 27.1102 61.5519 33.893C61.5519 40.6758 58.7968 47.0794 53.8114 51.8822C48.8261 56.6849 42.1789 59.339 35.1381 59.339C28.0974 59.339 21.4502 56.6849 16.4649 51.8822Z" fill="#900AB1"></path>
                    </svg>
                </button>
            </div>
            <a href="profile">Профиль</a>
        </header>

        <div class="arrows">
            <i class="arrow_left"></i>
            <i class="arrow_right"></i>
        </div>
        <div class="modal_window"></div>
        <div class="modal_calendar"></div>

        <main class="main">
            <div class="high_menu">
                <div class="day_name"></div>
                <div class="high_menu-state"></div>
            </div>
            <hr class="main-hr">
            <div class="low_menu">
                <div class="time-state"></div>
                <div class="low_menu-state"></div>
                <div class="time-block"></div>
            </div>
        </main>

    </div>
</div>
    <script async src="js/script.js"></script>
</body>
</html>