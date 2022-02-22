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
            include("logreg.php");
            include("menus.php");
        ?>
        <style>
            p{
                text-align:justify;
            }
           
            .colpub .row{
                padding: 5px;
                text-align: center;
            }
            .perfil {
                color:#2b1900
            }
            .perfil :hover{
                color:#2b1900
            }
        </style>
        <div class="container">

            <div class="row rowprin justify-content-center">
            
            <?php
            if(isset($_POST["pesquisa"]) && $_POST["pesquisa"]!=""){
            ?>
                <div class="col-12 col-md-4">
                <?php
                    $qq="SELECT nome_loja,username_loja,cor,adm_loja,foto_perfil from loja where username_loja like ? or adm_loja like ? ";
                    $st = $ms ->prepare($qq);
                    $a="%".$_POST['pesquisa']."%";
                    $st->bind_param("ss",$a,$a);
                    $st->bind_result($nomel, $lojap, $corl, $adml,$fotopl);
                    $st->execute();
                    while ($st->fetch()) {
                        if ($fotopl==""){
                            $fotopl="defaultpic.png";
                            }
                    ?>
                        <div class="col-sm-12 col-md-12 col-lg-4 justify-content-center" style="margin-bottom:5px" >
                            <div class="card" style="width:250px;">
                                <a href="loja.php?loja=<?php echo $lojap ?>" class="perfil" >
                                    <div class="card-body">
                                        <div class="row">
                                            <img class="rounded-circle" src="<?php echo $fotopl?>" width="50" height="50" style="object-fit:cover" />
                                            
                                            <div class="col d-flex align-items-center">
                                                    <h5 style="color:#2b1900"><?php echo $nomel?></h5>
                                                </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <br>     
                <?php
                    }
                ?>
                </div>
            <div class="col-12 col-md-7 col-lg-7" >
            <?php
                $st->close();
                $qq="SELECT pubs.id_pub,pubs.descricao_pub,pubs.loja_pub,pubs.imagem_pub,pubs.preco_pub,pubs.portes_pub,loja.foto_perfil,pubs.categoria,pubs.marca,pubs.estado,loja.nome_loja from pubs left join loja on pubs.loja_pub=loja.username_loja where pubs.descricao_pub like ? or pubs.loja_pub like ? or pubs.categoria like ? or pubs.marca like ? or pubs.estado like ? ";
                $st = $ms ->prepare($qq);
                $a="%".$_POST['pesquisa']."%";
                $st->bind_param("sssss",$a,$a,$a,$a,$a);
                $st->bind_result($id,$descricaop,$lojap,$imagemp,$precop,$portesp,$fotop,$categoria,$marca,$estado,$nomeloja);
                $st->execute();
                while ($st->fetch()) {
                    if ($fotop==""){
                        $fotop="defaultpic.png";
                        }
                    ?>
                        <div class="card" style="border:none;background-color:#fffcfa" >
                                    <div class="card-header" style="border-color:#bb9b84;background-color:#fffcfa">
                                        <a href="loja.php?loja=<?php echo $lojap ?>" class="perfil">
                                            <div class="row">
                                                <img class="rounded-circle" src="<?php echo $fotop?>" width="50" height="50" style="object-fit:cover" />
                                                <div class="col d-flex align-items-center">
                                                    <h2 style="color:#2b1900"><?php echo $nomeloja?></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <img src="<?php echo $imagemp ?>" style="width:100%;height:auto">
                                    <div class="row card-body text-center">

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
                                                    <h5><?php echo $marca ?></h5>
                                                </div>
                                                <div class="row">
                                                    <h5 class="titulo" style="margin-right:5px">ESTADO:</h5>
                                                    <h5 ><?php echo $estado ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    <?php
                                        include("botoes.php");
                                    ?>

                                </div>
                                
                            <br>
                            
                    <?php
                }
        }
        else{
            ?>
               
                        
                <?php
                    if(isset($_POST["filtrar"]) ){
                        ?>
                        <div class="col-12 col-md-7 col-lg-7">
                        <?php
                            $qq="SELECT pubs.id_pub,pubs.descricao_pub,pubs.loja_pub,pubs.imagem_pub,pubs.preco_pub,pubs.portes_pub,loja.foto_perfil,loja.username_loja,pubs.categoria,pubs.marca,pubs.estado,loja.nome_loja from pubs left join loja on pubs.loja_pub=loja.username_loja where true";
                            if(isset($_POST["categoria"])){
                                $cat=" and pubs.categoria='".$_POST['categoria']."'";
                            }
                            else{
                                $cat="";
                            }
                            if(isset($_POST["marca"])){
                                $marc=" and pubs.marca='".$_POST['marca']."'";
                            }
                            else{
                                $marc="";
                            }
                            if(isset($_POST["rangeprec"])){
                                $prec=" and pubs.preco_pub<=".$_POST['rangeprec']."";
                            }
                            else{
                                $prec="";
                            }
                            if(isset($_POST["estado"])){
                                $estad=" and pubs.estado='".$_POST['estado']."'";
                            }
                            else{
                                $estad="";
                            }
                                $qq=$qq.$cat.$marc.$prec.$estad;
                                $st = $ms ->prepare($qq);
                                $st->bind_result($id,$descricaop, $lojap, $imagemp, $precop,$portesp,$fotop,$userl,$categoria,$marca,$estado,$nomeloja);
                                $st->execute();
                                $st->store_result();
                                if($st->num_rows==0){
                                    echo "Neste momento não temos esses produtos disponiveis :(";
                                }
                                while ($st->fetch()) {
                                    if ($fotop==""){
                                        $fotop="defaultpic.png";
                                        }
                                    ?>
                                    <div class="card" style="border:none;background-color:#fffcfa" >
                                    <div class="card-header" style="border-color:#bb9b84;background-color:#fffcfa">
                                        <a href="loja.php?loja=<?php echo $lojap ?>" class="perfil">
                                            <div class="row">
                                                <img class="rounded-circle" src="<?php echo $fotop?>" width="50" height="50" style="object-fit:cover" />
                                                <div class="col d-flex align-items-center">
                                                    <h2 style="color:#2b1900"><?php echo $nomeloja?></h2>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <img src="<?php echo $imagemp ?>" style="width:100%;height:auto">
                                    <div class="row card-body text-center">

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
                                        
                                    <?php
                                        include("botoes.php");
                                    ?>

                                </div>
                                <br>
                        <?php 
                            }
                            $st->close();
                        ?>

                        </div>

                    <?php 
                    }
                    else{
                        ?>
                         
                         <div class="col-12 col-md-7 col-lg-7  d-block  d-xl-none " id="filtros" style="margin-bottom:20px">
                    <h1 class="titulo">FILTRAR</h1>
                    <div class="filtros1">
                        <form method="post">
                            <h2>Categoria<i class="bi bi-plus"></i></h2>
                            <select name="categoria" id="cat">
                                <option value="Escolhe uma categoria"  disabled selected>Categoria<br>
                                <option value="Roupa">Roupa</option>
                                <option value="Calçado">Calçado</option>
                                <option value="Jóias,Relógios e Bijuteria">Jóias,Relógios e Bijuteria</option>
                                <option value="Malas e Acessórios">Malas e Acessórios</option>
                                <option value="Saúde e Beleza">Saúde e Beleza</option>
                            </select>

                            <h2>Marca<i class="bi bi-plus"></i></h2>
                            <?php
                                $qq="SELECT marca from pubs ";
                                $st = $ms ->prepare($qq);
                                $st->bind_result($marca);
                                $st->execute();
                                ?>
                                <select name="marca" id="cat">
                                <option value="Escolhe uma marca"  disabled selected>Marca<br>
                                <?php
                                    while ($st->fetch()) {
                                        if($marca!=""){
                                            ?>
                                            <option value="<?php echo $marca?>"><?php echo $marca?><br>  
                                        <?php
                                        }
                                    }
                                    $st->close();
                            ?>
                            </select>
                        
                            <h2>Preço<i class="bi bi-plus"></i></h2>
                            <?php
                                $qq="SELECT max(preco_pub) from pubs ";
                                $st = $ms ->prepare($qq);
                                $st->bind_result($maxpr);
                                $st->execute();
                                $st->fetch();
                                $st->close();

                                $qq="SELECT min(preco_pub) from pubs ";
                                $st = $ms ->prepare($qq);
                                $st->bind_result($minpr);
                                $st->execute();
                                $st->fetch();
                                $st->close();
                            ?>
                            
                            <input type="range"  name="rangeprec" min="<?php echo $minpr?>" max="<?php echo $maxpr?>" oninput="this.nextElementSibling.value = this.value" value="<?php echo $maxpr?>" style="background-color:#bb9b84">
                            <output><?php echo $maxpr?> €</output>
                        
                            <h2>Estado<i class="bi bi-plus"></i></h2>
                            <select name="estado">
                                <option value="Escolhe um estado"  disabled selected>Estado<br>
                                <option value="Ligeiramente Usado">Ligeiramente Usado<br>
                                <option value="Usado">Usado<br>
                                <option value="Como novo">Como novo<br>
                                <option value="Nunca Usado">Nunca Usado<br>
                            </select>
                            <div class="d-flex justify-content-center">
                                <input class="login100-form-btn btnverde" type="submit" value="Filtrar" name="filtrar" style="margin-top:30px;">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-4 filtros d-none d-xl-block" id="filtros">
                    <div class="position-fixed" style="width:350px" >
                        <h1 class="titulo">FILTRAR</h1>
                            <div class="d-flex justify-content-center filtros1 ">
                            <form method="post">
                                <h2>Categoria<i class="bi bi-plus"></i></h2>
                                <select name="categoria" id="cat">
                                    <option value="Escolhe uma categoria"  disabled selected>Categoria<br>
                                    <option value="Roupa">Roupa</option>
                                    <option value="Calçado">Calçado</option>
                                    <option value="Jóias,Relógios e Bijuteria">Jóias,Relógios e Bijuteria</option>
                                    <option value="Malas e Acessórios">Malas e Acessórios</option>
                                    <option value="Saúde e Beleza">Saúde e Beleza</option>
                                </select>

                                <h2>Marca<i class="bi bi-plus"></i></h2>
                                <?php
                                    $qq="SELECT marca from pubs ";
                                    $st = $ms ->prepare($qq);
                                    $st->bind_result($marca);
                                    $st->execute();
                                    ?>
                                    <select name="marca" id="cat">
                                    <option value="Escolhe uma marca"  disabled selected>Marca<br>
                                    <?php
                                        while ($st->fetch()) {
                                            if($marca!=""){
                                                ?>
                                                <option value="<?php echo $marca?>"><?php echo $marca?><br>  
                                            <?php
                                            }
                                        }
                                        $st->close();
                                ?>
                                </select>
                            
                                <h2>Preço<i class="bi bi-plus"></i></h2>
                                <?php
                                    $qq="SELECT max(preco_pub) from pubs ";
                                    $st = $ms ->prepare($qq);
                                    $st->bind_result($maxpr);
                                    $st->execute();
                                    $st->fetch();
                                    $st->close();

                                    $qq="SELECT min(preco_pub) from pubs ";
                                    $st = $ms ->prepare($qq);
                                    $st->bind_result($minpr);
                                    $st->execute();
                                    $st->fetch();
                                    $st->close();
                                ?>
                                
                                <input type="range"  name="rangeprec" min="<?php echo $minpr?>" max="<?php echo $maxpr?>" oninput="this.nextElementSibling.value = this.value" value="<?php echo $maxpr?>" style="background-color:#bb9b84">
                                <output><?php echo $maxpr?> €</output>
                            
                                <h2>Estado<i class="bi bi-plus"></i></h2>
                                <select name="estado">
                                    <option value="Escolhe um estado"  disabled selected>Estado<br>
                                    <option value="Ligeiramente Usado">Ligeiramente Usado<br>
                                    <option value="Usado">Usado<br>
                                    <option value="Como novo">Como novo<br>
                                    <option value="Nunca Usado">Nunca Usado<br>
                                </select>
                                <div class="d-flex justify-content-center">
                                    <input class="login100-form-btn btnverde" type="submit" value="Filtrar" name="filtrar" style="margin-top:30px;">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                        <div class="col-12 col-md-8 col-lg-7">
                            <?php
                            $qq="SELECT pubs.id_pub,pubs.descricao_pub,pubs.loja_pub,pubs.imagem_pub,pubs.preco_pub,pubs.portes_pub,loja.foto_perfil,loja.username_loja,pubs.categoria,pubs.marca,pubs.estado,loja.nome_loja,loja.adm_loja from pubs left join loja on pubs.loja_pub=loja.username_loja";
                            $st = $ms ->prepare($qq);
                            $st->bind_result($id,$descricaop, $lojap, $imagemp, $precop,$portesp,$fotop,$userl,$categoria,$marca,$estado,$nomeloja,$admloja);
                            $st->execute();
                            while ($st->fetch()) {
                                if ($fotop==""){
                                    $fotop="defaultpic.png";
                                    }
                                ?>
                                
                                <div class="card" style="border:none;background-color:#fffcfa" >
                                    <div class="card-header" style="border-color:#bb9b84;background-color:#fffcfa">
                                        <a href="loja.php?loja=<?php echo $lojap ?>" class="perfil">
                                            <div class="row">
                                                <img class="rounded-circle" src="<?php echo $fotop?>" width="50" height="50" style="object-fit:cover" />
                                                <div class="col d-flex align-items-center">
                                                    <h2 style="color:#2b1900"><?php echo $nomeloja?></h2>
                                                </div>
                                               
                                            </div>
                                            
                                        </a>
                                        
                                    </div>
                                    <img src="<?php echo $imagemp ?>" style="width:100%;height:auto">
                                    <div class="row card-body text-center">

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
                                        
                                    <?php
                                        include("botoes.php");
                                    ?>

                                </div>
                                
                                <br>

                            <?php 
                            }
                            $st->close();
                            ?>

                        </div>

                <?php
                    }
                }
                ?>   
            </div>
        </div>
        </div>
        <?php
            include("footer.php");
            include("edielipub.php");
        ?>
    </body>
</html>