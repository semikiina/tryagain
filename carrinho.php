<?php
 session_start();

 include("config.php");
    $ligacao= new mysqli ($bd_host,$bd_user,$bd_password,$bd_database);
    if (isset($_GET["userutil"])){
        $query= "select count(*) from itemcarrinho where idcar=? and idpub=?";
        $statement = $ligacao->prepare($query);
        $statement->bind_param('si', $_GET["userutil"],$_GET["idpub"]);
        $statement->bind_result($tot);
        $statement->execute();
        $statement->fetch(); 
        $statement->close();
        if($tot==0){
            $query= "insert into itemcarrinho(idcar,idpub,preco) values(?,?,?)";
            $statement = $ligacao->prepare($query);
            $statement->bind_param('sii', $_GET["userutil"], $_GET["idpub"], $_GET["precop"]);
            $statement->execute();
            $statement->fetch(); 
            $statement->close();
            header("Refresh:0; url=carrinho.php");
        }
    }
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
        
    </style>
    <body>
        <?php

            include("menus.php");

            //apagar do carrinho

            if(isset($_POST["apaga"])){
                $qq="delete from itemcarrinho where idpub=? and idcar=?";
                $st = $ms->prepare($qq);
                $st->bind_param("is",$_POST["idpuba"],$_SESSION["usern"]);
                $st->execute();
                $st->close();
            }
        ?>
        <div class="container rowprinc">
            <div class="col">
                <h1 class="titulo">Carrinho</h1>
                <hr>
            </div>
            <div class="row">
            <div class="col-12 col-lg-6 itens">
            <?php 
                $precotot1=0;
                $precotot2=0;
                $query = "select itemcarrinho.idcar,itemcarrinho.iditem,itemcarrinho.dataitem,itemcarrinho.idpub,itemcarrinho.preco,pubs.id_pub,pubs.descricao_pub,pubs.loja_pub,pubs.imagem_pub,pubs.preco_pub,pubs.portes_pub,pubs.categoria,pubs.marca,pubs.estado from itemcarrinho left join pubs on itemcarrinho.idpub=pubs.id_pub where itemcarrinho.idcar=? order by itemcarrinho.dataitem ";
                $statement= $ligacao->prepare($query);
                $statement->bind_param('s', $_SESSION["usern"]);
                $statement->bind_result($idc,$idic,$datic,$idpubc,$precopc,$id,$descricaop, $lojap, $imagemp, $precop,$portesp,$categoria,$marca,$estado);
                $statement->execute();
                $statement->store_result();
                if($statement->num_rows==0){
                    echo "<h4 style='text-align:center'>Não tem itens no carrinho!</h4>";
                }
                while ($statement->fetch()) {
                    $precotot1+=$precopc;
                    $precotot2+=$portesp;
                    ?>
                    
                    <div class="row linha">
                    <a class="hov" href="imagemview.php?idpub=<?php echo $id ?>&loja=<?php echo $lojap ?>" > <img src="<?php echo $imagemp?>" class="img-fluid" style="width:150px;height:150px;object-fit:cover" ></a>
                            <div class="col align-items-center" style="text-align:center;margin-left:10px;" >
                                <div class="row">
                                    <h5 class="titulo" style="margin-right:5px">PREÇO:</h5>
                                    <h5 ><?php echo $precop ?>€</h5>
                                </div>
                                <div class="row">
                                    <h5 class="titulo" style="margin-right:5px">PORTES:</h5>
                                    <h5 ><?php echo $portesp ?>€</h5>
                                </div>
                                <div class="row">
                                    <h5 class="titulo" style="margin-right:5px">CATEGORIA:</h5>
                                    <h5><?php echo $categoria ?></h5>
                                </div>
                                <div class="row">
                                    <h5 class="titulo" style="margin-right:5px">MARCA:</h5>
                                    <h5 ><?php echo $marca ?></h5>
                                </div>
                                <div class="row">
                                    <h5 class="titulo" style="margin-right:5px">ESTADO:</h5>
                                    <h5 ><?php echo $estado ?></h5>
                                </div>
                            </div>
                            <form method="post" > 
                                <input type="hidden" name="idpuba" value="<?php echo $id?>">
                                <input type="submit" id="click<?php echo $id?>" name="apaga" value="Eliminar" style="display:none">
                            </form>
                            <button onclick="document.getElementById('click<?php echo $id?>').click()"><span id="hovertrash"><h1  ><i class="bi bi-trash-fill"></i></h1></span></button>
                        
                    </div>
                    
                    <br>
                    <?php
                }
                $statement->close();
                $tot12=$precotot1+$precotot2;
            ?>


            </div>
            <div class="col ">
                <div class="tot">
                    <h3>Resumo do Pedido</h3>
                    <p>Preço dos items: <?php echo $precotot1?>€</p>
                    <p>Preço dos portes: <?php echo $precotot2?>€</p>
                    <p>Preço total: <?php echo $tot12?>€</p>
                    <div class="row justify-content-center"><button style="width:100%;margin:10px 20px;" class="login100-form-btn btn1">Finalizar Compra</button></div>
                    
                </div>
                
            </div>
            </div>
            
            
        </div>
        <?php
            include("footer.php");
        ?>
    </body>
</html>