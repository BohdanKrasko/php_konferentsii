<?php  include("logout.php"); ?>
<?php 
    require_once('connections.php');
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
    $id_sektsii = $_GET['id_sektsii'];
    $query = "SELECT
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
    WHERE
    id_sektsii = $id_sektsii";
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
    <?php 
        include("header.php")
    ?>
    <?php 
        include("nav.php")
    ?>
    
    <div class="container-fluid" style="min-height: 50vh">
        <div class="row"> 
            <div class="col-12 text-center"> 
                <h1 class="text-primary">Учасники</h1>
                <h3 class="text-primary">по конфернсії: "<?php echo $_GET['nazva_konferentsii']; ?>"</h3>
                <h3 class="text-primary">секції: "<?php echo $_GET['nazva_sektsii']; ?>"</h3>
            </div>
        </div>
        <div class="row"> 
            <div class="col-12"> 
                <div class="text-right"> 
                    <a href="uchasnyky_add.php?id_sektsii=<?php echo $_GET['id_sektsii']?>&nazva_sektsii=<?php echo $_GET['nazva_sektsii']?>&nazva_konferentsii=<?php echo $_GET['nazva_konferentsii']?>" class="btn btn-primary btn-sm my-2"> 
                        Додати учасника
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
                                        <div class="col-12"> 
                                            Тема доповіді: <?php echo $row["tema_dopovidi"]; ?>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-4"> 
                                            ПІБ: <?php echo $row["pib"]; ?>
                                        </div>
                                        <div class="col-4"> 
                                            E-mail: <?php echo $row["email"]; ?>
                                        </div>
                                        <div class="col-4"> 
                                            Телефон: <?php echo $row["telephone"]; ?>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-4"> 
                                            Науковий ступінь: <?php echo $row["naukovy_stupin"]; ?>
                                        </div>
                                        <div class="col-4"> 
                                            Вчене звання: <?php echo $row["vchene_zvanna"]; ?>
                                        </div>
                                        <div class="col-4"> 
                                            Проживання: 
                                            <?php
                                                if ($row["progyvana"]==1) {
                                                    echo "Так";
                                                } else {
                                                    echo "Ні";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </a>
                                <a
                                    href="certificate.php?pib=<?php echo $row["pib"]; ?>
                                    &nazva=<?php echo $_GET['nazva_konferentsii']?>
                                    &spivrobitnyk=<?php echo $_GET["spivrobitnyk"]; ?>
                                    &data_konf=<?php echo $_GET["data_p"]; ?>-<?php echo $_GET["data_z"]; ?>"
                                    target="_blank"
                                    class="btn bg-success btn-sm"
                                    data-toggle="tooltip"
                                    title="Сертифікат"
                                > 
                                </a>
                                <a
                                    href="uchasnyky_del.php?id_ychasnyka=<?php echo $row['id_ychasnyka']?>
                                        &id_sektsii=<?php echo $_GET['id_sektsii']?>
                                        &nazva_sektsii=<?php echo $_GET['nazva_sektsii']?>
                                        &nazva_konferentsii=<?php echo $_GET['nazva_konferentsii']?>"
                                    class="btn btn-danger btn-md" 
                                    data-toggle="tooltip" 
                                    title="Видалити" 
                                    onclick="return confirm('Ви впевнені, що хочете видалити запис?')"
                                > 
                                </a>
                                <a
                                    href="uchasnyky_edit.php?id_ychasnyka=<?php echo $row['id_ychasnyka']?>
                                        &id_sektsii=<?php echo $_GET['id_sektsii']?>
                                        &nazva_sektsii=<?php echo $_GET['nazva_sektsii']?>
                                        &nazva_konferentsii=<?php echo $_GET['nazva_konferentsii']?>"
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
                                <a href="prozhyvannya_uchasnykiv_add.php?id_ychasnyka=<?php echo $row['id_ychasnyka']?>
                                        &id_sektsii=<?php echo $_GET['id_sektsii']?>
                                        &nazva_sektsii=<?php echo $_GET['nazva_sektsii']?>
                                        &nazva_konferentsii=<?php echo $_GET['nazva_konferentsii']?>" 
                                    class="btn btn-primary btn-sm my-2" 
                                    title="Додати місце проживання">
                                </a>
                                <p class="text-center font-weight-bold"> Місця проживання: </p>
                                <?php 
                                    $id_uch = $row["id_ychasnyka"];
                                    $query2 = "SELECT
                                        misce_progyvana_uchasnykiv.id_misca_progyvana_uchasnyka,
                                        misca_progyvana.nazava_misca,
                                        misca_progyvana.typ_misca_progyvana,
                                        misca_progyvana.telephone,
                                        misce_progyvana_uchasnykiv.id_ychasnyka,
                                        misce_progyvana_uchasnykiv.dodatkovo,
                                        misce_progyvana_uchasnykiv.id_misca_progyvana
                                    FROM
                                        misce_progyvana_uchasnykiv
                                    INNER JOIN 
                                        misca_progyvana ON misce_progyvana_uchasnykiv.id_misca_progyvana = misca_progyvana.id_misca_progyvana
                                    WHERE
                                        misce_progyvana_uchasnykiv.id_ychasnyka = $id_uch";
                                    $result2 = mysqli_query($bd_konferentsii, $query2);

                                    if (isset($result2)) {
                                        while($row2=mysqli_fetch_array($result2)) {

                                ?>
                                <div class="row"> 
                                    <div class="col-3 text-white bg-info my-0"> 
                                        Місце: <?php echo $row2["nazava_misca"]; ?>.
                                    </div>
                                    <div class="col-3 text-white bg-info my-0"> 
                                        Тип: <?php echo $row2["typ_misca_progyvana"]; ?>.
                                    </div>
                                    <div class="col-3 text-white bg-info my-0"> 
                                        Телефон: <?php echo $row2["telephone"]; ?>.
                                    </div>
                                    <div class="col-3 text-white bg-info my-0"> 
                                        Додатково: <?php echo $row2["dodatkovo"]; ?>.
                                    </div>
                                </div>
                                <div class="text-center mb-3">  
                                    <a
                                        href="prozhyvannya_uchasnykiv_del.php?id_misca_progyvana_uchasnyka=<?php echo $row2['id_misca_progyvana_uchasnyka']?>
                                            &id_sektsii=<?php echo $_GET['id_sektsii']?>
                                            &nazva_sektsii=<?php echo $_GET['nazva_sektsii']?>
                                            &nazva_konferentsii=<?php echo $_GET['nazva_konferentsii']?>"
                                        class="btn btn-danger btn-sm" 
                                        data-toggle="tooltip" 
                                        title="Видалити місце проживання учасника" 
                                        onclick="return confirm('Ви впевнені, що хочете видалити запис?')"
                                    > 
                                    </a>
                                    <a
                                        href="prozhyvannya_uchasnykiv_edit.php?id_misca_progyvana_uchasnyka=<?php echo $row2['id_misca_progyvana_uchasnyka']?>
                                            &id_sektsii=<?php echo $_GET['id_sektsii']?>
                                            &nazva_sektsii=<?php echo $_GET['nazva_sektsii']?>
                                            &nazva_konferentsii=<?php echo $_GET['nazva_konferentsii']?>"
                                        class="btn btn-warning btn-sm" 
                                        data-toggle="tooltip" 
                                        title="Редагувати місце проживання учасника"
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
