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
    $query = "SELECT nazva_kafedry FROM kafedry ORDER BY nazva_kafedry";
    $result = mysqli_query($bd_konferentsii, $query);

    if ( (isset($_POST["form1"])) && ($_POST["form1"] == "form1")) {
        $nazva_kafedry = $_POST['nazva_kafedry'];
        $query2 = "SELECT
            spivrobitnuky.id_spivrobitnyka,
            spivrobitnuky.id_kafedry,
            spivrobitnuky.prizvyshche,
            spivrobitnuky.imya,
            spivrobitnuky.pobatkovi,
            kafedry.nazva_kafedry
        FROM
            spivrobitnuky
        INNER JOIN kafedry ON spivrobitnuky.id_kafedry = kafedry.id_kafedry
        WHERE 
            kafedry.nazva_kafedry = '$nazva_kafedry'
        ";
        $result2 = mysqli_query($bd_konferentsii, $query2);
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
            <div class="col-12 text-center"> 
                <h1 class="text-primary">Співробітники</h1>
            </div>
        </div>
        <div class="row"> 
            <div class="col-6 text-center mx-auto"> 
                <form method="post" name="form1" class="form-inline"> 
                    <div class="form-group mx-auto"> 
                        <div class="form-group"> 
                            <div class="input-group-text"> 
                                по кафедрі <?php if (isset($result2)) echo $nazva_kafedry; ?>
                            </div>
                            <div class="form-group"> 
                                <input 
                                    list="id"
                                    class="form-control"
                                    name="nazva_kafedry"    
                                    placeholder="Виберіть кафедру"
                                    autocomplete="off"
                                >
                            </div>
                            <datalist id="id"> 
                                <?php 
                                    while ($row=mysqli_fetch_array($result)) {
                                ?>
                                <option value="<?php echo $row["nazva_kafedry"]; ?>"></option>
                                <?php 
                                    } 
                                ?>
                            </datalist>
                        </div>
                        <input type="hidden" name="form1" value="form1" />
                        <div class="form-group"> 
                            <button type="submit" class="btn btn-primary mx-1 my-2">Показати</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="text-right"> 
            <a href="spivrobitnyky_add.php" class="btn btn-primary btn-sm my-2"> 
                Додати запис
            </a>
        </div>
        <div class="row"> 
            <?php 
                if (isset($result2)) {
                    while ($row=mysqli_fetch_array($result2)) {
                
            ?>
            <div class="card text-center col-md-3"> 
                <div class="card-header"> 
                    Код співробітника <?php echo $row["id_spivrobitnyka"]; ?>
                </div>
                <div class="card-body"> 
                    <h5 class="card-title"><?php echo $row["prizvyshche"]; ?></h5>
                    <p class="card-text"><?php echo $row["imya"]; ?> <?php echo $row["pobatkovi"]; ?></p>
                </div>
                <div class="card-footer text-muted"> 
                    <a href="spivrobitnyky_del.php?id_spivrobitnyka=<?php echo $row['id_spivrobitnyka'];?>" class="btn btn-danger btn-md" data-toggle="tooltip" title="Видалити" onclick="return confirm('Ви впевнені, що хочете видалити запис?')"></a>
                    <a href="spivrobitnyky_edit.php?id_spivrobitnyka=<?php echo $row['id_spivrobitnyka'];?>" class="btn btn-warning btn-md" data-toggle="tooltip" title="Редагувати"></a>
                </div>
            </div>
            <?php 
                    }
                }
            ?>
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
