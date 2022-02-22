<style>
    
    .col1{
        margin: 10px 10px 10px 10px;
    }
    .card{
        box-shadow: 0px 2px 10px #bb9b84;
    }
    .col-8{
        margin-bottom:10px;
    }
    a:hover{
        color:white
    }
</style>
<?php
    
   

    if (isset($_SESSION["email"])){
        include("config.php");
        $ms1 = new mysqli($bd_host,$bd_user,$bd_password,$bd_database);
        $ms2 = new mysqli($bd_host,$bd_user,$bd_password,$bd_database);
        $qq1="SELECT count(nome_loja) from loja where adm_loja=? and username_loja=? ";
        $stt = $ms1 ->prepare($qq1);
        $stt->bind_param("ss",$_SESSION["email"],$lojap);
        $stt->bind_result($tot);
        $stt->execute();
        $stt->fetch();
        $stt->close();

        //favoritar
        if(isset($_POST["idpubfav".$id])){

            $sql='Insert into favorito(id_pub,id_user) values(?,?)';
            $st12=$ms2->prepare($sql);
            $st12->bind_param('is',$_POST["idpubfav".$id],$_SESSION["usern"]);
            $st12->execute();
            $st12->close();     
        }

        if(isset($_POST["didpubfav".$id])){

            $sql='delete from favorito where id_pub=? and id_user=?';
            $st12=$ms2->prepare($sql);
            $st12->bind_param('is',$_POST["didpubfav".$id],$_SESSION["usern"]);
            $st12->execute();
            $st12->close();     
        }

        $favs=0;
        $qq1="SELECT count(id_fav) from favorito where id_pub=? ";
            $stt1 = $ms2 ->prepare($qq1);
            $stt1->bind_param("i",$id);
            $stt1->bind_result($favs);
            $stt1->execute();
            $stt1->fetch();
            $stt1->close();

        $qq1="SELECT count(id_fav) from favorito where id_pub=? and id_user=?";
        $stt2 = $ms2 ->prepare($qq1);
        $stt2->bind_param("is",$id,$_SESSION["usern"]);
        $stt2->bind_result($favsus);
        $stt2->execute();
        $stt2->fetch();
        $stt2->close();

        if($tot==0){

    ?>
        <div class="card-footer text-muted" style="border-color:#bb9b84;background-color:#fffcfa">
            <div class="row justify-content-center">
        <?php 

            $qq1="SELECT count(iditem) from itemcarrinho where idcar=? and idpub=? ";
            $stt = $ms1 ->prepare($qq1);
            $stt->bind_param("si",$_SESSION["usern"],$id);
            $stt->bind_result($totit);
            $stt->execute();
            $stt->fetch();
            $stt->close();
            if($totit>0){
                ?>
                <div class="col-8 col-md-4 ">
                    <a class="login100-form-btn btn1" href="carrinho.php" style="background-color:#bb9b84">
                    <i class="bi bi-cart-check"></i>Adicionado
                    </a>
                </div>
                <?php
            }
            else{
                ?>
                <div class="col-8 col-md-4 ">
                    <a class="login100-form-btn btn1"  href="carrinho.php?userutil=<?php echo $_SESSION["usern"].'&idpub='.$id.'&precop='.$precop?>" style="color:white">
                    <i style="color:white" class="bi bi-cart-plus"></i>Comprar
                    </a>
                </div>
                <?php 
            }
        ?>
                <div class=" col-8 col-md-4 ">
                    <a  data-toggle="modal" data-target="#men<?php echo $lojap?>" class="login100-form-btn btn1">
                    <i class="bi bi-chat-right-dots"></i>Contactar
                    </a>
                </div>
                <div class=" col-8 col-md-4 ">
                    <a href="trocar.php?idpub=<?php echo $id ?>&loja=<?php echo $lojap ?>" class=" login100-form-btn btn1">
                    <i class="bi bi-recycle"></i>Trocar
                    </a>
                </div>
                <div class=" col-8 col-md-4 ">
                <div class="row justify-content-center">
                <?php
                 if($favsus>0){
                     ?>
                     <form method="post" id="dfav<?php echo $id ?>">
                <input type="hidden" name="didpubfav<?php echo $id?>" value="<?php echo $id ?>">
                </form>
                <h1 onclick="document.getElementById('dfav<?php echo $id ?>').submit()"><?php echo $favs ?><span id="favs" ><i  class="bi bi-heart-fill"></i></span></h1>
                     <?php

                 }
                else{
                    ?>
                    <form method="post" id="fav<?php echo $id ?>">
                        <input type="hidden" name="idpubfav<?php echo $id?>" value="<?php echo $id ?>">
                    </form>
                    <h1 onclick="document.getElementById('fav<?php echo $id ?>').submit()"><?php echo $favs ?><span ><i class="bi bi-heart"></i></span></h1>
                <?php
                } 
                ?>
                </div>
                </div>
            </div>
        </div>

        
    <?php
        }
    }
    else{
        ?>
        <div class="card-footer text-muted" style="border-color:#bb9b84;background-color:#fffcfa">
            <div style="color:white" class="row justify-content-center">
                <div class="col-8 col-md-4 ">
                    <a  class=" login100-form-btn btn1" data-toggle="modal" data-target="#login">
                    <i class="bi bi-cart-plus"></i>Comprar
                    </a>
                </div>
                <div class=" col-8 col-md-4 ">
                    <a style="color:white" data-toggle="modal" data-target="#login" class=" login100-form-btn btn1">
                    <i class="bi bi-chat-right-dots"></i> Contactar
                    </a>
                </div>
                <div class=" col-8 col-md-4 ">
                    <a style="color:white" data-toggle="modal" data-target="#login" class="login100-form-btn btn1">
                    <i class="bi bi-recycle"></i>Trocar
                    </a>
                </div>
            </div>
        </div>
    <?php
    }
    include("mcontacto.php");
    
    
?>


