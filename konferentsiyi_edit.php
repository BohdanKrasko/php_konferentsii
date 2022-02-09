<?php  include("logout.php"); ?>
<?php 
    require_once('connections.php');
    if (!isset($_SESSION)) {
        session_start();
    }
    $MM_authorizedUsers = "admin";
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

    $MM_restrictGoTo = "konferentsiyi.php";
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
    
    if (!isset($_POST["MM_insert"])) {
        $query1 = "SELECT 
            id_spivrobitnyka, 
            concat(spivrobitnuky.prizvyshche, ' ', LEFT(spivrobitnuky.imya, 1), '. ', LEFT(spivrobitnuky.pobatkovi, 1), '.') AS prizvyshche  
        FROM 
            spivrobitnuky
        ORDER BY id_spivrobitnyka";
        $result_s = mysqli_query($bd_konferentsii, $query1);

        $id_konferentsii = $_GET['id_konferentsii'];
        $query2 = "SELECT 
                id_konferentsii,
                id_spivrobitnyka, 
                nazva_konferentsii, 
                data_pochatku,
                data_zakinchena 
            FROM 
                konferintsii
            WHERE `id_konferentsii` = '$id_konferentsii'";
        $result2 = mysqli_query($bd_konferentsii, $query2);
        $row = mysqli_fetch_array($result2);
    } 

    if ( (isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
        $id_konferentsii = $_POST['id_konferentsii'];
        $id_spivrobitnyka = $_POST['id_spivrobitnyka'];
        $nazva_konferentsii = $_POST['nazva_konferentsii'];
        $data_pochatku = $_POST['data_pochatku'];
        $data_zakinchena = $_POST['data_zakinchena'];
        $query3 = "UPDATE 
            `konferintsii` 
        SET 
            `id_spivrobitnyka` = '$id_spivrobitnyka', 
            `nazva_konferentsii` = '$nazva_konferentsii', 
            `data_pochatku` = '$data_pochatku', 
            `data_zakinchena` = '$data_zakinchena'
        WHERE
            `id_konferentsii` = '$id_konferentsii'";
        $result = mysqli_query($bd_konferentsii, $query3);
        header("Location: konferentsiyi.php");
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
         <title>Співробітники</title>
         <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <!-- bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- bootstrap -->
</head>
<body>
    <?php 
        include("header.php")
    ?>
    <?php 
        include("nav.php")
    ?>
    
    <div class="container-fluid" style="min-height: 50vh">
        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center mx-auto"> 
                <h2 class="text-primary">Конференсії 
                    &#8220;<?php echo $row["nazva_konferentsii"];?>&#8221;
                    <br> (редагування) 
                </h2>
                <form method="post" name="from1"> 
                    <div class="form-group"> 
                        <label for="id_spivrobitnyka">Кафедра</label>
                        <input 
                            list="id"
                            class="form-control" 
                            name="id_spivrobitnyka" 
                            placeholder="Виберіть відповідального"
                            autocomplete="off"
                            value="<?php echo $row['id_spivrobitnyka']; ?>"
                        >
                        <datalist id="id"> 
                            <?php 
                                while ($row_k=mysqli_fetch_array($result_s)) {
                            ?>
                            <option value="<?php echo $row_k['id_spivrobitnyka']; ?>">
                                <?php echo $row_k["prizvyshche"]; ?>
                            </option>
                            <?php 
                                } 
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group"> 
                        <label for="nazva_konferentsii">Назва конференсії</label>
                        <input type="text" class="form-control" name="nazva_konferentsii" placeholder="Ведіть назву" value="<?php echo $row["nazva_konferentsii"]; ?>">
                    </div>
                    <div class="form-group"> 
                        <label for="data_pochatku">Дата початку</label>
                        <input 
                            type="date" 
                            class="form-control" 
                            name="data_pochatku" 
                            placeholder="дд.мм.гггг" 
                            value="<?php  echo $row['data_pochatku']; ?>"
                        >
                    </div>
                    <div class="form-group"> 
                        <label for="data_zakinchena">Дата закінчення</label>
                        <input
                            type="date" 
                            class="form-control" 
                            name="data_zakinchena" 
                            placeholder="дд.мм.гггг" 
                            value="<?php  echo $row['data_zakinchena']; ?>"
                        >
                    </div>
                    <input type="hidden" name="MM_insert" value="form1" />
                    <input type="hidden" name="id_konferentsii" value="<?php  echo $row['id_konferentsii']; ?>" />
                    <button type="submit" class="btn btn-primary mx-2 my-2">Зберегти</button>
                    <button type="reset" class="btn btn-primary">Очистити</button>
                </form>
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
