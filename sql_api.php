<?php session_start();
  require_once("sqlPDO.php");
  require_once("login.php");

// logout user
if($_GET['q']==='logout') {
  $inst = new Login();
  $logout = $inst->logoutUser();
  if($logout === true) {
    return true;
  }
  else {
    return false;
  }
}

// register new user
if($_GET['q']==='register_user') {
  // check if there was a delay at least 3 seconds between page load and filling out the form
  if(time() > $_SESSION['form_time_generated'] + 3) {
    $sql_pdo = new Login();
    $user_data = json_decode(file_get_contents('php://input'), true);
    $nickname = filter_var($user_data['nickname'], FILTER_SANITIZE_STRING);
    $email = filter_var($user_data['email'], FILTER_SANITIZE_STRING);
    $pass = filter_var($user_data['pass'], FILTER_SANITIZE_STRING);
    $res = $sql_pdo->registerUser($nickname, $email, $pass);
    echo $res;
  }
}

?>
