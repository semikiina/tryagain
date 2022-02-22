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
        <div class="container rowprinc" >
            <h1 class="titulo">Doações</h1>
            <hr>
        <div class="row">
            <?php 
                $qq="SELECT doar.iduser,doar.nome,doar.telefone,doar.ares,doar.categoria,utils.imagem from doar left join utils on doar.iduser=utils.email ";
                $st = $ms ->prepare($qq);
                $st->bind_result($iduser,$nome,$telefone,$ares,$categoria,$imagem);
                $st->execute();
                while ($st->fetch()) {
                    if($imagem==""){
                        $imagem="defaultpic.png";
                    }
                    
                ?>
                <div class="row justify-content-center" style="margin:10px;">
                
                <div class="card" style="width:85" >
                                    <div class="card-header" style="border-color:#bb9b84;background-color:#fffcfa">
                                        <a  href="perfilview.php?user=<?php echo $iduser?>" class="perfil">
                                            <div class="row">
                                                <img class="rounded-circle" src="<?php echo $imagem?>" width="50" height="50" style="object-fit:cover" />
                                                <div class="col d-flex align-items-center">
                                                    <h2 style="color:#2b1900"><?php echo $nome?></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">De: <?php echo $iduser ?></h5>
                                        <p class="card-text" style="margin:10px"><u>Doação:</u> <?php echo $categoria ?></p>
                                        <p class="card-text" style="margin:10px"><u>Area de Residência:</u> <?php echo $ares ?></p>
                                    </div>
                                </div>
                                
                            <br>
                </div>
                <?php
                }
            ?>
            </div>
        </div>
        </div>
        <?php
            include("footer.php");
        ?>
    </body>
</html>