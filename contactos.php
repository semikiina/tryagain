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

<body>
    <?php
        include("menus.php");
    ?>
    <style>
    .container input{
        border-radius: 5px;
        width:50%;
        margin-bottom:10px;
        height: 40px;
        padding: 10px 10px;
    }
    textarea{
        border-radius: 5px;
        width:50%;
        height: 200px;
        padding: 20px 20px;
        resize: none;
    }
</style>
    <div class="container" style="height:74vh">
        <div class="row rowprinc justify-content-center" style="margin-top:100px">
            <div class="col text-center" style="background-color:#bb9b84;margin-bottom:20px;border-radius:5px;width:auto;padding-bottom:20px">
                <h1 class="titulo" style="margin:10px 0px">Contactos</h1>
                <p>Página destinada para dúvidas e esclarecimentos.</p>
                <h3 style="margin:10px 0px">Preencha o seguinte formulário:</h3>
                <form >
                    <label class="text-uppercase fw-bold">Tema</label><br>
                    <input type="text" name="tema" placeholder="Insira o seu tema"><br>
                    <label class="text-uppercase fw-bold" >Conte-nos detalhadamente o que aconteceu</label><br>
                    <textarea name="problema"></textarea>
                    <div class="row justify-content-center" >
                    <input type="submit" style="width:49%" class="login100-form-btn" name="enviaj" value="Enviar">

                    </div>
                    
                </form>
            </div>
        </div>
    </div>
<?php 
    include("footer.php");
    ?>
</body>
</html>