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
        .rowprinc{
            margin-top: 100px;
        }
        .trocasp{
            margin:10px;
            padding: 10px;
            background-color: #fff3e3;
            border-radius: 5px;
        }

        .contt{
            background-color: #bb9b84 ;
        }

        .nav-tabs .nav-link.active{
            background-color: #bb9b84 ;
            color:white;
            border:none;
            
        }
        .tab-pane{
            border:none;
        }
        .nav-link{
            margin-bottom: -1px;
        }
        
        .nav-tabs .nav-link{
            color:#bb9b84;
        }
        .nav{
            border:none;
        }

        .nav-link:hover{
            border:none;
        }
        body{
            height:100%;
        }
    </style>
    <body> 
        <?php
            include("menus.php");
            $ms1 = new mysqli($bd_host,$bd_user,$bd_password,$bd_database);

            //aceitar troca
            if (isset($_POST["confirmar"])){
                $qq="update troca set estado=? where idtroca=? ";
                $st = $ms->prepare($qq);
                $st->bind_param("si",$_POST["confirmar"],$_POST["idtc"]);
                $st->execute();
                $st->close();
                $qq="update pubs set condicao=1 where id_pub=? ";
                $st = $ms->prepare($qq);
                $st->bind_param("i",$_POST["idmptc"]);
                $st->execute();
                $st->close();
                $qq="update pubs set condicao=1 where id_pub=? ";
                $st = $ms->prepare($qq);
                $st->bind_param("i",$_POST["idlptc"]);
                $st->execute();
                $st->close();
            }

            //cancelar troca
            if (isset($_POST["rejeitar"])){
                $qq="update troca set estado=? where idtroca=? ";
                $st = $ms->prepare($qq);
                $st->bind_param("si",$_POST["rejeitar"],$_POST["idtr"]);
                $st->execute();
                $st->close();
            }
           
            //eliminar pedido de troca
            if(isset($_POST["idta"])){
                $qq="delete from troca where idtroca=?";
                $ordem = $ms->prepare($qq);				
                $ordem->bind_param('i', $_POST["idta"]);
                $ordem->execute();
                $ordem->close();
            }

             //inserir troca
            if(isset($_GET["meuitemtroca"])){
                $qr ="select count(idtroca) from troca where emailtroca=? and idmeuitem=? and idlojaitem=? ";
                $ordem = $ms->prepare($qr);				
                $ordem->bind_param('sii', $_SESSION["email"],$_GET["meuitemtroca"],$_GET["lojaitemtroca"]);
                $ordem->execute();
                $ordem->bind_result($resul);
                $ordem->fetch();
                $ordem->close();
                if ($resul==0){
                    $query="insert into troca(idmeuitem,idlojaitem,emailtroca,imeuitem,ilojaitem) values(?,?,?,?,?)";
                    $statement2 = $ms->prepare($query);
                    $statement2->bind_param('iisss',$_GET["meuitemtroca"],$_GET["lojaitemtroca"],$_SESSION["email"],$_GET["imeuitem"],$_GET["ilojaitem"]);
                    if ($statement2->execute() && $statement2->affected_rows>0) {
                    //inserido
                    } 
                    $statement2->close();
                }
            }

            if(isset($_POST["confirmar"])){
                $qr ="UPDATE troca SET estado = ? WHERE idmeuitem=? and idlojaitem=? ";
                $ordem = $ms->prepare($qr);				
                $ordem->bind_param('sii', $_POST["confirmar"],$_POST["meuitemtroca"],$_POST["lojaitemtroca"]);
                $ordem->execute();
                $ordem->close();

            }
            if(isset($_POST["rejeitar"])){
                $qr ="UPDATE troca SET estado = ? WHERE idmeuitem=? and idlojaitem=? ";
                $ordem = $ms->prepare($qr);				
                $ordem->bind_param('sii', $_POST["rejeitar"],$_POST["meuitemtroca"],$_POST["lojaitemtroca"]);
                $ordem->execute();
                $ordem->close();
            }


        ?>
        <div class="container rowprinc"  style="height:74vh">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist" >
                    <a class="nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Os meus pedidos</a>
                    <a class="nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Aprovar trocas</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" >
                    <div class="row contt justify-content-center">
                <?php 
                    //pedidos de trocas
                    $qr ="select idtroca,idmeuitem,idlojaitem,emailtroca,imeuitem,ilojaitem,estado from troca where emailtroca=?";		
                    $ordem = $ms->prepare($qr);				
                    $ordem->bind_param('s', $_SESSION["email"]);
                    $ordem->execute();
                    $ordem->bind_result($idtroca, $idmeuitem, $idlojaitem,$emailtroca,$imeuitem,$ilojaitem,$estado);
                    $ordem->store_result();
                    if($ordem->num_rows==0){
                        echo "<p>Ainda nao realizou nenhuma troca!</p>";
                    }
                    while($ordem->fetch()){
                        ?>
                        <div class="trocasp con">
                            <div class="row ">
                                <div class="col">
                                    <img class="img-fluid" style="width:128px;height:128px;object-fit:cover;" src="<?php echo $imeuitem?>">
                                    <p class="font-italic">Meu item</p>
                                </div>
                                <div class="col">
                                    <img  class="img-fluid" style="width:128px;height:128px;object-fit:cover;" src="<?php echo $ilojaitem?>">
                                    <p class="font-italic">Troca</p>
                                </div>
                            </div>
                            <div class="overlay" >
                                <div class="row justify-content-center">
                                    <?php 
                                        if ($estado=="confirmar"){
                                            echo "<h3 style='background-color:green;padding:10px;color:white'>Pedido Aprovado!</h3>";
                                        }
                                        else if ($estado=="rejeitar"){
                                            echo "<h3 style='background-color:red;padding:10px;color:white'>Pedido Rejeitado</h3>";
                                        }
                                        else{
                                            echo "<h4 style='background-color:grey;padding:10px;color:white'>Pedido pendente!</h4>";
                                            ?>
                                            
                                            <button  data-toggle="modal" data-target="#eliminar<?php echo $idtroca ?>" ><h4><span id="hovertrash"><i class="bi bi-trash-fill"></i></span></h4></button>
                                    
                                            <?php
                                        }
                                    ?>
                                    
                                </div>
                            </div>
                        </div>

                        <!-- Modal para cancelar troca -->
                        <div id="eliminar<?php echo $idtroca ?>" class="modal fade">
                            <div class="modal-dialog modal-confirm">
                                <div class="modal-content" style="background-color: white;">
                                    <div class="modal-header flex-column">
                                        <div class="icon-box">
                                            <i class="material-icons">&#xE5CD;</i>
                                        </div>						
                                        <h4 class="modal-title w-100">Tem a certeza?</h4>	
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Tem a certeza que pretende cancelar a troca?</p>
                                    </div>
                                    <form method="post" > 
                                        <input type="hidden" name="idta" value="<?php echo $idtroca?>">
                                        <input type="submit" id="click1<?php echo $idtroca?>" name="apaga" value="Eliminar" style="display:none">
                                    </form>
                                    <div class="modal-footer justify-content-center">
                                        <button class="btn btn-danger btnverm" onclick="document.getElementById('click1<?php echo $idtroca?>').click()">Confirmar</button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    $ordem->close();
                    ?>
                    </div>
                </div>
                <div class="tab-pane fade  " id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                    <div class="row contt justify-content-center" >
                       
                        <?php 
                            //aprovar trocas
                            $qr ="select troca.idtroca,troca.idmeuitem,troca.idlojaitem,troca.emailtroca,troca.imeuitem,troca.ilojaitem,troca.estado from troca join pubs on troca.idlojaitem=pubs.id_pub join loja on pubs.loja_pub=loja.username_loja where loja.adm_loja=?";		
                            $ordem = $ms->prepare($qr);				
                            $ordem->bind_param('s', $_SESSION["email"]);
                            $ordem->execute();
                            $ordem->bind_result($idtroca, $idmeuitem, $idlojaitem,$emailtroca,$imeuitem,$ilojaitem,$estadotroca);
                            $ordem->store_result();
                            if($ordem->num_rows==0){
                                echo "<p>Não tem trocas para aprovar!</p>";
                            }
                            while($ordem->fetch()){
                                if($estadotroca==""){
                                
                                ?>
                                <div class="trocasp "  >
                                    <div class="row justify-content-center" >
                                        <div class="col ">
                                            <img class="img-fluid" style="width:128px;height:128px;object-fit:cover;" src="<?php echo $ilojaitem?>">
                                            <p class="font-italic">Meu produto</p>
                                            <form method="post" id="confirmar<?php echo $idtroca?>">
                                                <input type="hidden" name="confirmar" value="confirmar">
                                                <input type="hidden" name="idtc" value="<?php echo $idtroca?>">
                                                <input type="hidden" name="idmptc" value="<?php echo $idmeuitem?>">
                                                <input type="hidden" name="idlptc" value="<?php echo $idlojaitem?>">
                                                <button onclick="document.getElementById('confirmar<?php echo $idtroca?>').submit()" class="btn btnverde" style="width:128px" ><i class="bi bi-check-lg"></i> Aceitar </button>
                                            </form>
                                        </div>
                                        <div class="col">
                                            <img  class="img-fluid" style="width:128px;height:128px;object-fit:cover;" src="<?php echo $imeuitem?>">
                                            <p class="font-italic">Oferta de troca</p>
                                            <form method="post"  >
                                                <input type="hidden" name="rejeitar" value="rejeitar">
                                                <input type="hidden" name="idtr" value="<?php echo $idtroca?>">
                                                <button onclick="document.getElementById('rejeitar<?php echo $idtroca?>').submit()" class="btn  btnverm" style="width:128px"><i class="bi bi-x-lg"></i> Rejeitar </button>
                                            </form>
                                        </div>
                                    </div>
                                </div> 
                                <?php
                                }
                            }
                            $ordem->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <?php
        include("footer.php");
    ?>
</html>