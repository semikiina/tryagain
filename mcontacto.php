<!-- Modal -->
<div class="modal fade" id="men<?php echo $lojap?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="border-bottom:none;">
        <h5 class="modal-title" id="exampleModalLongTitle">Mensagem para a loja <?php echo $nomeloja?> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card" style="border:none;background-color:#fffcfa; margin-bottom:0" >
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
            </div>
      </div>
      <style>
          .men{
                margin:15px;
                margin-top:0;
          }
          .men input[type="text"]{
                border: 1px solid #361f00;
                margin:5px;
          }
      </style>
      <div class="men">
          <form method="post" action="mensagem.php">
              <input type="hidden" name="userman" value="<?php echo $_SESSION["email"]?>">
              <input type="hidden" name="userrec" value="<?php echo $lojap ?>">
              <input type="hidden" name="idpub" value="<?php echo $id ?>">
              <input type="text" name="men" placeholder="envie aqui a sua mensagem" >
              <div class="row justify-content-center"><input type="submit" name="envmen" value="Enviar" class="login100-form-btn btnverde" style="width:auto"></div>  
          </form>
      </div>
    </div>
  </div>
</div>