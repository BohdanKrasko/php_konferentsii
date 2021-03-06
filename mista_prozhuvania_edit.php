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
        $id_misca_progyvana = $_GET['id_misca_progyvana'];
        $query = "SELECT id_misca_progyvana, typ_misca_progyvana, nazava_misca, adressa, telephone FROM misca_progyvana WHERE id_misca_progyvana = $id_misca_progyvana";
        $result = mysqli_query($bd_konferentsii, $query);
        $row = mysqli_fetch_array($result);
    } 

    if ( (isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
        $id_misca_progyvana = $_POST['id_misca_progyvana'];
        $typ_misca_progyvana = $_POST['typ_misca_progyvana'];
        $nazava_misca = $_POST['nazava_misca'];
        $adressa = $_POST['adressa'];
        $telephone = $_POST['telephone'];
        $query = "UPDATE `misca_progyvana` SET `typ_misca_progyvana` = '$typ_misca_progyvana', `nazava_misca` = '$nazava_misca', `adressa` = '$adressa', `telephone` = '$telephone' WHERE `id_misca_progyvana` = '$id_misca_progyvana'";
        $result = mysqli_query($bd_konferentsii, $query);
        header("Location: mista_prozhuvania.php");
    }
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="??????????????????????, ??????, ???????? ????????????">
<meta name="description" content="Web-???????? ???????????? ?????????????????????? ???????????????? ?????????? ????????????">
<meta name="author" content="?????????????? ??.??.">
         <title>?????????? ????????????????????</title>
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
                <h2 class="text-primary">?????????? ???????????????????? <br> (??????????????????????) </h2>
                <form method="post" name="from1"> 
                    <div class="form-group"> 
                        <label for="typ_misca_progyvana">??????</label>
                        <input 
                            list="id"
                            class="form-control" 
                            name="typ_misca_progyvana" 
                            placeholder="???????????? ??????"
                            autocomplete="off"
                            value="<?php  echo $row['typ_misca_progyvana']; ?>"
                        >
                        <datalist id="id"> 
                            <option value="????????????"></option>
                            <option value="??????????????????"></option>
                            <option value="????????????"></option>
                        </datalist>
                    </div>
                    <div class="form-group"> 
                        <label for="nazava_misca">??????????</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="nazava_misca" 
                            placeholder="???????????? ???????????????????????? ??????????????" 
                            value="<?php  echo $row['nazava_misca']; ?>"
                        >
                    </div>
                    <div class="form-group"> 
                        <label for="adressa">????????????</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="adressa" 
                            placeholder="???????????? ???????????????????????? ??????????????" 
                            value="<?php  echo $row['adressa']; ?>"
                        >
                    </div>
                    <div class="form-group"> 
                        <label for="telephone">??????????????</label>
                        <input
                            type="text" 
                            class="form-control" 
                            name="telephone" 
                            placeholder="???????????? ???????????????????????? ??????????????" 
                            value="<?php  echo $row['telephone']; ?>"
                        >
                    </div>
                    <input type="hidden" name="MM_insert" value="form1" />
                    <input type="hidden" name="id_misca_progyvana" value="<?php  echo $row['id_misca_progyvana']; ?>" />
                    <button type="submit" class="btn btn-primary mx-2 my-2">????????????????</button>
                    <button type="reset" class="btn btn-primary">????????????????</button>
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
