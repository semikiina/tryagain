<?php
 session_start();
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Imagem</title>
            <?php
                include("htmlin.php");
            ?>
        </head>
        <body>
            <?php
            
                include("logreg.php");
                include("menus.php");
            
            ?>

            <div class="container">
                <div class="row rowprinc">

                    <?php
                        if (isset($_POST["editarf"])){
                            $qq="update pubs set descricao_pub=?,preco_pub=?,portes_pub=?,categoria=?,marca=?,estado=? where id_pub=? ";
                            $st = $ms->prepare($qq);
                            $st->bind_param("siisssi",$_POST["descricao1"],$_POST["preco1"],$_POST["portes1"],$_POST["categoria1"],$_POST["marca1"],$_POST["estado1"],$_GET["idpub"]);
                            $st->execute();
                            $st->close();
                        }

                        //buscar a pub
                        $qq="SELECT pubs.id_pub,pubs.descricao_pub,pubs.loja_pub,pubs.imagem_pub,pubs.preco_pub,pubs.portes_pub,loja.foto_perfil,loja.username_loja,pubs.categoria,pubs.marca,pubs.estado,loja.adm_loja from pubs left join loja on pubs.loja_pub=loja.username_loja where pubs.id_pub=? ";
                        $st = $ms->prepare($qq);
                        $st->bind_param("i",$_GET["idpub"]);
                        $st->bind_result($id,$descricaop, $lojap, $imagemp, $precop,$portesp,$fotop,$userl,$categoria,$marca,$estado,$admloja);
                        $st->execute();
                        while ($st->fetch()) {
                            if ($fotop==""){
                                $fotop="defaultpic.png";
                                }
                        ?>

                        <div class="card" style="border:none;padding:10px;box-shadow:1px 1px 8px #bb9b84 ">
                            <div class="row" >
                                <div class="col-12 col-lg-6">
                                    <img src="<?php echo $imagemp?>" alt="" style="width:100%;heigth:100%;"/>
                                </div>
                                <div class="col-12 col-lg-6" >
                                    <div class="row " style="margin:30px;margin-bottom:10px;">
                                        <a class="perfil " style="color:black" href="loja.php?loja=<?php echo $lojap ?>">
                                            <img class="rounded-circle" src="<?php echo $fotop?>" width="50" height="50" style="object-fit:cover" />
                                            <div class="col d-flex align-items-center">
                                            <h2><?php echo $lojap?></h2>
                                        </a>
                                            <?php 
                                            if($admloja==$_SESSION["email"]){
                                                ?>
                                                <span data-toggle="modal" data-target="#editar" id="hoveredit"><h3><i class="bi bi-pencil"></i></h3></span>
                                                <span data-toggle="modal" data-target="#eliminar<?php echo $_GET["idpub"]?>" id="hovertrash"><h3><i class="bi bi-trash-fill"></i></h3></span>
                                                <?php
                                            }
                                            ?>
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <div class="row justify-content-start">
                                        <div class="col-10" style="margin:20px;margin-top:0;margin-left:50px">
                                            <div class="row"><p><?php echo $descricaop ?></p></div>
                                            <br>
                                            <div class="row ">
                                                <h5 class="titulo" >PREÇO:</h5>
                                                <h5 ><?php echo $precop ?>€</h5>
                                            </div>
                                            <div class="row ">
                                                <h5 class="titulo" >PORTES:</h5>
                                                <h5 ><?php echo $portesp ?>€</h5>
                                            </div>
                                            <div class="row ">
                                                <h5 class="titulo" >CATEGORIA:</h5>
                                                <h5><?php echo $categoria ?></h5>
                                            </div>
                                            <div class="row ">
                                                <h5 class="titulo" >MARCA:</h5>
                                                <h5 ><?php echo $marca ?></h5>
                                            </div>
                                            <div class="row ">
                                                <h5 class="titulo" >ESTADO:</h5>
                                                <h5 ><?php echo $estado ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                   
                                </div>
                                <div style="margin-top:100px">
                                <?php include('botoes.php') ?>
                                </div>
                            </div>
                        </div>
                            <!-- Modal Editar -->
            <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="border-bottom:none;">
                            <h5 class="modal-title" id="exampleModalLongTitle">Editar Pub</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col ">
                                <br>
                                <form method="post" >
                                    <table>
                                        <tr>
                                            <td> <label>Descrição:</label>
                                            </td>
                                            <td><textarea name="descricao1"   value="<?php echo $descricaop ?>" placeholder="<?php echo $descricaop ?>" ></textarea>
                                        </tr>
                                        <tr>
                                            <td><label>Categoria:</label></td>
                                            <td><input type="text" name="categoria1" value="<?php echo $categoria ?>"/></td>
                                        </tr>
                                        <tr>
                                            <td><label>Marca:</label></td>
                                            <td><input type="text" name="marca1" value="<?php echo $marca ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td><label>Estado:</label></td>
                                            <td><input type="text" name="estado1" value="<?php echo $estado ?>" /></td>
                                        </tr>
                                        <tr>
                                            <td><label>Preço:</label></td>
                                            <td><input type="number"  name="preco1" value="<?php echo $precop ?>" ></td>
                                        </tr>
                                        <tr>
                                            <td><label>Portes:</label></td>
                                            <td><input type="number" name="portes1" value="<?php echo $portesp ?>" ></td>
                                        </tr>
                                    </table>
                                    <input type="submit" name="editarf" class="login100-form-btn btn1" value="Confirmar">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


                <!-- Modal Eliminar -->
                <div id="eliminar<?php echo $_GET["idpub"]?>" class="modal fade">
                    <div class="modal-dialog modal-confirm">
                        <div class="modal-content">
                            <div class="modal-header flex-column">
                                <div class="icon-box">
                                    <i class="material-icons">&#xE5CD;</i>
                                </div>						
                                <h4 class="modal-title w-100">Tem a certeza?</h4>	
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p>Tem a certeza que pretende eliminar a publicação?</p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <form method="get" id="el<?php echo $_GET["idpub"]?>" action="loja.php">
                                    <input type="hidden" name="idfotoel" value="<?php echo $_GET["idpub"]?>">
                                    <input type="hidden" name="loja" value="<?php echo $_GET["loja"]?>">
                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('el<?php echo $_GET['idpub'] ?>').submit()">Confirmar</button>
                                </form>
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
            
            <?php
                include("footer.php");

            ?>
        </body>
    </html>