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
        $query1 = "SELECT id_kafedry, nazva_kafedry FROM kafedry ORDER BY nazva_kafedry";
        $result_k = mysqli_query($bd_konferentsii, $query1);

        $id_spivrobitnyka = $_GET['id_spivrobitnyka'];
        $query2 = "SELECT 
                id_spivrobitnyka, 
                id_kafedry, 
                prizvyshche, 
                imya, 
                pobatkovi 
            FROM 
                spivrobitnuky
            WHERE `id_spivrobitnyka` = '$id_spivrobitnyka'";
        $result2 = mysqli_query($bd_konferentsii, $query2);
        $row = mysqli_fetch_array($result2);
        echo $row;
    } 

    if ( (isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
        $id_spivrobitnyka = $_POST['id_spivrobitnyka'];
        $id_kafedry = $_POST['id_kafedry'];
        $prizvyshche = $_POST['prizvyshche'];
        $imya = $_POST['imya'];
        $pobatkovi = $_POST['pobatkovi'];
        $query3 = "UPDATE `spivrobitnuky` SET `id_kafedry` = '$id_kafedry', `prizvyshche` = '$prizvyshche', `imya` = '$imya', `pobatkovi` = '$pobatkovi' WHERE `id_spivrobitnyka` = '$id_spivrobitnyka'";
        $result = mysqli_query($bd_konferentsii, $query3);
        header("Location: spivrobitnyky.php");
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
                <h2 class="text-primary">Співробітники 
                    &#8220;<?php echo $row["prizvyshche"];?>&#8221;
                    <br> (редагування) 
                </h2>
                <form method="post" name="from1"> 
                    <div class="form-group"> 
                        <label for="id_kafedry">Кафедра</label>
                        <input 
                            list="id"
                            class="form-control" 
                            name="id_kafedry" 
                            placeholder="Виберіть назву кафедри"
                            autocomplete="off"
                            value="<?php echo $row['id_kafedry']; ?>"
                        >
                        <datalist id="id"> 
                            <?php 
                                while ($row_k=mysqli_fetch_array($result_k)) {
                            ?>
                            <option value="<?php echo $row_k['id_kafedry']; ?>">
                                <?php echo $row_k["nazva_kafedry"]; ?>
                            </option>
                            <?php 
                                } 
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group"> 
                        <label for="prizvyshche">Прізвище</label>
                        <input type="text" class="form-control" name="prizvyshche" placeholder="Ведіть прізвище" value="<?php echo $row["prizvyshche"]; ?>">
                    </div>
                    <div class="form-group"> 
                        <label for="imya">Ім'я</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="imya" 
                            placeholder="Ведіть ім'я" 
                            value="<?php  echo $row['imya']; ?>"
                        >
                    </div>
                    <div class="form-group"> 
                        <label for="pobatkovi">По батькові</label>
                        <input
                            type="text" 
                            class="form-control" 
                            name="pobatkovi" 
                            placeholder="Ведіть по батькові" 
                            value="<?php  echo $row['pobatkovi']; ?>"
                        >
                    </div>
                    <input type="hidden" name="MM_insert" value="form1" />
                    <input type="hidden" name="id_spivrobitnyka" value="<?php  echo $row['id_spivrobitnyka']; ?>" />
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
