<?php
 session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Try Again</title>
        <?php
            include("htmlin.php");
        ?>
    </head>
    <style>
        .backprof{
            background-color: #bb9b84;
            padding:10px;
            border-radius: 5px;

        }
    </style>
    <body>
        <?php
            include("menus.php");
        ?>
        <div class="container rowprinc">
        <h1 class="titulo">Área Admin</h1>
        <div class=" row backprof">
            <img src="images/cris.png" class="img-fluid rounded-circle ">
            <div class="col">
                <h2>Cristina Semikina   <i class="bi bi-gear"></i></h2>
                <h3>Online</h3>
            </div>
        </div>
        </div>
        <?php
            include("footer.php");
        ?>
    </body>
</html>