<?php
     require_once $_SERVER['DOCUMENT_ROOT'].'/AC/server/core/init.php';
     require('./class/UserService.php');

     $profile = new UserProfile($pdo);
     echo $profile->getData();

?>