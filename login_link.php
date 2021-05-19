<?php
// check if user is logged (or has permanent login)
$inst_login = new Login();
$inst_login->isUserLogged();

if($inst_login->user_logged) {
  //echo "<a class='nav-link' id='login-item' data-logged='true' href='' data-bs-target='#myModal' data-bs-toggle='modal'><i class='fa fa-fw fa-user' style='size:1.5em'></i>".$_SESSION['name']."</a>";
  echo "<a class='nav-link' style='cursor:pointer;' id='login-item' data-logged='true' data-bs-toggle='collapse' data-bs-target='#user-menu' aria-expanded='false' aria-controls='user-menu'><i class='fa fa-fw fa-user' style='size:1.5em'></i>".$_SESSION['name']."</a>";
}
else {
  //echo "<a class='nav-link' style='cursor:pointer;' id='login-item' data-logged='false' href='./login_form.php' data-bs-target='#myModal' data-bs-toggle='modal'><i class='fa fa-fw fa-user' style='size:1.5em'></i>Přihlásit</a>";
  echo "<a class='nav-link' href='./login_form.php' style='color:black;'><i class='fa fa-fw fa-user' style='size:1.5em'></i>Přihlásit</a>";
}


?>
