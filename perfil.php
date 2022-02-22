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
        
            
                
                
    </style>
    
    <body>
        <?php
            include("menus.php");
        ?>
        <div class="container">
        
        <?php
            //editar capa
            if (isset($_POST['editardf'])){
                $destino="upload\\".uniqid().".jpg";
                if( $_FILES['imagemperfil']['type']=='image/jpeg'){
                    if (move_uploaded_file($_FILES['imagemperfil']['tmp_name'],$destino)) {
                    $sql='update utils set fotocapa=? where email=?';
                    $st=$ms->prepare($sql);
                    $st->bind_param('s',$destino);
                    $st->execute();
                    $st->close();
                    }
                }
            }

            //eliminar loja
            if (isset($_POST["deletar"])){
                $qq="delete from loja where username_loja=? ";
                $st = $ms->prepare($qq);
                $st->bind_param("s",$_POST["deletar"]);
                $st->execute();
                $st->close();
               
            }

            //editar capa
            if (isset($_POST['editarcapa'])){
                $destino="upload\\".uniqid().".jpg";
                if( $_FILES['imagemcapa']['type']=='image/jpeg'){
                    if (move_uploaded_file($_FILES['imagemcapa']['tmp_name'],$destino)) {
                    $sql='update utils set fotocapa=? where email=?';
                    $st=$ms->prepare($sql);
                    $st->bind_param('ss',$destino,$_SESSION["email"]);
                    $st->execute();
                    $st->close();
                    }
                }
            }

             //editar informacoes
             if (isset($_POST['editarf'])){
                $destino="upload\\".uniqid().".jpg";
                if( $_FILES['imagemperfil']['type']=='image/jpeg'){
                    if (move_uploaded_file($_FILES['imagemperfil']['tmp_name'],$destino)) {
                    $sql='update utils set nome=?,telefone=?,imagem=?,biografia=? where email=?';
                    $st=$ms->prepare($sql);
                    $st->bind_param('sssss',$_POST["nome"],$_POST["telefone"],$destino,$_POST["biografia"],$_SESSION["email"]);
                    $st->execute();
                    $st->close();
                    }
                }
                else{
                    $sql='update utils set nome=?,telefone=?,biografia=? where email=?';
                    $st=$ms->prepare($sql);
                    $st->bind_param('ssss',$_POST["nome"],$_POST["telefone"],$_POST["biografia"],$_SESSION["email"]);
                    $st->execute();
                    $st->close();
                    
                }
                    
            }
                ?>
               
            <?php 
                //mostrar perfil
                $query="SELECT email,nome,telefone,pass,imagem,nomeutil,fotocapa,biografia from utils where email=?";
                $imagemp="";
                $stt = $ms->prepare($query);
                $stt->bind_param('s',$_SESSION['email']);
                $stt->execute();
                $stt->bind_result($email,$nome,$telefone,$pass,$imagem,$usern,$fotocapa,$biografia);
                while($stt->fetch()){
                    if ($imagem==""){
                    $imagem="defaultpic.png";
                    }
                    if($fotocapa==""){
                        $fotocapa="images/defcapa.jpg";
                    }
                ?>
                <div class="img" ></div>
                    <img src="<?php echo $fotocapa ?>" style="width:100%;object-fit: cover;" height= '350px' >
                    <div class="card social-prof">
                        <div class="card-body">
                            <div class="wrapper">
                                <img src="<?php  echo $imagem?>"  alt="" class="img-fluid rounded-circle imgperfil">
                                
                                <h3 class="txt1"><?php  echo $nome?></h3>
                                <p class="text-muted ">@<?php  echo $usern?></p>
                                <p><?php  echo $biografia?></p>
                            </div>
                            <div class="row ">
                                <div class="col-lg-12">
                                    <ul class="nav nav-tabs justify-content-center s-nav">
                                
                                        <li><a  data-toggle="modal" data-target="#criarLoja">
                                        <span><i class="bi bi-plus"></i></span>Criar Loja</a></li>
                                        <li><a data-toggle="modal" data-target="#editarperfil" >Editar Perfil</a></li>
                                        <li><a data-toggle="modal" data-target="#editarcapa" >Editar Capa</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal para Editar Informações -->
                                <div class="modal fade" id="editarperfil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="border-bottom:none;">
                                            
                                            <h4 class="modal-title ">Editar Perfil</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:none;">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                
                                            </div>
                                            <div class="modal-body ">
                                                <div class="row ">
                                                    <div class="col justify-content-center">
                                                        <br>
                                                        <form method="post"   enctype="multipart/form-data">
                                                            <input type="file" id="selectedFile" name="imagemperfil" value="" style="display: none;" type="file" multiple onchange="showname()" />
                                                            <div class="imgbut" style="cursor:pointer" onclick="document.getElementById('selectedFile').click();"> 
                                                                <img  src="<?php echo $imagem ?>" id="filem" class=" img-fluid rounded-circle imgpe" style="width:250px;height:250px;object-fit:cover;"><br>
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
                                                                            $('#filem').attr('src', e.target.result);
                                                                        }
                                                                        reader.readAsDataURL(input.files[0]);
                                                                    }
                                                                }
                                                                $("#selectedFile").change(function(){
                                                                    readURL(this);
                                                                });
                                                            
                                                            </script>
                                                            <br>
                                                            <table>
                                                                <tr>
                                                                    <td> <label>Email:</label>
                                                                    </td>
                                                                    <td><input id="naomexe" type="text" name="email"   value="<?php echo $email ?>" readonly /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label>Nome:</label></td>
                                                                    <td><input type="text" name="nome" value="<?php echo $nome ?>"/></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label>Telefone:</label></td>
                                                                    <td><input type="text" name="telefone" value="<?php echo $telefone ?>" /></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><label>Biografia:</label></td>
                                                                    <td><input type="text" name="biografia" value="<?php echo $biografia ?>" ></td>
                                                                </tr>
                                                            </table>
                                                            <input type="submit" name="editarf" class="login100-form-btn " value="Confirmar" style="background-color: #7e8849">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                     <!-- Modal para Editar Capa -->
                     <div class="modal fade" id="editarcapa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header" style="border-bottom:none;padding:0">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:none;">
                                                    <span aria-hidden="true" style="margin-right:5px;margin-top:5px">&times;</span>
                                                </button>
                                                
                                            </div>
                                            <div class="modal-body " style="padding-top:5px">
                                                <div class="row ">
                                                    <div class="col justify-content-center">
                                                        <br>
                                                        <form method="post"   enctype="multipart/form-data">
                                                            <input type="file" id="capa" name="imagemcapa" value="" style="display: none;" type="file" multiple onchange="showname23()" />
                                                            <div class="imgbut" style="cursor:pointer" onclick="document.getElementById('capa').click();"> 
                                                                <img  src="<?php echo $fotocapa ?>" id="capaf" class=" img-fluid rounded-0 " ><br>
                                                                <div class="middle" >
                                                                    <span>Escolhe a foto</span>
                                                                </div>
                                                            </div>
                                                            <input type="submit" name="editarcapa" class="login100-form-btn " value="Confirmar" style="background-color: #7e8849">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                    <!-- Modal para criar loja-->
                    <div class="modal fade" id="criarLoja" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header" style="border-bottom:none;">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Criar Loja</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="col" >
                                        <form method="GET" action="loja.php" enctype="multipart/form-data">
                                            <img src="defaultpic.png" id="imloja" class="img-thumbnail img-fluid rounded-circle" style="width:250px;height:250px;object-fit:cover;"><br>
                                            </script>
                                            <label>Nome:</label>
                                            <input type="text" name="nomel" required><br>
                                            <label>Username:</label>
                                            <input type="text" name="userloja" required><br>
                                            <label>Cor:</label>
                                            <input style="width:50px;height:50px" type="color" name="corl" required><br>
                                            <input type="submit" value="Criar Loja" name="criar" class="login100-form-btn " style="background-color:#7e8849">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                <?php
                }
                $stt->close();
            
            ?>
            <div class="py-4 px-4">
                <div class="card social-timeline-card ">
                    <div class="card-body">
                        <h2 class="card-title " style="text-align:center;"><u>LOJAS</u></h2>
                <ul class="friend-list">
                <?php
                    //mostrar lojas
                    $qq="SELECT nome_loja,username_loja,cor,adm_loja,foto_perfil from loja where adm_loja=?";
                    $st = $ms ->prepare($qq);
                    $st->bind_param("s",$_SESSION["email"]);
                    $st->bind_result($nomel,$userl,$cor,$adm,$fotop);
                    $st->execute();
                    while ($st->fetch()) {
                        if ($fotop==""){
                            $fotop="defaultpic.png";
                            }
                ?>
                            <li>
                                <div class="left">
                                <button type="button" class="btn btn-danger " data-toggle="modal" data-target="#eliminar<?php echo $userl ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                </button>
                                <a href="loja.php?loja=<?php echo $userl ?>">
                                    <img src="<?php  echo $fotop?>" alt="" class="img-fluid rounded-circle imgperfil">
                                </div>
                                <div class="right">
                                    <h3><a href="loja.php?loja=<?php echo $userl ?>"><?php  echo $nomel?></h3>
                                    <p>@<?php  echo $userl?></p>
                                </div>
                                </a>
                        </li>
                        <!-- Modal para Eliminar Loja -->
                        <div id="eliminar<?php echo $userl ?>" class="modal fade">
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
                                        <p>Tem a certeza que pretende eliminar a loja <u><?php echo$userl?></u> e as suas publicações?</p>
                                    </div>
                                    <div class="modal-footer justify-content-center">
                                        <form method="post" id="deletar<?php echo $userl ?>">
                                            <input type="hidden" name="deletar" value="<?php echo $userl ?>">
                                            <button type="button" class="btn btn-danger btnverm" onclick="document.getElementById('deletar<?php echo $userl ?>').submit()">Confirmar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                <?php  
                    }
                    $st->close();
                ?>
                </ul> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        include("footer.php");
    ?>
    </body>
</html>