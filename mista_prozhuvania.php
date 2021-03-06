<?php  include("logout.php"); ?>
<?php require_once('connections.php'); ?>
<?php 
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
    $query = "SELECT id_misca_progyvana, typ_misca_progyvana, nazava_misca, adressa, telephone FROM misca_progyvana ORDER BY id_misca_progyvana ASC";
    $result = mysqli_query($bd_konferentsii, $query);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="keywords" content="??????????????????????, ??????, ???????? ????????????">
<meta name="description" content="Web-???????? ???????????? ?????????????????????? ???????????????? ?????????? ????????????">
<meta name="author" content="?????????????? ??.??.">
         <title>??????????????????????</title>
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
            <div class="col-12 text-center"> 
                <h1 class="text-primary">?????????? ????????????????????</h1>
                <div class="text-right"> 
                    <a href="mista_prozhuvania_add.php" class="btn btn-primary btn-sm my-2">???????????? ??????????</a>
                </div>
                <div class="table-responsive"> 
                    <table class="table table-hover table-bordered"> 
                        <tbody> 
                            <tr class="text-dark" table-primary> 
                                <th></th>
                                <th></th>
                                <th> ?????? ???????? ???????????????????? </th>
                                <th> ?????? </th>
                                <th> ?????????? </th>
                                <th> ???????????? </th>
                                <th> ?????????????? </th>
                            </tr>
                            <?php 
                                $i=1;
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                            <tr class="text-dark"> 
                                <td>
                                    <a href="mista_prozhuvania_del.php?id_misca_progyvana=<?php echo $row['id_misca_progyvana'];?>" class="btn btn-danger btn-sm" data-toggle="tooltip" title="????????????????" onclick="return confirm('???? ????????????????, ???? ???????????? ???????????????? ???????????')"></a>
                                </td>
                                <td>
                                    <a href="mista_prozhuvania_edit.php?id_misca_progyvana=<?php echo $row['id_misca_progyvana'];?>" class="btn btn-warning btn-sm" data-toggle="tooltip" title="????????????????????"></a>
                                </td>
                                <td><?php echo $row["id_misca_progyvana"]; ?></td>
                                <td><?php echo $row["typ_misca_progyvana"]; ?></td>
                                <td><?php echo $row["nazava_misca"]; ?></td>
                                <td><?php echo $row["adressa"]; ?></td>
                                <td><?php echo $row["telephone"]; ?></td>
                            </tr>
                        </tbody>
                        <?php $i = $i + 1; }?>
                    </table>
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
<?php
    mysqli_free_result($result);
?>
