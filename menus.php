
	<style>
		
		
</style>
<nav class="navbar navbar-expand-lg navbar-light  fixed-top" style="background-color:#bb9b84">
  <a class="navbar-brand" href="index.php"><img src="icon.png" width="45" height="30" class="rounded-0" style="object-fit:cover" alt="" style="background-color:#bb9b84"></a>
  <button class=" navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent" style="background-color:#bb9b84">
    <ul class="navbar-nav mr-auto" style="background-color:#bb9b84">
    <?php
		include("config.php");
    $ms = new mysqli($bd_host,$bd_user,$bd_password,$bd_database);
    if (isset($_SESSION['email'])) 
    {
      $tp=$_SESSION['tipo'];
      $sql = "SELECT idmenu, nomeop, link,permissao,icon FROM menu WHERE permissao>=0 and permissao<=?";
    }
    else
    {
    $sql = "SELECT idmenu, nomeop, link,permissao,icon FROM menu WHERE permissao<=?"; 
      $tp=0;
    }
    $statement = $ms->prepare($sql);
    $statement->bind_param('i',$tp);
    $statement->execute();
    $statement->bind_result($idmenu,$nomeop,$link,$per,$icon);
    while($statement->fetch()){
    ?>
      
        <li class="nav-item ">
          <a class="nav-link " href="<?php  echo $link.".php" ?>" style="color:white;text-shadow: 2px 2px 5px #2b1900;"  >
		  	<h5>
			  	<?php  echo $icon ?>
              	<?php  echo $nomeop ?>
			  </h5>
              
          </a>
        </li>
      
    <?php 
    }
    $statement->close();
    ?>
    </ul>
    <?php
    if(!isset($_SESSION["email"])){
      ?>
        <button type="button" class="login100-form-btn btlog" data-toggle="modal" data-target="#login" style="margin-right:5px;width:auto;background-color:#9c5c28;">LOGIN</button>
      <?php
    }
    else{
      
     
      ?>
	  <div class="row justify-content-center icons" style="margin-left:10px">
      <a href="favorito.php"><h3 style="margin-right:20px"><i class="bi bi-bookmark-heart"></i></h3></a>
	  	<a href="pedidosdetroca.php"><h3 style="margin-right:20px"><i class="bi bi-bell"></i></h3></a>
      <a href="carrinho.php"><h3 style="margin-right:20px"><i class="bi bi-cart"></i></h3></a>
      <a href="mensagem.php"><h3 style="margin-right:20px"><i class="bi bi-envelope"></i></h3></a>
      <a href="perfil.php"><h3 style="margin-right:20px"><i class="bi bi-person-circle"></i></h3></a>
      
	  </div>
	  
    <a class="login100-form-btn btlog" href="logout.php" style="color:white;margin-right:5px;background-color:#792322;">LOGOUT</a>
      <?php
    }
    ?>
    
    <form class="form-inline my-2 my-lg-0" action="feed.php" method="post" id="pesquisa">
      
      <input class="form-control mr-sm-2 " type="search" name="pesquisa" placeholder="Procurar" aria-label="Search" >
      <button  onclick="document.getElementById('pesquisa').submit()" class="login100-form-btn" type="submit" style="background-color:#746c2d;color:white">Ir</button>
     
    </form>
  </div>
</nav>
