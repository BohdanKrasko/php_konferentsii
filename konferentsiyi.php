<?php  include("logout.php"); ?>
<?php 
    if (!isset($_SESSION)) {
        session_start();
    }
    $MM_authorizedUsers = "user,admin";
    $MM_donotCheckaccess = false;

    function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
        $isValid = false;

        if (!empty($UserName)) {
            $arrUsers = Explode(",", $strUsers);
            $arrGroups = Explode(",", $strGroups);
            if (in_array($UserName, $arrUsers)) {
                $isValid = true;
            }
            if (in_array($UserGroup, $arrGroups)) {
                $isValid = true;
            }
            if (($strUsers == "") && false) {
                $isValid = true;
            }
        }
        return $isValid;
    }

    $MM_restrictGoTo = "index.php";
    if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
        $MM_qsChar = "?";
        $MM_referrer = $_SERVER['PHP_SELF'];
        if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
        if (isset($QUERY_STRING) && strlen(QUERY_STRING) > 0)
        $MM_referrer .= "?" . $QUERY_STRING;
        $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
        header("Location: ". $MM_restrictGoTo);
        exit;
    }
    if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
        $MM_qsChar = "?";
        $MM_referrer = $_SERVER['PHP_SELF'];
        if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
        if (isset($QUERY_STRING) && strlen(QUERY_STRING) > 0)
        $MM_referrer .= "?" . $QUERY_STRING;
        $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
        header("Location: ". $MM_restrictGoTo);
        exit;
    }
?>
<?php require_once('connections.php');?>
<?php 
    if ( (isset($_POST["form1"])) && ($_POST["form1"] == "form1")) {
        $data_pochatku = $_POST['data_pochatku'];
        $data_zakinchena = $_POST['data_zakinchena'];
        $query = "SELECT
            konferintsii.id_konferentsii,
            konferintsii.nazva_konferentsii,
            concat(spivrobitnuky.prizvyshche, ' ', LEFT(spivrobitnuky.imya, 1), '. ', LEFT(spivrobitnuky.pobatkovi, 1), '.') AS prizvyshche,
            DATE_FORMAT(konferintsii.data_pochatku, '%d.%m.%Y') AS data_pochatku,
            DATE_FORMAT(konferintsii.data_zakinchena, '%d.%m.%Y') AS data_zakinchena,
            (konferintsii.data_zakinchena-konferintsii.data_pochatku) AS truvalist,
            konferintsii.id_spivrobitnyka
        FROM
            konferintsii
        INNER JOIN
            spivrobitnuky ON konferintsii.id_spivrobitnyka = spivrobitnuky.id_spivrobitnyka
        WHERE
            konferintsii.data_pochatku >= '$data_pochatku' AND konferintsii.data_zakinchena <= '$data_zakinchena'";
        $result = mysqli_query($bd_konferentsii, $query);
    }
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="конференсії, ЗВО, вища освіта">
<meta name="description" content="Web-сайт обліку конференсій закладом вищої осівти">
<meta name="author" content="Красько Б.В.">
         <title>Конференсії</title>
         <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- bootstrap -->
