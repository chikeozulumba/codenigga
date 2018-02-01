<?php 
 require_once $_SERVER['DOCUMENT_ROOT'].'/AC/server/core/init.php';
 require('./class/UserService.php');

 if ($_POST['email'] && $_POST['password']) {
    $email = mysqli_real_escape_string($db, $_POST["email"]);
    $password = mysqli_real_escape_string($db, $_POST["password"]);
    $user = new UserLogin($pdo, $email, $password);
    $userLogin = $user->Login();
    echo $userLogin;
 } else {
      return 'Unauthorized to proceed';
 }


?>