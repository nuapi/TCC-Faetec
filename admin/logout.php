<?php

session_start();

if(isset($_GET['logout']) && $_GET['logout'] == 1){
    if(isset($_SESSION['admin_logged_in'])){
      unset($_SESSION['admin_logged_in']);
      unset($_SESSION['adm_email']);
      unset($_SESSION['adm_nome']);
      header('location: login.php');
      exit;
    }
  }
  ?>