</head>
<body>
    <?php
        include("header.php");
    ?>
    <?php
        include("nav.php");
    ?>
    
    <div class="container-fluid" style="min-height: 50vh">
        <div class="row"> 
            <div class="col-12 text-center"> 
                <h1 class="text-primary">Конференсії</h1>
            </div>
        </div>
        <div class="row"> 
            <div class="col-12"> 
                <form method="post" name="form1" class="form-inline my-2"> 
                    <div class="form-group mx-auto"> 
                        <div class="form-group"> 
                            <lable for="data_pochatku">з</lable>
                            <input type="date" class="form-control mx-2" name="data_pochatku" value="<?php echo $data_pochatku; ?>">
                        </div>
                        <div class="form-group"> 
                            <lable for="data_zakinchena">по</lable>
                            <input type="date" class="form-control mx-2" name="data_zakinchena" value="<?php echo $data_zakinchena; ?>">
                        </div>
                        <input type="hidden" name="form1" value="form1"/>
                        <button type="submit" class="btn btn-primary">Показати</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row"> 
            <div class="col-12"> 
                <div class="text-right"> 
                    <a href="konferentsiyi_add.php" class="btn btn-primary btn-sm my-2"> 
                        Додати конференцію
                    </a>
                </div>
                <div id="accordion1" role="tablist"> 
                    <?php 
                        if (isset($result)) {
                            $i=1;
                            while($row=mysqli_fetch_array($result)) {
                        
                    ?>
                    <div class="card"> 
                        <div class="btn btn-primary btn-sm" role="tab" id="headingTwo<?php echo $i;?>"> 
                            <h6 class="mb-0"> 
                                <a 
                                    class="collapsed btn btn-primary text-left container-fluid"
                                    data-toggle="collapse"
                                    href="#collapseTwo<?php echo $i;?>"
                                    role="button"
                                    aria-expanded="false"
                                    aria-controls="collapseTwo1"
                                > 
                                    <div class="row"> 
                                        <div class="col-8"> 
                                            Назва: <?php echo $row["id_konferentsii"]; ?>. <?php echo $row["nazva_konferentsii"]; ?>.
                                        </div>
                                        <div class="col-4"> 
                                            Відповідальний: <?php echo $row["prizvyshche"]; ?>.
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-4"> 
                                            Початок: <?php echo $row["data_pochatku"]; ?>.
                                        </div>
                                        <div class="col-4"> 
                                            Закінчення: <?php echo $row["data_zakinchena"]; ?>.
                                        </div>
                                        <div class="col-4"> 
                                            Тривалість: <?php echo $row["truvalist"]; ?> дн.
                                        </div>
                                    </div>
                                </a>
                                <a
                                    href="konferentsiyi_del.php?id_konferentsii=<?php echo $row["id_konferentsii"]; ?>"
                                    class="btn btn-danger btn-md" 
                                    data-toggle="tooltip" 
                                    title="Видалити" 
                                    onclick="return confirm('Ви впевнені, що хочете видалити запис?')"
                                > 
                                </a>
                                <a
                                    href="konferentsiyi_edit.php?id_konferentsii=<?php echo $row["id_konferentsii"]; ?>"
                                    class="btn btn-warning btn-md" 
                                    data-toggle="tooltip" 
                                    title="Редагувати"
                                > 
                                </a>
                            </h6>
                        </div>
                        <div 
                            id="collapseTwo<?php echo $i;?>" 
                            class="collapse" 
                            role="tabpanel"
                            aria-labelledby="headingTwo<?php echo $i;?>"
                            data-parent="#accordion1"
                        > 
                            <div class="card-body"> 
                                <a href="sektsii_add.php?id_konferentsii=<?php echo $row['id_konferentsii']; ?>&nazva_konferentsii=<?php echo $row['nazva_konferentsii']; ?>" 
                                    class="btn btn-primary btn-sm my-2" 
                                    title="Додати секцію">
                                </a>
                                <p class="text-center font-weight-bold"> Секції: </p>
                                <?php 
                                    if ( (isset($_POST["form1"])) && ($_POST["form1"] == "form1")) {
                                        $id_konf = $row["id_konferentsii"];
                                        $query2 = "SELECT
                                            id_sektsii,
                                            id_konferentsii,
                                            nazva_sektsii
                                        FROM
                                            sektsii
                                        WHERE
                                            id_konferentsii = '$id_konf'";
                                        $result2 = mysqli_query($bd_konferentsii, $query2);
                                    }
                                    if (isset($result2)) {
                                        while($row2=mysqli_fetch_array($result2)) {

                                ?>
                                <p class="text-white bg-info my-0"> <?php echo $row2["nazva_sektsii"]; ?> </p>
                                <div class="text-center mb-3"> 
                                    <a
                                        href="uchasnyky.php?id_sektsii=<?php echo $row2["id_sektsii"]; ?>
                                        &nazva_sektsii=<?php echo $row2["nazva_sektsii"]; ?>
                                        &nazva_konferentsii=<?php echo $row["nazva_konferentsii"]; ?>
                                        &spivrobitnyk=<?php echo $row["prizvyshche"]; ?>
                                        &data_p=<?php echo $row["data_pochatku"]; ?>
                                        &data_z=<?php echo $row["data_zakinchena"]; ?>"
                                        class="btn btn-success btn-sm" 
                                        data-toggle="tooltip" 
                                        title="Учасники"
                                    > 
                                    </a>    
                                    <a
                                        href="sektsii_del.php?id_sektsii=<?php echo $row2["id_sektsii"]; ?>"
                                        class="btn btn-danger btn-sm" 
                                        data-toggle="tooltip" 
                                        title="Видалити секцію" 
                                        onclick="return confirm('Ви впевнені, що хочете видалити запис?')"
                                    > 
                                    </a>
                                    <a
                                        href="sektsii_edit.php?id_sektsii=<?php echo $row2["id_sektsii"]; ?>&nazva_konferentsii=<?php echo $row['nazva_konferentsii']; ?>"
                                        class="btn btn-warning btn-sm" 
                                        data-toggle="tooltip" 
                                        title="Редагувати секцію"
                                    > 
                                    </a>
                                </div>
                                <?php 
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php 
                            $i=$i+1;
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php 
        include("footer.php")
    ?>   
<!-- bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<!-- bootstrap -->
</body>
</html>
