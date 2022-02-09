<?php
    $hostname = "localhost";
    $database = "konferentsiyi_1";
    $username = "root";
    $password = "";
    $bd_konferentsii = mysqli_connect($hostname, $username, $password, $database);
    mysqli_query($bd_konferentsii, "SET NAME utf8");
    mysqli_query($bd_konferentsii, "SET CHARACTER SET utf8");
    if (!$bd_konferentsii) {
        echo "Помилка підключення!" . PHP_EOL;
        exit;
    }
?>