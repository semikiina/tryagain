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

            if(isset($_POST["apaga"])){
                $qq="delete from favorito where id_fav=?";
                $st = $ms->prepare($qq);
                $st->bind_param("i",$_POST["idfava"]);
                $st->execute();
                $st->close();
            }
        ?>
        <div class="container rowprinc" style="height:74vh" >
            <h1 class="titulo">Publicações guardadas</h1>
            <hr>
            
            <div class="row justify-content-center">
                <?php 
                $query = "select favorito.id_fav,favorito.id_pub,favorito.id_user,pubs.id_pub,pubs.descricao_pub,pubs.loja_pub,pubs.imagem_pub,pubs.preco_pub,pubs.portes_pub,pubs.categoria,pubs.marca,pubs.estado from favorito left join pubs on favorito.id_pub=pubs.id_pub where favorito.id_user=? ";
                $statement= $ms->prepare($query);
                $statement->bind_param('s', $_SESSION["usern"]);
                $statement->bind_result($idf,$iduf,$idpf,$id,$descricaop, $lojap, $imagemp, $precop,$portesp,$categoria,$marca,$estado);
                $statement->execute();
                $statement->store_result();
                if($statement->num_rows==0){
                    echo "<h4 style='text-align:center'>Ainda não guardou nenhuma publicação!</h4>";
                }
                while ($statement->fetch()) {
                    ?>
                    <div class="col-12 col-md-5 col-lg-3 item ">
                        <div class="con">
                            <img  class="img-fluid imgfa w-100 df" style="width:250px;height:250px;object-fit:cover;"src="<?php echo $imagemp?>" />
                            <div class="overlay">
                                <div class="container">
                                    <div class="row">
                                        <a style="color:white" href="imagemview.php?idpub=<?php echo $id ?>&loja=<?php echo $lojap ?>" class="login100-form-btn">Ver</a>
                                        <form method="post" > 
                                            <input type="hidden" name="idfava" value="<?php echo $idf?>">
                                            <input type="submit" id="elfav<?php echo $idf?>" name="apaga" value="Eliminar" style="display:none">
                                        </form>
                                        <button onclick="document.getElementById('elfav<?php echo $idf?>').click()"><span id="hovertrash"><h2  ><i class="bi bi-trash-fill"></i></h2></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
        <?php
            include("footer.php");
        ?>
    </body>
</html>