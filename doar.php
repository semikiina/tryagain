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
        include("logreg.php");
        include("menus.php");

        //mostrar perfil
        $query="SELECT email,nome,telefone from utils where email=?";
        $imagemp="";
        $stt = $ms->prepare($query);
        $stt->bind_param('s',$_SESSION['email']);
        $stt->execute();
        $stt->bind_result($email,$nome,$telefone);
        $stt->fetch();
        $stt->close();

        //doar
        if(isset($_POST["Doar"])){
            $query="insert into doar (iduser,nome,telefone,ares,categoria) values(?,?,?,?,?) ";
            $stt = $ms->prepare($query);
            $stt->bind_param('sssss',$_SESSION['email'],$_POST["nome"],$_POST["telefone"],$_POST["arear"],$_POST["categoria"]);
            $stt->execute();
            $stt->close();
        }


            
        
    ?>
    <div class="container rowprinc" style="height:74vh">
        <h1 class="titulo">Doar</h1>
        <hr>
        <div class="row">
            <div class="col-12 col-lg-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d48059.70954765434!2d-8.6569730255576!3d41.162202265366844!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2465abc4e153c1%3A0xa648d95640b114bc!2sPorto!5e0!3m2!1spt-PT!2spt!4v1623259764262!5m2!1spt-PT!2spt" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
            <div class="col-12 col-lg-6">
                <div class="doar">
                    <h1>Formulário</h1>
                    <p>Se apenas pretendes doar a tua roupa, basta preencheres este pequeno formulário.</p>
                    <p>Poderá ver algumas doações <a href="doacoes.php"><u>aqui</u></a>.</p>
                    <div>
                        <style>
                        .containerimg {
                            position: relative;
                            padding: 10px;
                            
                        }
                        .doar{
                            background-color: #bb9b84;
                            border-radius: 5px;
                            padding: 10px;
                        }
                        .overlay {
                        display:block;
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        border-radius: 5px;
                        background: rgba(0, 0, 0, .3);
                        
                        }
                        .containerimg:hover .login100-form-btn {
                        opacity: 1;
                        }
                        
                        select{
                            width:100%;
                        }
                        </style>
                        <div class="containerimg">
                            <form method="post">
                                <label>Nome:</label><input type="text" name="nome" value="<?php echo $nome?>">
                                <label>Telefone:</label><input type="text" name="telefone" value="<?php echo $telefone?>">
                                <label>Área de Residencia:</label><input type="text" name="arear" placeholder="Insira a sua área de residência">
                                <label>Categoria:</label>
                                <select name="categoria" id="cat">
                                    <option value="Roupa">Roupa</option>
                                    <option value="Calçado">Calçado</option>
                                    <option value="Jóias,Relógios e Bijuteria">Jóias,Relógios e Bijuteria</option>
                                    <option value="Malas e Acessórios">Malas e Acessórios</option>
                                    <option value="Saúde e Beleza">Saúde e Beleza</option>
                                </select>
                                <input type="submit" name="Doar" value="Doar" class="login100-form-btn ">
                            </form>
                            <?php 
                             if(!isset($_SESSION["email"])){
                            ?>
                            <div class="overlay d-flex align-items-center justify-content-center"><div class="login100-form-btn " data-toggle="modal" data-target="#login"><a > Faça Login para Doar </a></div></div>   
                            <?php
                            } 
                            ?>
                            
                        </div>
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