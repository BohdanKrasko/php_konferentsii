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
        $id_ychasnyka = $_GET['id_ychasnyka'];
        $query2 = "SELECT 
                id_ychasnyka,
                id_sektsii,
                pib, 
                email, 
                telephone,
                naukovy_stupin, 
                vchene_zvanna,
                tema_dopovidi, 
                progyvana 
            FROM 
                uchasnyky
            WHERE `id_ychasnyka` = '$id_ychasnyka'";
        $result2 = mysqli_query($bd_konferentsii, $query2);
        $row = mysqli_fetch_array($result2);
    } 

    if ( (isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
        $id_ychasnyka = $_POST['id_ychasnyka'];
        $pib = $_POST['pib'];
        $email = $_POST['email'];
        $telephone = $_POST['telephone'];
        $naukovy_stupin = $_POST['naukovy_stupin'];
        $vchene_zvanna = $_POST['vchene_zvanna'];
        $tema_dopovidi = $_POST['tema_dopovidi'];
        $progyvana = $_POST['progyvana'];
        $query3 = "UPDATE 
            `uchasnyky` 
        SET 
            `pib` = '$pib', 
            `naukovy_stupin` = '$naukovy_stupin',
            `vchene_zvanna` = '$vchene_zvanna', 
            `tema_dopovidi` = '$tema_dopovidi', 
            `email` = '$email', 
            `telephone` = '$telephone', 
            `progyvana` = '$progyvana' 
        WHERE
            `id_ychasnyka` = '$id_ychasnyka'";
        $result = mysqli_query($bd_konferentsii, $query3);
        header("Location: uchasnyky.php?id_sektsii=".$_POST['id_sektsii']."&nazva_sektsii=".$_POST['nazva_sektsii']."&nazva_konferentsii=".$_POST['nazva_konferentsii']);
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
        include("header.php")
    ?>
    <?php 
        include("nav.php")
    ?>
    
    <div class="container-fluid" style="min-height: 50vh">
        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 text-center mx-auto"> 
                <h2 class="text-primary">Учасник 
                    &#8220;<?php echo $row["pib"];?>&#8221;
                    <br> (редагування) 
                </h2>
                <form method="post" name="from1"> 
                    <div class="form-group"> 
                        <label for="pib">ПІБ</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="pib" 
                            placeholder="Ведіть ПІБ"
                            value="<?php  echo $row['pib']; ?>"
                        >
                    </div>
                    <div class="form-group"> 
                        <label for="naukovy_stupin">Науковий ступінь</label>
                        <input 
                            list="id"
                            class="form-control" 
                            name="naukovy_stupin" 
                            placeholder="Вкажіть науковий ступінь"
                            autocomplete="off"
                            value="<?php  echo $row['naukovy_stupin']; ?>"
                        >
                        <datalist id="id"> 
                            <option value="доктор філософії, PhD"></option>
                            <option value="доктор, Dhd"></option>
                        </datalist>
                    </div>
                    <div class="form-group"> 
                        <label for="vchene_zvanna">Вчене звання</label>
                        <input 
                            list="id2"
                            class="form-control" 
                            name="vchene_zvanna" 
                            placeholder="Вкажіть вчене звання"
                            autocomplete="off"
                            value="<?php  echo $row['vchene_zvanna']; ?>"
                        >
                        <datalist id="id2"> 
                            <option value="доцент"></option>
                            <option value="професор"></option>
                        </datalist>
                    </div>
                    <div class="form-group"> 
                        <label for="tema_dopovidi">Тема доповіді</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="tema_dopovidi" 
                            placeholder="Ведіть тему"
                            value="<?php  echo $row['tema_dopovidi']; ?>"
                        >
                    </div>
                    <div class="form-group"> 
                        <label for="email">E-mail</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="email" 
                            placeholder="Ведіть E-mail"
                            value="<?php  echo $row['email']; ?>"
                        >
                    </div>
                    <div class="form-group"> 
                        <label for="telephone">Телефон</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="telephone" 
                            placeholder="Ведіть телефон"
                            value="<?php  echo $row['telephone']; ?>"
                        >
                    </div>
                    <div class="form-group"> 
                        <label for="progyvana">Потреба у проживані</label>
                        <div class="form-check text-left"> 
                            <input class="form-check-input" type="radio" name="progyvana" value="1" <?php if ($row['progyvana'] == 1) { echo "checked"; } ?>>
                            <label class="form-check-label" for="progyvana">Так</label>
                        </div>
                        <div class="form-check text-left"> 
                            <input class="form-check-input" type="radio" name="progyvana" value="0" <?php if ($row['progyvana'] == 0) { echo "checked"; } ?>>
                            <label class="form-check-label" for="progyvana">Ні</label>
                        </div>
                    </div>

                    <input type="hidden" name="MM_insert" value="form1" />
                    <input type="hidden" name="id_ychasnyka" value="<?php echo $_GET['id_ychasnyka']; ?>" />
                    <input type="hidden" name="id_sektsii" value="<?php echo $_GET['id_sektsii']; ?>" />
                    <input type="hidden" name="nazva_sektsii" value="<?php echo $_GET['nazva_sektsii']; ?>" />
                    <input type="hidden" name="nazva_konferentsii" value="<?php echo $_GET['nazva_konferentsii']; ?>" />
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
