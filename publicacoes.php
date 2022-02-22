<style>


.lightbox-gallery {
    background-repeat: no-repeat;
    color: #000;
    overflow-x: hidden
}

.lightbox-gallery p {
    color: #fff
}

.lightbox-gallery h2 {
    font-weight: bold;
    margin-bottom: 40px;
    padding-top: 40px;
    color: #fff
}

@media (max-width:767px) {
    .lightbox-gallery h2 {
        margin-bottom: 25px;
        padding-top: 25px;
        font-size: 24px
    }
}

.lightbox-gallery .intro {
    font-size: 16px;
    max-width: 500px;
    margin: 0 auto 40px
}

.lightbox-gallery .intro p {
    margin-bottom: 0
}

.lightbox-gallery .photos {
    padding-bottom: 20px
}

.lightbox-gallery .item {
    padding-bottom: 30px
}




</style>

<div class="lightbox-gallery" style="background-color:<?php echo $cor ?>">
                <div class="container">
                    <div class="intro">
                    </div>
                    <div class="row photos"> 
                <?php
                    $qq="SELECT pubs.id_pub,pubs.descricao_pub,pubs.loja_pub,pubs.imagem_pub,pubs.preco_pub,pubs.portes_pub,loja.foto_perfil from pubs left join loja on pubs.loja_pub=loja.username_loja where pubs.loja_pub=?";
                    $st = $ms ->prepare($qq);
                    $st->bind_param("s",$_GET["loja"]);
                    $st->bind_result($id, $desc, $lojap, $imagem,$precop,$portesp,$fotoloja);
                    $st->execute();
                    while ($st->fetch()) {
                        if ($imagem==""){
                            $imagem="defaultpic.png";
                            }
                    ?>
                        <div class="col-sm-6 col-md-4 col-lg-3 item"><a href="imagemview.php?idpub=<?php echo $id ?>&loja=<?php echo $_GET["loja"] ?>" data-lightbox="photos"><img class="img-fluid" style="width:250px;height:250px;object-fit:cover;"src="<?php echo $imagem?>"></a></div>
                <?php 
                    }
                ?>
                    </div>
                </div>
            </div>
        </div>