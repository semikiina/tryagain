<?php
 session_start();
 if($_SESSION["email"]==""){
    header("index.php");
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
    .img-fluid{
    width: 150px;
    height:150px;
    object-fit: cover;
    }
    .rowprinc{
		margin-top: 100px;
		}
    .backg{
        background-color: #bb9b84;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    </style>
    <body>
        <?php
            include("menus.php");

            //mostrar o meu item
            $mostrar=0;
            if(isset($_POST["idminhapub"])){
                $qq="SELECT pubs.id_pub,pubs.descricao_pub,pubs.loja_pub,pubs.imagem_pub,pubs.preco_pub,pubs.portes_pub from pubs where id_pub=?";
                $st = $ms ->prepare($qq);
                $st->bind_param("s",$_POST["idminhapub"]);
                $st->bind_result($midpub,$mdescricaop, $mlojap, $mimagem, $mprecop,$mportesp);
                $st->execute();
                while($st->fetch()) {
                    $mostrar=1;
                }
                $st->close();
            }
        ?>
        <div class="container rowprinc">
            <div class="row">
                <div class="col">
                    
                    <h1 class="titulo">Os meus itens</h1>
                    <div class="overflow-auto backg" style="max-height:800px">
                    <div class="row align-content-start flex-wrap" >
                        <?php
                        //gerar as pubs
                        $qq="SELECT pubs.id_pub,pubs.descricao_pub,pubs.loja_pub,pubs.imagem_pub,pubs.preco_pub,pubs.portes_pub,loja.foto_perfil,loja.username_loja,pubs.categoria,pubs.marca,pubs.estado,loja.nome_loja from pubs left join loja on pubs.loja_pub=loja.username_loja where loja.adm_loja=?";
                        $st = $ms ->prepare($qq);
                        $st->bind_param("s",$_SESSION["email"]);
                        $st->bind_result($midpub,$descricaopp, $lojapp, $imagempp, $precopp,$portespp,$fotopp,$userlp,$categoriap,$marcap,$estadop,$nomelojap);
                        $st->execute();
                        while($st->fetch()) {
                            ?>
                            <div class="col-8 col-sm-6 col-md-4 col-lg-3 justify-content-center" style="margin-bottom:15px;">
                                <form method="post" id="meuitem<?php echo $midpub ?>"> 
                                    <input type="hidden" name="idminhapub" value="<?php echo $midpub ?>">
                                    <a onclick="document.getElementById('meuitem<?php echo $midpub ?>').submit()" >
                                        <img class="img-fluid" src="<?php echo $imagempp?>">
                                    </a>
                                </div>
                                </form>
                        <?php
                        }
                        $st->close();
                        ?>
                    </div>
                    </div>
                     
                
                <div class="col">
                
                <h1 class="titulo">Troca</h1>
                <div class="row justify-content-center" >
                    <div class="col-12 col-md-5 col-lg-4 ">
                        <h2 class="titulo">O meu item</h2>
                        <div>
                            <?php
                                if($mostrar==0){
                            ?>
                                <div class="card" style="margin-top:10px">
                                    <div class="card-body">
                                        Selecione um item.
                                    </div>
                                </div>
                            <?php
                                }
                                else{
                            ?>          
                                <div class="col" style="margin-top:10px">
                                <div class="con">
                                    <img class="df" src="<?php echo $mimagem ?>"  style="width:350px;height:350px;object-fit:cover" >
                                    
                                    <div class="overlay"><button class="btn  btnverm" style="margin-left:60px" data-toggle="modal" data-target="#meuitem">Ver Detalhes</button></div>
                                </div>
                                    
                                    <!-- Modal -->
                                    <div class="modal fade" id="meuitem" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Detalhes</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <p style="margin:5px 0px"><?php echo $descricaopp ?></p>
                                                        </div>
                                                        <div class="col-12 col-lg-5 colpub" style="text-align:center;margin-left:10px">
                                                            <div class="row">
                                                                <h5 class="titulo" style="margin-right:5px">PREÇO:</h5>
                                                                <h5 ><?php echo $precopp ?>€</h5>
                                                            </div>
                                                            <div class="row">
                                                                <h5 class="titulo" style="margin-right:5px">PORTES:</h5>
                                                                <h5 ><?php echo $portespp ?>€</h5>
                                                            </div>
                                                            <div class="row">
                                                                <h5 class="titulo" style="margin-right:5px">CATEGORIA:</h5>
                                                                <h5><?php echo $categoriap ?></h5>
                                                            </div>
                                                            <div class="row">
                                                                <h5 class="titulo" style="margin-right:5px">MARCA:</h5>
                                                                <h5 ><?php echo $marcap ?></h5>
                                                            </div>
                                                            <div class="row">
                                                                <h5 class="titulo" style="margin-right:5px">ESTADO:</h5>
                                                                <h5 ><?php echo $estadop ?></h5>
                                                            </div>
                                                        </div>
                                                    </div>
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
                    
                    <div class="col-12 col-md-5 col-lg-4">
                        <h2 class="titulo">Trocar por</h2>
                        <div class="col-12">
                            <?php
                                //o item pelo qual quero trocar
                                $qq="SELECT pubs.id_pub,pubs.descricao_pub,pubs.loja_pub,pubs.imagem_pub,pubs.preco_pub,pubs.portes_pub,loja.foto_perfil,loja.username_loja,pubs.categoria,pubs.marca,pubs.estado,loja.nome_loja from pubs left join loja on pubs.loja_pub=loja.username_loja where pubs.id_pub=?";
                                $st = $ms ->prepare($qq);
                                $st->bind_param("s",$_GET["idpub"]);
                                $st->bind_result($idpub,$descricaop, $lojap, $imagemp, $precop,$portesp,$fotop,$userl,$categoria,$marca,$estado,$nomeloja);
                                $st->execute();
                                while($st->fetch()) {
                            ?>
                                <div class="col" style="margin-top:10px">
                                    <div class="con">
                                        <img class="df" src="<?php echo $imagemp ?>" style="width:350px;height:350px;object-fit:cover">
                                        <div class="overlay"><button class="btn  btnverm" style="margin-left:80px" data-toggle="modal" data-target="#itemtroca">Ver Detalhes</button></div>
                                        
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="itemtroca" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Detalhes</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <p style="margin:5px 0px"><?php echo $descricaop ?></p>
                                                    </div>
                                                    <div class="col-12 col-lg-5 colpub" style="text-align:center;margin-left:10px">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                                }
                                $st->close();
                            ?>
                        </div>
                        
                        
                    </div>
                    
                    </div>
                    <?php
                            if(isset($_POST["idminhapub"])){
                        ?>  
                        <div class="row justify-content-center" style="margin:10px">
                            <form method="get" id="confirmartroca" action="pedidosdetroca.php">
                            <input type="hidden" name="imeuitem" value="<?php echo $mimagem ?>">
                            <input type="hidden" name="ilojaitem" value="<?php echo $imagemp ?>">
                            <input type="hidden" name="meuitemtroca" value="<?php echo $midpub ?>">
                            <input type="hidden" name="lojaitemtroca" value="<?php echo $idpub ?>">
                            <a class="btn btnverde" style="color:white;width:250px;margin-left:70px"  onclick="document.getElementById('confirmartroca').submit()">  Confirmar Troca</a>
                            </form>
                        </div>
                        <?php   
                            }
                        ?>
                </div>
            </div>
        </div>
        
        
        </div>
        <?php
            include("footer.php");
        ?>
    </body>
</html>