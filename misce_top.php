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
    $query = "SELECT
        misca_progyvana.typ_misca_progyvana,
        misca_progyvana.nazava_misca,
        misca_progyvana.adressa,
        misca_progyvana.telephone,
        COUNT(uchasnyky.id_ychasnyka) as kilkist
    FROM
        misca_progyvana
    LEFT JOIN
        misce_progyvana_uchasnykiv ON misce_progyvana_uchasnykiv.id_misca_progyvana = misca_progyvana.id_misca_progyvana
    LEFT JOIN
        uchasnyky ON misce_progyvana_uchasnykiv.id_ychasnyka = uchasnyky.id_ychasnyka
    GROUP BY
        misca_progyvana.typ_misca_progyvana,
        misca_progyvana.nazava_misca,
        misca_progyvana.adressa,
        misca_progyvana.telephone
    ORDER BY
        kilkist DESC
    LIMIT 10";
    $result = mysqli_query($bd_konferentsii, $query);
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
    <div class="col-12 text-center"> 
        <h1 class="text-primary">
            <b>Рейтинг місць проживання</b>
        </h1>
    </div>
    <table width="100%" border="1"> 
        <tbody> 
            <tr style="front-weight: 600;"> 
                <td align="center">№ з/п</td>
                <td align="center">Тип</td>
                <td>Назва</td>
                <td align="center">Адреса</td>
                <td align="center">Телефон</td>
                <td align="center">Кількість учасників</td>
            </tr>
            <?php 
                if (isset($result)) {
                    $i=1;
                    while($row=mysqli_fetch_array($result)) {
                
            ?>
            <tr> 
                <td align="center"><?php echo $i; ?></td>
                <td align="center"><?php echo $row["typ_misca_progyvana"]; ?></td>
                <td><?php echo $row["nazava_misca"]; ?></td>
                <td align="center"><?php echo $row["adressa"]; ?></td>
                <td align="center"><?php echo $row["telephone"]; ?></td>
                <td align="center"><?php echo $row["kilkist"]; ?></td>
            </tr>
            <?php 
                    $i=$i+1;
                    }
                }
            ?>
        </tbody>
    </table>  
<!-- bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<!-- bootstrap -->
</body>
</html>
