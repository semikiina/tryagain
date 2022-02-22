<?php
    session_start();

    //criar Loja
    include("config.php");
    $ligacao= new mysqli ($bd_host,$bd_user,$bd_password,$bd_database);
    if (isset($_GET["criar"])){
        $nomel=$_GET["nomel"];
        $userl=$_GET["userloja"];
        $corl=$_GET["corl"];
        $query = "select count(*) from loja where username_loja=?";
        $statement = $ligacao->prepare($query);
        $statement->bind_param('s', $userl);
        $statement->bind_result($total);
        $statement->execute();
        $statement->fetch(); 
        $statement->close();
        if ($total==0) {
            $query ="insert into loja(nome_loja,username_loja,cor,adm_loja) values(?,?,?,?)";
            $statement2 = $ligacao->prepare($query);
            $statement2->bind_param('ssss',$nomel, $userl, $corl,$_SESSION["email"]);
            $statement2->execute();
            $statement2->close();
            header("Refresh:0; url=loja.php?loja=$userl");
        }
        else{
            echo "<div class='alert'>Username não disponivel!</div>";
        }
    }
        

    //eliminar pub
    if (isset($_GET["idfotoel"])){
        $qq="delete from pubs where id_pub=? ";
        $st = $ligacao->prepare($qq);
        $st->bind_param("i",$_GET["idfotoel"]);
        $st->execute();
        $st->close();
        $qq="delete from troca where idmeuitem=? or idlojaitem=? ";
        $st = $ligacao->prepare($qq);
        $st->bind_param("i",$_GET["idfotoel"]);
        $st->execute();
        $st->close();
        $qq="delete from itemcarrinho where iditem=? ";
        $st = $ligacao->prepare($qq);
        $st->bind_param("i",$_GET["idfotoel"]);
        $st->execute();
        $st->close();
    }

    //editar pub
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Loja</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <?php
            include("htmlin.php");
        ?>
    </head>
    <style>
        

    </style>
    <body>
        <?php
            include("menus.php");
            include("logreg.php");
        ?>
        <div class="container">
            <?php
                





                //seguir loja
                if(isset($_POST["seguir"])){
                    $sql='Insert into seguidores(id_user,id_loja) values(?,?)';
                        $st=$ms->prepare($sql);
                        $st->bind_param('ss',$_POST["user"],$_POST["userloja"]);
                        $st->execute();
                        $st->close();
                        
                }

                //deixar de seguir
                if(isset($_POST["dseguir"])){
                    $sql='Delete from seguidores where id_user=? and id_loja=?';
                        $st=$ms->prepare($sql);
                        $st->bind_param('ss',$_POST["user"],$_POST["userloja"]);
                        $st->execute();
                        $st->close();
                        
                }

                //mostrar seguidores
                $query = "select count(id_seg) from seguidores where id_loja=? ";
                $statement = $ms->prepare($query);
                $statement->bind_param('s', $_GET["loja"]);
                $statement->bind_result($segs);
                $statement->execute();
                $statement->fetch();    
                $statement->close();

                //editar informacoes
             if (isset($_POST['editarf'])){
                $destino="upload\\".uniqid().".jpg";
                if( $_FILES['imagemperfil']['type']=='image/jpeg'){
                    if (move_uploaded_file($_FILES['imagemperfil']['tmp_name'],$destino)) {
                    $sql='update loja set nome_loja=?,username_loja=?,cor=?,foto_perfil=? where adm_loja=? and username_loja=?';
                    $st=$ms->prepare($sql);
                    $st->bind_param('ssssss',$_POST["nomep"],$_POST["usernamep"],$_POST["corp"],$destino,$_SESSION["email"],$_GET["loja"]);
                    $st->execute();
                    $st->close();
                    }
                    
                }
                else{
                    $sql='update loja set nome_loja=?,username_loja=?,cor=? where adm_loja=? and username_loja=?';
                    $st=$ms->prepare($sql);
                    $st->bind_param('sssss',$_POST["nomep"],$_POST["usernamep"],$_POST["corp"],$_SESSION["email"],$_GET["loja"]);
                    $st->execute();
                    $st->close();
                }
                    
            }

                //inserir foto
                if (isset($_POST['inserir'])){       
                    $destino="upload\\".uniqid().".jpg";
                    if( $_FILES['Imagem']['type']=='image/jpeg'){
                        if (move_uploaded_file($_FILES['Imagem']['tmp_name'],$destino)) {
                        $sql='Insert into pubs(descricao_pub,loja_pub,imagem_pub,preco_pub,portes_pub,categoria,marca,estado) values(?,?,?,?,?,?,?,?)';
                        $st=$ms->prepare($sql);
                        $st->bind_param('ssssssss',$_POST["descricaop"],$_GET["loja"],$destino,$_POST["precop"],$_POST["portesp"],$_POST["categoria"],$_POST["marca"],$_POST["estado"]);
                        $st->execute();
                        $st->close();
                        }
                    }
                      
                }

                

                //determinar se é dono ou não
                $ligacao= new mysqli ($bd_host,$bd_user,$bd_password,$bd_database);
                if(isset($_GET["loja"]) ){
                    $query = "select count(*) from loja where username_loja=? and adm_loja=?";
                    $statement = $ligacao->prepare($query);
                    $statement->bind_param('ss', $_GET["loja"],$_SESSION["email"]);
                    $statement->bind_result($total);
                    $statement->execute();
                    $statement->fetch();    
                    $statement->close();
                    if ($total>0) {
                        //determinar a loja
                        $qq="SELECT nome_loja,username_loja,cor,adm_loja,foto_perfil from loja where username_loja=?";
                        $st = $ms ->prepare($qq);
                        $st->bind_param("s",$_GET["loja"]);
                        $st->bind_result($nomel, $userl, $cor, $adm,$imagemp);
                        $st->execute();
                        while ($st->fetch()) {
                            if ($imagemp==""){
                                echo '<script>document.getElementById("cor").style.backgroundColor='.$cor.'</script>';
                                $imagemp="defaultpic.png";
                                }
                        }
                        $st->close();
                        ?>
                        <!-- Informações da Loja -->
                        <div class="img" id="cor" style="width:100%;height:200px;background-color:<?php echo $cor ?>"></div>
                            <div class="card social-prof">
                                <div class="card-body">
                                    <div class="wrapper">
                                        <img src="<?php  echo $imagemp?>" alt="" class="img-fluid rounded-circle imgperfil">
                                        <h3><?php  echo $nomel?></h3>
                                        <p class="text-muted">@<?php  echo $userl?></p>
                                    </div>
                                    <div class="row ">
                                        <div class="col-lg-12">
                                            <ul class="nav nav-tabs justify-content-center s-nav">
                                                <li><a  data-toggle="modal" data-target="#editar">Editar Perfil</a></li>
                                                <li><a data-toggle="modal" data-target="#criarpub">Criar Pub</a>
                                                </li>
                                                <li><a></a></li>
                                            </ul>
                                        </div>
                                        
                                    </div>
                                    <h5><?php echo $segs ?> Seguidores</h5>
                                </div>
                            </div>
                            
                        <!-- Modal EDITAR -->
                        <form method="post" enctype="multipart/form-data">
                            <div class="modal fade" id="editar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content ">
                                        <div class="modal-header" style="border-bottom:none;">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Editar Informações</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body  ">
                                            <div class="container ">
                                                <div class="col ">
                                                    <form method="post"   enctype="multipart/form-data">
                                                        <input type="file" id="selectedFile" name="imagemperfil" value="" style="display: none;" type="file" multiple onchange="showname()" />
                                                        <div class="imgbut" style="cursor:pointer" onclick="document.getElementById('selectedFile').click();"> 
                                                            <img  src="<?php echo $imagemp ?>" id="filem" class=" img-fluid rounded-circle imgpe" style="width:250px;height:250px;object-fit:cover;"><br>
                                                            <div class="middle" >
                                                                <span>Escolhe a foto</span>
                                                            </div>
                                                        </div>
                                                          
                                                        <label>Nome da Loja:</label>
                                                        <input type="text" name="nomep" value="<?php echo $nomel ?>"/><br>
                                                        <label>Username da Loja:</label>
                                                        <input type="text" name="usernamep" id="naomexe"  value="<?php echo $userl ?>" readonly/><br>
                                                        <label>Cor da Loja:</label>
                                                        <input type="color"  style="width:50px;height:50px;border:none;" name="corp" value="<?php echo $cor ?>" /><br>
                                                        <input type="submit" name="editarf" class="login100-form-btn btn1" value="Confirmar">
                                                    </form>
                                                
                                                </div>
                                            </div>
                                        </div>
                                            
                                            
                                      
                                    </div>        
                                </div>
                            </div>
                        </form>

                        <!-- Modal Criar Publicação -->
                        <div class="modal fade" id="criarpub" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="modal-content">
                                        <div class="modal-header" style="border-bottom:none;">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Criar Pub</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                            <div class="modal-body">
                                                <div class="container">
                                                <input type="file" id="Imagem" name="Imagem" value="" style="display: none;" type="file" multiple onchange="showname()" />
                                                        <div class="imgbut" style="cursor:pointer" onclick="document.getElementById('Imagem').click();"> 
                                                            <img  src="deffoto.jpg" id="fff" class=" img-fluid rounded-0 imgpe" style="width:80%;height:100%;object-fit:cover;"><br>
                                                            <div class="middle" >
                                                                <span>Escolhe a foto</span>
                                                            </div>
                                                        </div>
                                                            <script type="text/javascript">
                                                        //FUNCAO PARA VER A FOTO SELECIONADO
                                                            function readURL(input) {
                                                                if (input.files && input.files[0]) {
                                                                    var reader = new FileReader();
                                                                    reader.onload = function (e) {
                                                                        $('#fff').attr('src', e.target.result);
                                                                    }
                                                                    reader.readAsDataURL(input.files[0]);
                                                                }
                                                            }
                                                            $("#Imagem").change(function(){
                                                                readURL(this);
                                                            });
                                                        </script>
                                                <table>
                                                    <tr>
                                                        <td><label>Nome:</label></td>
                                                        <td><input type="text" name="descricaop"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Preço:</label></td>
                                                        <td><input type="number" step="any" name="precop"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Portes:</label></td>
                                                        <td><input type="number" step="any" name="portesp"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Categoria:</label></td>
                                                        <td><select name="categoria" id="cat">
                                                                <option value="Roupa">Roupa</option>
                                                                <option value="Calçado">Calçado</option>
                                                                <option value="Jóias,Relógios e Bijuteria">Jóias,Relógios e Bijuteria</option>
                                                                <option value="Malas e Acessórios">Malas e Acessórios</option>
                                                                <option value="Saúde e Beleza">Saúde e Beleza</option>
                                                            </select></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Marca:</label></td>
                                                        <td><input type="text" placeholder="ex.:Bershka" name="marca"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><label>Estado:</label></td>
                                                        <td><select name="estado" id="estado">
                                                                <option value="Usado">Usado</option>
                                                                <option value="Ligeiramente Usado">Ligeiramente Usado</option>
                                                                <option value="Como novo">Como novo</option>
                                                                <option value="Nunca Usado">Nunca Usado</option>
                                                            </select></td>
                                                    </tr>
                                                </table>
                                                <input type="submit" name="inserir" class="login100-form-btn btn1" value="Inserir">
                                            </div>
                                                
                                                
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                <?php
                    }
                    else{
                        
                        $query = "select count(*) from seguidores where id_loja=? and id_user=?";
                        $statement = $ligacao->prepare($query);
                        $statement->bind_param('ss', $_GET["loja"],$_SESSION["usern"]);
                        $statement->bind_result($totseg);
                        $statement->execute();
                        $statement->fetch();    
                        $statement->close();
                   

                        $qq="SELECT nome_loja,username_loja,cor,adm_loja,foto_perfil from loja where username_loja=?";
                        $st = $ms ->prepare($qq);
                        $st->bind_param("s",$_GET["loja"]);
                        $st->bind_result($nomel, $userl, $cor, $adm,$imagemp);
                        $st->execute();
                        while ($st->fetch()) {
                            if ($imagemp==""){
                                $imagemp="defaultpic.png";
                                }
                        ?>
                        <div class="img" id="cor" style="width:100%;height:200px;background-color:<?php echo $cor ?>"></div>
                            <div class="card social-prof">
                                <div class="card-body">
                                    <div class="wrapper">
                                        <img src="<?php  echo $imagemp?>" alt="" class="img-fluid rounded-circle imgperfil">
                                        <h3><?php  echo $nomel?></h3>
                                        <p>@<?php  echo $userl?></p>
                                    </div>
                                    <h5><?php echo $segs ?> Seguidores</h5>
                                    <div class="row justify-content-center">
                                <?php 

                                if(isset($_SESSION["email"])){
                                    if($totseg==0 ){
                                        ?>
                                        <form method="post">
                                            <input type="hidden" name="user" value="<?php echo $_SESSION["usern"] ?>">
                                            <input type="hidden" name="userloja" value="<?php echo $userl ?>">
                                            <input type="submit" class="login100-form-btn btnverde" style="width:auto" name="seguir" value="Seguir">
                                        </form>
                                <?php
                                    }
                                    else{
                                        ?>
                                    <form method="post">
                                        <input type="hidden" name="user" value="<?php echo $_SESSION["usern"] ?>">
                                        <input type="hidden" name="userloja" value="<?php echo $userl ?>">
                                        <input type="submit" class="login100-form-btn btnverm" style="width:auto" name="dseguir" value="A Seguir">
                                    </form>
                                    <?php
                                    }
                                }
                                    
                                ?> 
                            </div>
                            </div>
                                
                            </div>
                        <?php 
                        } 
                    ?> 
                    <?php   
                    }
                
                }
                include("publicacoes.php");
                include("footer.php");
            ?>
            
        </div>
    </body>
</html>