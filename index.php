<?php  include("logout.php"); ?>
<?php 
    require_once('connections.php');
    if (!isset($_SESSION)) { // if session doesn't exist
        session_start();
    }
    $loginFormAction = $_SERVER['PHP_SELF']; // return url of site to form
    if (isset($_GET['accesscheck'])) { // return accesscheck from other pages
        $_SESSION['PrevUrl'] = $_GET['accesscheck'];
    }
    if (isset($_POST['name_user'])) {
        $loginUsername = $_POST['name_user'];
        $password = $_POST['parol'];
        $MM_fldUserAuthorization = "prava";
        $MM_redirectLoginSuccess = "konferentsiyi.php";
        $MM_redirctLoginFailed = "index.php";
        $MM_redirecttoReferrer = false;

        $LoginRS__query = "SELECT email, parol, prava FROM uchasnyky WHERE email = '$loginUsername' AND parol='$password'";

        $LoginRS = mysqli_query($bd_konferentsii, $LoginRS__query);
        $loginFoundUser = mysqli_num_rows($LoginRS);

        if ($loginFoundUser) {
            $LoginRS2 = mysqli_fetch_array($LoginRS);
            $loginStrGroup = $LoginRS2['prava'];

            $_SESSION['MM_Username'] = $loginUsername; // session global variable
            $_SESSION['MM_UserGroup'] = $loginStrGroup; // session global variable

            if (isset($_SESSION['PrevUrl']) && false) {
                $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];
            }
            header("Location: " . $MM_redirectLoginSuccess);
        } else {
            header("Location: " . $MM_redirctLoginFailed);
        }
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
                <h2 class="text-primary">Авторизація </h2>
                <form action="<?php echo $loginFormAction; ?>" method="POST" name="log">
                    <div class="form-group"> 
                        <label for="name_user">Логін (E-mail)</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="name_user" 
                            placeholder="Ведіть логін"
                        >
                    </div>
                    <div class="form-group"> 
                        <label for="parol">Пароль</label>
                        <input 
                            type="text" 
                            class="form-control" 
                            name="parol" 
                            placeholder="Ведіть пароль"
                        >
                    </div>
                    <input type="hidden" name="MM_insert" value="form1" />
                    <button type="submit" class="btn btn-primary mx-2 my-2">Ок</button>
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
