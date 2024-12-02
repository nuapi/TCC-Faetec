<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

// Conexão com o banco de dados
try {
    $db = new PDO("mysql:host=localhost;dbname=tcc;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Buscar informações do cliente
    $stmt = $db->prepare("SELECT * FROM cliente WHERE idcliente = ?");
    $stmt->execute([$_SESSION['idcliente']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Buscar endereços do cliente
    $stmt_enderecos = $db->prepare("SELECT * FROM endereco WHERE cliente_idcliente = ?");
    $stmt_enderecos->execute([$_SESSION['idcliente']]);
    $enderecos = $stmt_enderecos->fetchAll(PDO::FETCH_ASSOC);
    
    // Buscar pedidos do cliente
    $stmt_pedidos = $db->prepare("SELECT * FROM pedido WHERE cliente_idcliente = ? ORDER BY data DESC");
    $stmt_pedidos->execute([$_SESSION['idcliente']]);
    $pedidos = $stmt_pedidos->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    error_log("Erro ao buscar informações: " . $e->getMessage());
    $error_message = "Erro ao carregar informações. Por favor, tente novamente mais tarde.";
}

//Logout
if(isset($_GET['logout'])){
  if(isset($_SESSION['logged_in'])){
    unset($_SESSION['logged_in']);
    unset($_SESSION['cli_email']);
    unset($_SESSION['cli_nome']);
    header('location: login.php');
    exit;
  }
}

// Processamento da alteração de senha
if (isset($_POST['change_password'])) {
    // Validar se todos os campos foram preenchidos
    if (empty($_POST['current_password']) || empty($_POST['new_password']) || empty($_POST['confirm_password'])) {
        $error_message = "Todos os campos são obrigatórios!";
    } else {
        $current_password = trim($_POST['current_password']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);
        
        try {
            $db = new PDO("mysql:host=localhost;dbname=tcc;charset=utf8mb4", "root", "");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Verificar senha atual
            $stmt = $db->prepare("SELECT senha FROM cliente WHERE email = ?");
            $stmt->execute([$_SESSION['cli_email']]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($current_password, $user['senha'])) {
                if ($new_password === $confirm_password) {
                    // Verificar se a nova senha tem pelo menos 8 caracteres
                    if (strlen($new_password) < 8) {
                        echo '<div class="alert alert-danger">A nova senha deve ter pelo menos 8 caracteres!</div>';
                    } else {
                        // Atualizar senha
                        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                        $stmt = $db->prepare("UPDATE cliente SET senha = ? WHERE email = ?");
                        if ($stmt->execute([$hashed_password, $_SESSION['cli_email']])) {
                            echo '<div class="alert alert-success">Senha atualizada com sucesso!</div>';
                            // Limpar o formulário após sucesso
                            echo '<script>
                                document.getElementById("passwordForm").reset();
                                document.getElementById("change-password-form").style.display = "none";
                            </script>';
                        } else {
                            echo '<div class="alert alert-danger">Erro ao atualizar senha. Tente novamente.</div>';
                        }
                    }
                } else {
                    echo '<div class="alert alert-danger">As senhas não correspondem!</div>';
                }
            } else {
                echo '<div class="alert alert-danger">Senha atual incorreta!</div>';
            }
        } catch (PDOException $e) {
            error_log("Erro na alteração de senha: " . $e->getMessage());
            echo '<div class="alert alert-danger">Erro ao atualizar senha. Por favor, tente novamente mais tarde.</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>My Account | Metronic Shop UI</title>

  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <meta content="Metronic Shop UI description" name="description">
  <meta content="Metronic Shop UI keywords" name="keywords">
  <meta content="keenthemes" name="author">

  <meta property="og:site_name" content="-CUSTOMER VALUE-">
  <meta property="og:title" content="-CUSTOMER VALUE-">
  <meta property="og:description" content="-CUSTOMER VALUE-">
  <meta property="og:type" content="website">
  <meta property="og:image" content="-CUSTOMER VALUE-">
  <meta property="og:url" content="-CUSTOMER VALUE-">

  <link rel="shortcut icon" href="favicon.ico">

  <!-- Fonts START -->
  <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css"> 
  <!-- Fonts END -->

  <!-- Global styles START -->          
  <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Global styles END --> 
   
  <!-- Page level plugin styles START -->
  <link href="assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
  <link href="assets/plugins/owl.carousel/assets/owl.carousel.css" rel="stylesheet">
  <!-- Page level plugin styles END -->

  <!-- Theme styles START -->
  <link href="assets/pages/css/components.css" rel="stylesheet">
  <link href="assets/corporate/css/style.css" rel="stylesheet">
  <link href="assets/pages/css/style-shop.css" rel="stylesheet" type="text/css">
  <link href="assets/corporate/css/style-responsive.css" rel="stylesheet">
  <link href="assets/corporate/css/themes/red.css" rel="stylesheet" id="style-color">
  <link href="assets/corporate/css/custom.css" rel="stylesheet">
  <!-- Theme styles END -->

  <style>
    .password-change-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin: 20px 0;
    }
    
    .password-change-section form {
        max-width: 400px;
    }
    
    .form-group {
        margin-bottom: 15px;
    }
    
    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .alert {
        padding: 10px;
        margin: 10px 0;
        border-radius: 4px;
    }
    
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
  </style>
</head>

<body class="ecommerce">
    <!-- BEGIN STYLE CUSTOMIZER -->
    <div class="color-panel hidden-sm">
      <div class="color-mode-icons icon-color"></div>
      <div class="color-mode-icons icon-color-close"></div>
      <div class="color-mode">
        <p>THEME COLOR</p>
        <ul class="inline">
          <li class="color-red current color-default" data-style="red"></li>
          <li class="color-blue" data-style="blue"></li>
          <li class="color-green" data-style="green"></li>
          <li class="color-orange" data-style="orange"></li>
          <li class="color-gray" data-style="gray"></li>
          <li class="color-turquoise" data-style="turquoise"></li>
        </ul>
      </div>
    </div>
    <!-- END BEGIN STYLE CUSTOMIZER --> 

    <?php 
    include('header.php');
    ?>
    
    <div class="main">
      <div class="container">
        <ul class="breadcrumb">
            <li><a href="shop-index.php">Início</a></li>
            <li><a href="shop-product-list.php">Loja</a></li>
            <li class="active">Minha Conta</li>
        </ul>
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN SIDEBAR -->
          <div class="sidebar col-md-3 col-sm-3">
            <ul class="list-group margin-bottom-25 sidebar-menu">
              <li class="list-group-item clearfix"><a href="javascript:;"><i class="fa fa-angle-right"></i> Editar Informações</a></li>
              <li class="list-group-item clearfix"><a href="javascript:;" id="changePasswordLink"><i class="fa fa-angle-right"></i> Alterar Senha</a></li>
              <li class="list-group-item clearfix"><a href="javascript:;"><i class="fa fa-angle-right"></i> Meus Pedidos</a></li>
              <li class="list-group-item clearfix"><a href="javascript:;"><i class="fa fa-angle-right"></i> Estornos</a></li>
              <li class="list-group-item clearfix"><a href="account.php?logout=1" id="logout-btn"><i class="fa fa-angle-right"></i> Sair</a></li>
            </ul>
          </div>
          <!-- END SIDEBAR -->

          <!-- BEGIN CONTENT -->
          <div class="col-md-9 col-sm-7">
            <p style="color: green"><?php if (isset($_GET['register_success'])){ echo $_GET['register_success']; }?></p>
            <p style="color: green"><?php if (isset($_GET['login_success'])){ echo $_GET['login_success']; }?></p>
            <h1>Minha Conta</h1>
            <div class="content-page">
                <h3>Olá, <?php if(isset($_SESSION['cli_nome'])){ echo $_SESSION['cli_nome'];} ?></h3>

                <div id="user-info-section">
    <h3>Informações Pessoais</h3>
    <p><strong>Nome:</strong> <?php echo htmlspecialchars($user['cli_nome']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['cli_email']); ?></p>
    
    <h3>Meus Endereços</h3>
    <?php if (!empty($enderecos)): ?>
        <?php foreach ($enderecos as $endereco): ?>
            <div class="endereco-item">
                <p>
                    <strong>Rua:</strong> <?php echo htmlspecialchars($endereco['rua']); ?>, 
                    <?php echo htmlspecialchars($endereco['num']); ?> - 
                    <?php echo htmlspecialchars($endereco['bairro']); ?>
                </p>
                <p>
                    <strong>CEP:</strong> <?php echo htmlspecialchars($endereco['cep']); ?>, 
                    <strong>Cidade:</strong> <?php echo htmlspecialchars($endereco['cidade']); ?>, 
                    <strong>Estado:</strong> <?php echo htmlspecialchars($endereco['estado']); ?>
                </p>
                <?php if ($endereco['endprincipal'] == 'S'): ?>
                    <span class="badge badge-primary">Endereço Principal</span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum endereço cadastrado.</p>
    <?php endif; ?>
    
    <h3>Meus Pedidos</h3>
    <?php if (!empty($pedidos)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Número do Pedido</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Valor Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pedido['idpedido']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($pedido['data'])); ?></td>
                        <td><?php echo htmlspecialchars($pedido['statuspedido']); ?></td>
                        <td>R$ <?php echo number_format($pedido['valorliqbruto'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="order-details.php?id=<?php echo $pedido['idpedido']; ?>" class="btn btn-sm btn-info">Detalhes</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Você ainda não realizou nenhum pedido.</p>
    <?php endif; ?>
</div>
<style>
    .endereco-item {
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 4px;
}

.table {
    width: 100%;
    margin-bottom: 20px;
}

.table th, .table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.badge-primary {
    background-color: #007bff;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
}

</style>
                
                <!-- Formulário de alteração de senha (inicialmente oculto) -->
                <div id="change-password-form" class="password-change-section" style="display: none;">
                    <h4>Alterar Senha</h4>
                    <form method="POST" action="" id="passwordForm">
                        <div class="form-group">
                            <label for="current_password">Senha Atual</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="new_password">Nova Senha</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="confirm_password">Confirmar Nova Senha</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" name="change_password">Alterar Senha</button>
                        <button type="button" class="btn btn-default" id="cancelPasswordChange">Cancelar</button>
                    </form>
                </div>
                <hr>
                <ul>
                    <li><a href="javascript:;">Ver pedidos</a></li>
                    <li><a href="javascript:;" id="changePasswordLink">Mudar senha</a></li>
                    <li><a href="shop-shopping-cart.php">Carrinho</a></li>
                    <li><a href="account.php?logout=1" id="logout-btn">Sair</a></li>
                </ul>
            </div>
          </div>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
      </div>
    </div>

    <!-- BEGIN BRANDS -->
    <div class="brands">
      <div class="container">
            <div class="owl-carousel owl-carousel6-brands">
              <a href="shop-product-list.php"><img src="./assets/pages/img/brands/filizola.png" alt="filizola" title="filizola"></a>
              <a href="shop-product-list.html"><img src="./assets/pages/img/brands/toledo.png" alt="toledo" title="toledo"></a>
              <a href="shop-product-list.html"><img src="./assets/pages/img/brands/weightech.jpg" alt="weightech" title="weightech"></a>
              <a href="shop-product-list.html"><img src="./assets/pages/img/brands/urano.png" alt="urano" title="urano"></a>
              <a href="shop-product-list.html"><img src="./assets/pages/img/brands/triunfo.png" alt="triunfo" title="triunfo"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/digitron.png" alt="digitron" title="digitron"></a>
            </div>
        </div>
    </div>
    <!-- END BRANDS -->

    <?php 
    include('footer.php');
    ?>

    <!-- Load javascripts at bottom, this will reduce page load time -->
    <!-- BEGIN CORE PLUGINS(REQUIRED FOR ALL PAGES) -->
    <!--[if lt IE 9]>
    <script src="assets/plugins/respond.min.js"></script>  
    <![endif]-->  
    <script src="assets/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>      
    <script src="assets/corporate/scripts/back-to-top.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="assets/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->
    <script src="assets/plugins/owl.carousel/owl.carousel.min.js" type="text/javascript"></script><!-- slider for products -->

    <script src="assets/corporate/scripts/layout.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            Layout.init();    
            Layout.initOWL();
            Layout.initTwitter();
        });
    </script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const changePasswordLink = document.getElementById('changePasswordLink');
    const changePasswordForm = document.getElementById('change-password-form');
    const cancelButton = document.getElementById('cancelPasswordChange');
    const passwordForm = document.getElementById('passwordForm');

    // Mostrar formulário ao clicar no link
    changePasswordLink.addEventListener('click', function(e) {
        e.preventDefault();
        changePasswordForm.style.display = 'block';
    });

    // Esconder formulário ao clicar em cancelar
    cancelButton.addEventListener('click', function() {
        changePasswordForm.style.display = 'none';
    });

    // Validação do formulário
    passwordForm.addEventListener('submit', function(e) {
        const newPassword = document.getElementById('new_password').value;
        const confirmPassword = document.getElementById('confirm_password').value;

        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert('As senhas não correspondem!');
        }
    });
});
</script>
</body>
</html>