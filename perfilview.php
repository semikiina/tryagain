<?php
    session_start();

    //criar Loja
    include("config.php");
    $ligacao= new mysqli ($bd_host,$bd_user,$bd_password,$bd_database);
   
    
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
                





            
                /*
                $query = "select count(id_seg) from seguidores where id_loja=? ";
                $statement = $ms->prepare($query);
                $statement->bind_param('s', $_GET["loja"]);
                $statement->bind_result($segs);
                $statement->execute();
                $statement->fetch();    
                $statement->close();

                $query = "select count(*) from seguidores where id_loja=? and id_user=?";
                $statement = $ligacao->prepare($query);
                $statement->bind_param('ss', $_GET["loja"],$_SESSION["usern"]);
                $statement->bind_result($totseg);
                $statement->execute();
                $statement->fetch();    
                $statement->close();*/
              
                
                if(isset($_GET["user"]) ){
                    $query = "select nome,email,imagem,nomeutil,fotocapa,biografia from utils where email=?";
                    $statement = $ms->prepare($query);
                    $statement->bind_param('s',$_GET["user"]);
                    $statement->bind_result($nome,$emailu,$imagemu,$nomeutil,$fotocapau,$biografiau);
                    $statement->execute();
                    $statement->fetch();    
                    $statement->close();
                    
                    if($fotocapau==""){
                        $fotocapau="images/defcapa.jpg";
                    }
                    ?>
                      <div class="img" ></div>
                    <img src="<?php echo $fotocapau ?>" style="width:100%;object-fit: cover;" height= '350px' >
                    <div class="card social-prof">
                        <div class="card-body">
                            <div class="wrapper">
                                <img src="<?php  echo $imagemu?>"  alt="" class="img-fluid rounded-circle imgperfil">
                                
                                <h3 class="txt1"><?php  echo $nome?></h3>
                                <p class="text-muted ">@<?php  echo $nomeutil?></p>
                                <p><?php  echo $biografiau?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="py-4 px-4">
                <div class="card social-timeline-card ">
                    <div class="card-body">
                        <h2 class="card-title " style="text-align:center;"><u>LOJAS</u></h2>
                <ul class="friend-list">
                <?php
                    //mostrar lojas
                    $qq="SELECT nome_loja,username_loja,cor,adm_loja,foto_perfil from loja where adm_loja=?";
                    $st = $ms ->prepare($qq);
                    $st->bind_param("s",$_GET["user"]);
                    $st->bind_result($nomel,$userl,$cor,$adm,$fotop);
                    $st->execute();
                    while ($st->fetch()) {
                        if ($fotop==""){
                            $fotop="defaultpic.png";
                            }
                ?>
                            <li>
                                <div class="left">
                                <a href="loja.php?loja=<?php echo $userl ?>">
                                    <img src="<?php  echo $fotop?>" alt="" class="img-fluid rounded-circle imgperfil">
                                </div>
                                <div class="right">
                                    <h3><a href="loja.php?loja=<?php echo $userl ?>"><?php  echo $nomel?></h3>
                                    <p>@<?php  echo $userl?></p>
                                </div>
                                </a>
                        </li>
                        
                <?php  
                    }
                    $st->close();
                ?>
                </ul> 
                    </div>
                </div>
            </div>
                    <?php   
                    
                
                }
                
            ?>
            
        </div>
        <?php 
         include("footer.php");
        ?>
    </body>
</html>