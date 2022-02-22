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
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="margin-top:20px">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/original.jpg" class="d-block w-100" alt="...">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Try Again</h1>
                        <p>Uma nova forma de dar uso às tuas roupas.</p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/original.jpg" class="d-block w-100" alt="...">
                <div class="container">
                    <div class="carousel-caption">
                        <h1>Precisa de Ajuda?</h1>
                        <p>De forma a resolver as suas dúvidas, poderá preecnhcer um simples questionário.</p>
                        <p><a class="btn btn-lg btn-primary" href="contactos.php" role="button">Ajuda</a></p>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="images/original.jpg" class="d-block w-100" alt="...">
                <div class="carousel-caption ">
                        <h1>Visita já o nosso Feed</h1>
                        <p><a class="btn btn-lg btn-primary" href="feed.php" role="button">Clique Aqui</a></p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <br>
    <br>
    <div class="container marketing">
        <h1>Conheça a nossa Staff</h1>
        <br>
        <BR>
        <style>
            .imgbut {
                position: relative;
                width: 50%;
                }
            .imgpe {
                opacity: 1;
                display: block;
                width: 100%;
                height: auto;
                transition: .5s ease;
                backface-visibility: hidden;
                }

                .middle {
                transition: .5s ease;
                opacity: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                -ms-transform: translate(-50%, -50%);
                text-align: center;
                }

                .imgbut:hover .imgpe {
                opacity: 0.7;
                }

                .imgbut:hover .middle {
                opacity: 1;
                }
        </style>
        <div class="row d-flex justify-content-center">
            <div class="col-lg-4">
                <div class="imgbut" style="cursor:pointer" > 
                    <img class="rounded-circle imgpe" src="images/cris.png" alt="Generic placeholder image" width="140" height="140">
                    <div class="middle" >
                        <span><a href="https://www.instagram.com/semikiina/"><h1><i class="bi bi-instagram"></h1></a></i></span>
                    </div>
                </div>
                <h2>Cristina Semikina</h2>
                <p>Informática.</p>
                
            </div><!-- /.col-lg-4 -->
            <div class="col-lg-4">
                <div class="imgbut" style="cursor:pointer" > 
                        <img class="rounded-circle imgpe" src="images/ana.png" alt="Generic placeholder image" width="140" height="140">
                        <div class="middle" >
                            <span><a href="https://www.instagram.com/ana.25l/"><h1><i class="bi bi-instagram"></h1></a></i></span>
                        </div>
                    </div>
                    <h2>Ana Leite</h2>
                    <p>Diretora dos Recursos Humanos.</p>
                    </div><!-- /.col-lg-4 -->
                <div class="col-lg-4">
                    <div class="imgbut" style="cursor:pointer" > 
                        <img class="rounded-circle imgpe" src="images/maria.png" alt="Generic placeholder image" width="140" height="140">
                        <div class="middle" >
                            <span><a href="https://www.instagram.com/mariarsilva6/"><h1><i class="bi bi-instagram"></h1></a></i></span>
                        </div>
                    </div>
                    <h2>Maria Silva</h2>
                    <p>Presidente.</p>
                    </div>
            </div><!-- /.row -->
            <br>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-4">
                <div class="imgbut" style="cursor:pointer" > 
                    <img class="rounded-circle imgpe" src="images/filipa.png" alt="Generic placeholder image" width="140" height="140">
                    <div class="middle" >
                        <span><a href="https://www.instagram.com/filipalmeida10/"><h1><i class="bi bi-instagram"></h1></a></i></span>
                    </div>
                </div>
                    <h2>Filipa Almeida</h2>
                    <p>Diretora Financeira.</p>
                </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="imgbut" style="cursor:pointer" > 
                            <img class="rounded-circle imgpe" src="images/edu.png" alt="Generic placeholder image" width="140" height="140">
                            <div class="middle" >
                                <span><a href="https://www.instagram.com/eduardocsilva23/"><h1><i class="bi bi-instagram"></h1></a></i></span>
                            </div>
                        </div>
                        <h2>Eduardo Silva</h2>
                        <p>Diretor de Vendas e Operações.</p>
                    </div><!-- /.col-lg-4 -->
                    <div class="col-lg-4">
                        <div class="imgbut" style="cursor:pointer" > 
                            <img class="rounded-circle imgpe" src="images/debora.png" alt="Generic placeholder image" width="140" height="140">
                            <div class="middle" >
                                <span><a href="https://www.instagram.com/debora.17.m/"><h1><i class="bi bi-instagram"></h1></a></i></span>
                            </div>
                        </div>
                        <h2>Débora Moreira</h2>
                        <p>Diretora de Marketing e TIC.</p>
                    </div><!-- /.col-lg-4 -->
            </div>

            <hr class="featurette-divider" >
            <div class="row featurette" >
                <div class="col-md-7">
                <h2 class="featurette-heading"> Dá uma nova chance às tuas roupas. <span class="text-muted">Cria, Vende, Troca e Doa.</span></h2>
                <p class="lead">Com a Try Again poderás criar a tua prória loja personalizada. Dá o teu toque e deixa a tua marca. Do que estás à espera?</p>
                </div>
                <div class="col-md-5">
                <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="500x500" style="width: 500px; height: 500px;" src="images/image1.jpeg" data-holder-rendered="true">
                </div>
            </div>
            
            </div>
            
        
     <?php 
    include("footer.php");
    ?>
</body>
</html>