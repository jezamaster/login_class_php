<?php session_start();
// fetching class sqlPDO where I am using dtb connection
require_once("sqlPDO.php"); 

// extening the sqlPDO class so that I can easily use its PDO connection (this Login class can be also used as a stand-alone class, just a PDO connection would have to be added as a constructor of this class)
class Login extends sqlPDO {

  function isUserLogged() {
    if(isset($_SESSION['user_id'])) {
      $this->user_logged = true;
    }
    elseif($this->checkPermanentLogin()) {
      $this->user_logged = true;
    }
    else {
      $this->user_logged = false;
    }
  }

  function setSessions($user_id, $name, $user_name) {
    $_SESSION['user_id'] = $user_id;
    $_SESSION['name'] = $name;
    $_SESSION['user_name'] = $user_name;
  }

  function unsetSessions() {
    unset($_SESSION['user_id']);
    unset($_SESSION['name']);
    unset($_SESSION['user_name']);
  }

  function generateToken($length = 20) {
    return bin2hex(random_bytes($length));
  }

  function checkPermanentLogin() {
    // check if permanent login is set, get user data
    $permanent_login = false;
    if(isset($_COOKIE['permuserid']) && $_COOKIE['permusertoken'] !='') {
      $token = $this->getUserToken($_COOKIE['permuserid']);
      if(password_verify($_COOKIE['permusertoken'], $token)) {
        $user_data = $this->getUserData($this->getUserByID($_COOKIE['permuserid']));
        setSessions($user_data[0]['id'], $user_data[0]['name'], $user_data[0]['user_name']);
        // update the user's number of visits
        $this->updateLoginStats();
        return true;
      }
    }
    // else return false
    return false;
  }

  // return all user data if the user exists
  function getUserData($email) {
    // first check if user exists
    if($this->checkUser($email)) { 
      $dotaz = $this->pdo->prepare("select * from users where user_name =:email");
      $dotaz->bindParam(":email", $email);
      $dotaz->execute();
      $data = $dotaz->fetchAll();
      return $data;
    }
    else {
      return false;
    }
  }
  
  // get user email by user_id
  function getUserByID($user_id) {
     $dotaz = $this->pdo->prepare("select user_name from users where id =:user_id");
     $dotaz->bindParam(":user_id", $user_id);
     $dotaz->execute();
     return $dotaz->fetchColumn();
  }
  
  // get user token for control of cookie permanent login
  function getUserToken($user_id) {
    $dotaz = $this->pdo->prepare("select token from auth_token where user_id =:user_id");
    $dotaz->bindParam(":user_id", $user_id);
    $dotaz->execute();
    return $dotaz->fetchColumn();    
  }
  
  // delete user token 
  function deleteToken($user_id) {
    $dotaz = $this->pdo->prepare("delete from auth_token where user_id =:user_id");
    $dotaz->bindParam("user_id", $user_id);
    $odtaz->execute();
  }
  
  // update just logged user's last login and number of logins
  function updateLoginStats() {
    $dotaz = $this->pdo->prepare("update users set last_login = now(), number_of_logins = number_of_logins + 1 where id=:user_id");
    $dotaz->bindParam(":user_id", $_SESSION['user_id']);
    $dotaz->execute();
  }
 
  // log in the user based on the sent user name and password
  function loginUser($user_name, $password) { 
    $email = filter_var(trim($user_name), FILTER_SANITIZE_EMAIL);
    $user_data = $this->getUserData($email);
    // check if password matches
    if(password_verify($password, $user_data[0]['password'])) {  
      // set sessions and return true
      $this->setSessions($user_data[0]['id'], $user_data[0]['name'], $user_data[0]['user_name']);
      // update user's visits
      // $this->updateLoginStats();
      return true;
    }
    else {
      return false;
    }
  }
  
   // check if user email exists
  function checkUser($email) {
    $dotaz = $this->pdo->prepare("select * from users where user_name = :user_name");
    $dotaz->bindParam(":user_name", $email);
    $dotaz->execute();
    if($dotaz->rowCount() > 0) {
      // if user exists, return true
      return true;
    }
    else {
      return false;
    }
  }
  
  // register user
  function registerUser($name, $email, $password) { 
   // first check if user exists, if so, quit function
   if($this->checkUser($email)===false) {
     try {
         // hash password and register user
         $pass = password_hash($password, PASSWORD_DEFAULT);
         $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
         $name = filter_var(trim($name), FILTER_SANITIZE_SPECIAL_CHARS);

         $dotaz = $this->pdo->prepare("insert into users (name, user_name, password, registration_date) values (:name, :user_name, :password, now())");
         $dotaz->bindParam(":name", $name);
         $dotaz->bindParam(":user_name", $email);
         $dotaz->bindParam(":password", $pass);
         $dotaz->execute();
         return true;
     }
     catch(PDOException $e) {
         echo "Error: " . $e->getMessage();
     }
   } 
   else {
     return false;
   }
  }


}

?>
