<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">
        <img src="favicon.ico">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSuportedContent1">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/konferentsiyi.php">
                    Конференсії <span class="sr-only">(current)</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Довідники
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                    <a class="dropdown-item" href="/kafedry.php">
                        Кафедри
                    </a>
                    <a class="dropdown-item" href="/mista_prozhuvania.php">
                        Місця проживання
                    </a>
                    <div class="dropdown-item"></div>
                    <a class="dropdown-item" href="/spivrobitnyky.php">
                        Співробітники
                    </a>
                </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Звіти
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                    <a class="dropdown-item" href="/konf_top.php" target="_blank">
                        Рейтинг конференсій
                    </a>
                    <a class="dropdown-item" href="/kafedry_top.php" target="_blank">
                        Рейтинг кафедр
                    </a>
                    <div class="dropdown-item"></div>
                    <a class="dropdown-item" href="/misce_top.php" target="_blank">
                        Рейтинг місць проживання
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php  echo $logoutAction ?>">
                    Вихід
                </a>
            </li>
        </ul>
    </div>
</nav>