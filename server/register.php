<?php
     require_once $_SERVER['DOCUMENT_ROOT'].'/AC/server/core/init.php';
     require('./class/UserService.php');

     if ($_POST) {
          // echo $_POST;;
          $email = $_POST;
          $register = new UserRegister($pdo, $email);
          // echo var_dump($_POST['state']);
          echo $register->Register();
          
     } else {
          echo 'false';
     }

?>