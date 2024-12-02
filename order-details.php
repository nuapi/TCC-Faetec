<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

// Verificar se o ID do pedido foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('location: account.php');
    exit;
}

$pedido_id = $_GET['id'];

try {
    $db = new PDO("mysql:host=localhost;dbname=tcc;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Buscar detalhes do pedido
    $stmt_pedido = $db->prepare("SELECT * FROM pedido WHERE idpedido = ? AND cliente_idcliente = ?");
    $stmt_pedido->execute([$pedido_id, $_SESSION['idcliente']]);
    $pedido = $stmt_pedido->fetch(PDO::FETCH_ASSOC);
    
    if (!$pedido) {
        header('location: account.php');
        exit;
    }
    
    // Buscar itens do pedido
    $stmt_itens = $db->prepare("SELECT ip.*, p.prod_nome, p.prod_preco 
                                 FROM itempedido ip 
                                 JOIN produto p ON ip.produto_idproduto = p.idproduto 
                                 WHERE ip.pedido_idpedido = ?");
    $stmt_itens->execute([$pedido_id]);
    $itens = $stmt_itens->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    error_log("Erro ao buscar detalhes do pedido: " . $e->getMessage());
    $error_message = "Erro ao carregar detalhes do pedido. Por favor, tente novamente mais tarde.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Incluir os mesmos links CSS do account.php -->
    <title>Detalhes do Pedido</title>
</head>
<body>
    <?php include('header.php'); ?>
    
    <div class="container">
        <h2>Detalhes do Pedido #<?php echo htmlspecialchars($pedido['idpedido']); ?></h2>
        
        <div class="order-details">
            <h3>Informações do Pedido</h3>
            <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($pedido['data'])); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($pedido['statuspedido']); ?></p>
            <p><strong>Valor Total:</strong> R$ <?php echo number_format($pedido['valorliqbruto'], 2, ',', '.'); ?></p>
            
            <h3>Itens do Pedido</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Preço Unitário</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($itens as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['prod_nome']); ?></td>
                            <td><?php echo htmlspecialchars($item['qnt']); ?></td>
                            <td>R$ <?php echo number_format($item['precounitario'], 2, ',', '.'); ?></td>
                            <td>R$ <?php echo number_format($item['qnt'] * $item['precounitario'], 2, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <a href="account.php" class="btn btn-default">Voltar para Minha Conta</a>
    </div>
    
    <?php include('footer.php'); ?>
</body>
</html>