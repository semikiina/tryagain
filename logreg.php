
        <?php
            include("config.php");
            $ligacao= new mysqli ($bd_host,$bd_user,$bd_password,$bd_database);
            //Registar
            if (isset($_POST["Register"])) {
                $usern=$_POST["usern"];
                $name=$_POST["nome"];
                $email=$_POST["email"];
                $telefone=$_POST["telefone"];
                $password=$_POST["pass"];
                $rpassword=$_POST["rpass"];
                $tipoo=1;
                $query = "select count(*) from utils where email=?";
                $statement = $ligacao->prepare($query);
                $statement->bind_param('s', $email);
                $statement->bind_result($total);
                $statement->execute();
                $statement->fetch();    
                $statement->close();
                if ($total>0) {
                    echo "<div class='alert'>email já existe!</div>";
                }
                else{
                    $query = "select count(*) from utils where nomeutil=?";
                    $statement = $ligacao->prepare($query);
                    $statement->bind_param('s', $usern);
                    $statement->bind_result($total);
                    $statement->execute();
                    $statement->fetch();    
                    $statement->close();
                    if ($total==0) {
                        if($password!=$rpassword){
                            echo "<div class='alert'>password não coincide!</div>";
                        }
                        else{
                            $passwordhash= password_hash($password,PASSWORD_DEFAULT);
                            $query = "insert into utils(nome,pass,email,tipo,telefone,nomeutil) values(?,?,?,?,?,?)";
                            $statement2 = $ligacao->prepare($query);
                            $statement2->bind_param('sssiss',$name, $passwordhash, $email,$tipoo,$telefone,$usern);
                            if ($statement2->execute() && $statement2->affected_rows>0) {
                                $_SESSION["nid"]=session_id();
                                $_SESSION["usern"]=$usern;
                                $_SESSION["tipo"]=$tipoo;
                                $_SESSION["email"]=$email;
                                header("location: perfil.php");
                               
                            } 
                            $statement2->close();
                        }
                    }
                else{
                    echo "<div class='alert'>nick já existe!</div>";
                }
                }
            }
            //Login
            if (isset($_POST["Login"])) {
                $qr = "select pass,tipo,email,nomeutil from utils where email=?";		
                $ordem = $ligacao->prepare($qr);				
                $ordem->bind_param('s', $_POST["email1"]);
                $ordem->execute();
                $ordem->bind_result($passor, $tip,$email,$nomeutil);
                if($ordem->fetch()){
                    if (password_verify($_POST["pass1"],$passor)){
                        $_SESSION["usern"]=$nomeutil;
                        $_SESSION["tipo"]=$tip;
                        $_SESSION["email"]=$email;
                        header("Refresh:0");
                    }
                    else echo "<div class='alert'>Pass/Email dont matches!!</div>";
                }
                else{
                    echo "<div class='alert'>Pass/Email dont matches!</div>";
                }	
                $ordem->close();
            }
            $ligacao->close();
        ?>

            <!-- Modal -->
            <script>
                function modarpos(a){
                    var x = document.getElementById("flog");
                    var y = document.getElementById("freg");
                    if (a == 1) {
                        x.style.display = "block";
                        y.style.display = "none";
                    } else {
                        x.style.display = "none";
                        y.style.display = "block";
                    }
                }
            </script>
            <style>
               
				
            </style>
            <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content d-flex justify-content-center">
						
                        
                      <div class="container-login100" >
							<div class="modal-header" style="border-bottom:none;background-color:#fff3e3">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="border:none;height:5px;" >
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
                        <div class="wrap-login100 p-l-55 p-r-55 p-t-80 p-b-30">
                          <form class="login100-form validate-form" id="flog" method="post">
                            <span class="login100-form-title p-b-37">
                              Login
                            </span>

                            <div class="wrap-input100 validate-input m-b-20" data-validate="Insere um email válido!">
                              <input class="input100" type="email" name="email1" placeholder="email">
                              <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 validate-input m-b-25" data-validate = "Introduz a password!">
                              <input class="input100" type="password" name="pass1" placeholder="password">
                              <span class="focus-input100"></span>
                            </div>

                            <div class="container-login100-form-btn ">
                              <input type="submit" name="Login" value="Login" class="login100-form-btn logs">
                            </div>

                            <br>

                            <div class="text-center">
                              <a href="#" class="txt2 hov1" onclick="modarpos(2)">
                                Ainda não tens conta? Regista-te aqui.
                              </a>
                            </div>
                          </form>
                          <form class="login100-form validate-form" id="freg" method="post" style="display:none;">
                            <span class="login100-form-title p-b-37">
                              Registar
                            </span>

                            <div class="wrap-input100 validate-input m-b-20" data-validate="Insere o teu nome!">
                              <input class="input100" type="text" name="nome" placeholder="nome" required>
                              <span class="focus-input100"></span>
                            </div>
                            <div class="wrap-input100 validate-input m-b-20" data-validate="Insere um nickname válido!">
                              <input class="input100" type="text" name="usern" placeholder="nickname" required>
                              <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 validate-input m-b-20" data-validate="Insere um email válido!">
                              <input class="input100" type="email" name="email" placeholder="email" required>
                              <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 validate-input m-b-25" data-validate = "Insere um número válido!">
                              <input class="input100" type="text" minlenght="9" name="telefone" placeholder="telefone" required>
                              <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 validate-input m-b-25" data-validate = "Insere uma password válida!">
                              <input class="input100" type="password" minlenght="8" name="pass" placeholder="password" required>
                              <span class="focus-input100"></span>
                            </div>

                            <div class="wrap-input100 validate-input m-b-25" data-validate = "Password não combina!">
                              <input class="input100" type="password"  name="rpass" placeholder="repita a password" required>
                              <span class="focus-input100"></span>
                            </div>

                            <div class="container-login100-form-btn">
                              <input type="submit" name="Register" value="Registar" class="login100-form-btn logs">
                            </div>
                            
                            <br>

                            <div class="text-center">
                              <a href="#" class="txt2 hov1" onclick="modarpos(1)">
                                Já tens conta? Login aqui.
                              </a>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
