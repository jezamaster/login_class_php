<?php session_start(); 
// set timer session against robots filling out forms
$_SESSION['timer'] = time();
 require_once("login.php");
 $instLogin = new Login();
 // if login form sent
 if(isset($_POST['email'])) { 
   // if permanent login checked
   $permanent_login = ($_POST['remember-me'] === "checked") ? true : false;
   $login = $instLogin->loginUser($_POST['email'], $_POST['password'], $permanent_login);
   if($login === true) {
     header("Location: http://www.czechtop.cz/main.php");
   }
   else {
     // echo incorrect login
     echo "Login NOT ok";
   }
 }
 
?>

<html>
<body>
<form action="./login_form.php" method="post">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" id="email" name="email" placeholder="Zadejte vaší emailovou adresu" />
          </div>
          <div class="mb-3">
            <label class="form-label">Heslo</label>
            <input class="form-control" type="password" id="pass" name="password" placeholder="Zadejte heslo (min. 8 znaků, min. 1 velké písmeno a 1 číslice)" />
          </div>
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-block btn-success">Přihlásit</button>
          </div>
          <!--<div class="text-center mt-4"> -->
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="checked" name="remember-me" id="remember-me" checked />
              <label class="form-check-label" for="remember-me"> Zůstat přihlášen </label>
            </div>
          <!-- </div> -->
          <div class="text-center text-muted mt-2">
            <a href="#">Zapoměl jsem heslo</a>
          </div>
 </form>
</body>
</html>
