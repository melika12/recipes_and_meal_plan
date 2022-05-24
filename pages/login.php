<?php 
include('./navbar.php');
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="../js/login.js"></script>
<div class="position-relative overflow-hidden p-3 p-md-1 m-md-1 text-center md-light">
  <div class="col-md-5 p-lg-5 mx-auto my-5">
    <h1 class="display-4 fw-normal">M&Ms</h1>
    <p class="lead fw-normal">Log ind og registrering</p>
  </div>
  <div class="container">
      <div class="row">
          <div class="col-md-5 mx-auto">
              <div id="first">
                  <div class="myform form ">
                      <div class="logo mb-3">
                          <div class="col-md-12 text-center">
                              <h1>Log ind</h1>
                            </div>
                        </div>
                        <form action="" method="post" name="login">
                            <div class="form-group">
                                <label for="username">Brugernavn</label>
                                <input type="text" name="username"  class="form-control" id="username" aria-describedby="usernameHelp" placeholder="Indtast brugernavn">
                            </div>
                            <div class="form-group">
                                <label for="password">Kodeord</label>
                                <input type="password" name="password" id="password"  class="form-control" aria-describedby="passwordHelp" placeholder="Indtast kodeord">
                            </div>
                    <div class="form-group">
                        <p class="text-center">Ved at registrere dig, acceptere du samtidig vores <a href="#">Vilkår For Brug</a></p>
                    </div>
                    <div class="col-md-12 text-center ">
                        <button type="submit" class=" btn btn-block mybtn btn-primary">Log ind</button>
                    </div>
                    <div class="col-md-12">
                        <div class="login-or"></div>
                    </div>
                    <div class="form-group">
                        <p class="text-center">Har du ikke en bruger? <a href="#" onclick="signUp();return false;" id="signup">Registrere dig her</a></p>
                    </div>
                </form>
            </div>
        </div>
        <div id="second">
            <div class="myform form ">
                <div class="logo mb-3">
                    <div class="col-md-12 text-center">
                        <h1 >Registrering</h1>
                    </div>
                </div>
                <form action="./validate.php" method="POST" name="registration">
                    <div class="form-group">
                        <label for="username">Brugernavn</label>
                        <input type="text" name="username"  class="form-control" id="username" aria-describedby="emailHelp" placeholder="Indtast brugernavn">
                    </div>
                    <div class="form-group">
                        <label for="password">Kodeord</label>
                        <input type="password" name="password" id="password"  class="form-control" aria-describedby="passwordHelp" placeholder="Indtast kodeord">
                    </div>
                    <div class="form-group">
                        <label for="repeatedPassword">Gentag kodeord</label>
                        <input type="password" name="repeatedPassword" id="repeatedPassword"  class="form-control" aria-describedby="passwordHelp" placeholder="Gentag kodeord">
                    </div>
                    <div class="col-md-12 text-center mb-3">
                        <button type="submit" class=" btn btn-block mybtn btn-primary">Registrere mig</button>
                    </div>
                    <div class="col-md-12 ">
                        <div class="form-group">
                            <p class="text-center"><a href="#" onclick="logIn(); return false;" id="signin">Har du allerede en bruger?</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>   