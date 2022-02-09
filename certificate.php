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
    <div id="cerificate"> 
        <div id="pib"> 
            <h2><?php echo $_GET['pib']?></h2>
        </div>
        <div id="nazva"> 
            <h3><?php echo $_GET['nazva']?></h3>
        </div>
        <div id="spivrobitnyk"> 
            <h3><?php echo $_GET['spivrobitnyk']?></h3>
        </div>
        <div id="data_konf"> 
            <h5><?php echo $_GET['data_konf']?></h5>
        </div>
    </div>
<!-- bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<!-- bootstrap -->
</body>
<style> 
    #cerificate {
        width: 29cm;
        height: 19cm;
        background-image: url("certificate.jpg");
        background-size: contain;
        background-repeat: no-repeat;
        border: 4px double black;
    }
    #pib {
        width: 170mm;
        height: 13mm;
        margin-left: 49mm;
        margin-top: 96mm;
        text-align: center;
    }
    #nazva {
        width: 140mm;
        height: 8mm;
        margin-left: 63mm;
        margin-top: 5mm;
        text-align: center;
    }
    #spivrobitnyk {
        width: 71mm;
        height: 13mm;
        margin-left: 188mm;
        margin-top: 29mm;
        text-align: center;
    }
    #data_konf {
        width: 70mm;
        height: 13mm;
        margin-left: 100mm;
        margin-top: 5mm;
        text-align: center;
    }
</style>
</html>
