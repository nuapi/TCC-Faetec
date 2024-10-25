<?php

session_start();

include('../connection.php');

if(isset($_SESSION['admin_logged_in'])){
  header('location: index.php');
  exit;
}

if (isset($_POST['login_btn'])) {

    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    $stmt = $conn->prepare("SELECT idadm, adm_email, adm_nome, adm_senha FROM administrador WHERE adm_email=? AND adm_senha=? LIMIT 1");
    $stmt->bind_param('ss',$email,$senha);
    if($stmt->execute()){
      $stmt->bind_result($idadm,$adm_email,$adm_nome,$adm_senha);
      $stmt->store_result();

      if($stmt->num_rows() == 1){
        $stmt->fetch();

        $_SESSION['idadm'] = $idadm;
        $_SESSION['adm_email'] = $adm_email;
        $_SESSION['adm_nome'] = $adm_nome;
        $_SESSION['admin_logged_in'] = true;

        header('location: index.php?login_success=Logado com sucesso');
      }else{
        header('location: login.php?error=Conta não encontrada');
      }

    }else{
      //erro
      header('location: login.php?error=Algo deu errado');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Login Page - Product Admin Template</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Roboto:400,700"
    />
    <!-- https://fonts.google.com/specimen/Open+Sans -->
    <link rel="stylesheet" href="css/fontawesome.min.css" />
    <!-- https://fontawesome.com/ -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" href="css/templatemo-style.css">
    <!--
	Product Admin CSS Template
	https://templatemo.com/tm-524-product-admin
	-->
  </head>

  <body>
    <div>
      <nav class="navbar navbar-expand-xl">
        <div class="container h-100">
          <a class="navbar-brand" href="../shop-index.html">
            <h1 class="tm-site-title mb-0">Crispel Etiquetas</h1>
          </a>
        </div>
    </div>

    <div class="container tm-mt-big tm-mb-big">
      <div class="row">
        <div class="col-12 mx-auto tm-login-col">
          <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
            <div class="row">
              <div class="col-12 text-center">
                <h2 class="tm-block-title mb-4">Dashboard do Admin</h2>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-12">
                <form id="login-form" method= "POST" action="login.php">
                <p style="color: red" class= "text-center"><?php if (isset($_GET['error'])){ echo $_GET['error']; }?></p>
                  <div class="form-group">
                    <label>E-mail:</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Digite seu e-mail" required/>
                  </div>
                  <div class="form-group">
                    <label>Senha:</label>
                    <input type="password" class="form-control" id="login-password" name="senha" placeholder="Digite sua senha" required/>
                  </div>
                  <div class="form-group">
                        <input type="submit" class="btn mt-5 btn btn-primary btn-block text-uppercase" id="login-btn" name = "login_btn" value="Entrar"/>
                    </div>
                  <button class="mt-5 btn btn-primary btn-block text-uppercase">
                    Esqueceu sua senha?
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="tm-footer row tm-mt-small">
      <div class="col-12 font-weight-light">
        <p class="text-center text-white mb-0 px-4 small">
          Copyright &copy; <b>2018</b> All rights reserved. 
          
          Design: <a rel="nofollow noopener" href="https://templatemo.com" class="tm-footer-link">Template Mo</a>
        </p>
      </div>
    </footer>
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- https://jquery.com/download/ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- https://getbootstrap.com/ -->
  </body>
</html>
