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
        .lojas{
            margin-top:10px;
            margin-left:10px;
        }
        .lojaind{
            background-color: #bb9b84;
            border-radius: 5px;
            padding:10px;
            margin-bottom:5px;
        }
        .mens{
            height:83vh;
            overflow: scroll;
        }
    </style>
    <body>
        <?php
            include("menus.php");

            //inserir mensagem
            if(isset($_POST["envmen"])){
                $qq="insert into mensagens (userman,userrec,mentxt,idpub) values(?,?,?,?)";
                $st = $ms->prepare($qq);
                $st->bind_param("sssi",$_POST["userman"],$_POST["userrec"],$_POST["men"],$_POST["idpub"]);
                $st->execute();
                $st->close();
            }
        ?>
      <div class="container rowprinc">
          <div class="row">
            <div class="col-12 col-lg-6">
                <h1 class="titulo">As minhas Lojas</h1>
                <div class="lojas">
                <?php
                    $qq="SELECT nome_loja,username_loja,cor,adm_loja,foto_perfil from loja where adm_loja=?";
                    $st = $ms ->prepare($qq);
                    $st->bind_param("s",$_SESSION["email"]);
                    $st->bind_result($nomel, $lojap, $corl, $adml,$fotopl);
                    $st->execute();
                    $mostrar=0;
                    while ($st->fetch()) {
                        if ($fotopl==""){
                            $fotopl="defaultpic.png";
                            }
                    ?>
                    <form method="post" id="mloja<?php echo $lojap ?>">
                        <input type="hidden" name="loja" value="<?php echo $lojap ?>">
                    </form>
                        <div class="row lojaind">
                            <img class="rounded-circle" src="<?php echo $fotopl?>" width="50" height="50" style="object-fit:cover" />
                            <div class="col d-flex align-items-center">
                            <a onclick="document.getElementById('mloja<?php echo $lojap ?>').submit();">
                                <h4 style="color:#2b1900"><?php echo $nomel?></h4>
                            </a>
                            </div>
                        </div>
                <?php
                    }
                ?>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <h1 class="titulo">Mensagens</h1>
                <div class="mens ">
                    <?php 
                        if(isset($_POST["loja"])){
                            $qq="SELECT mensagens.idmen,mensagens.userman,mensagens.userrec,mensagens.mentxt,mensagens.idpub,pubs.imagem_pub from mensagens left join pubs on mensagens.idpub=pubs.id_pub where mensagens.userrec=?";
                            $st = $ms ->prepare($qq);
                            $st->bind_param("s",$_POST["loja"]);
                            $st->bind_result($idmen,$userman,$userrec,$mentxt,$idpub,$imagempub);
                            $st->execute();
                            $st->store_result();
                            if($st->num_rows==0){
                                echo "<h5 style='text-align:center;margin-top:40px'>Esta loja ainda não recebeu mensagens!</h5>";
                            }
                            while ($st->fetch()) {
                            ?>
                            <div class="row justify-content-center" style="margin:10px;">
                            <div class="card" style="width:85%">
                                <a href="imagemview.php?idpub=<?php echo $idpub ?>&loja=<?php echo $userrec ?>"><img class="card-img-top" src="<?php echo $imagempub ?>" alt="Card image cap"></a>
                                <div class="card-body">
                                    <h5 class="card-title">De: <?php echo $userman ?></h5>
                                    <p class="card-text" style="margin:10px"><?php echo $mentxt ?></p>
                                    <div class="row justify-content-center"><a href="mailto: <?php echo $userman ?>" class="login100-form-btn" style="color:white;padding:20px"><h4><span><i class="bi bi-envelope"></i></span> Enviar Email</h4></a></div>
                                    
                                </div>
                            </div>
                            </div>
                            <?php
                            }
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