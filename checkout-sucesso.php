<?php
// Iniciar sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se há um ID de pedido na URL
if (!isset($_GET['pedido_id'])) {
    header('Location: index.php');
    exit;
}

$pedido_id = $_GET['pedido_id'];

try {
    // Conectar ao banco de dados
    $db = new PDO("mysql:host=localhost;dbname=tcc;charset=utf8mb4", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buscar detalhes do pedido
    $stmt = $db->prepare("
        SELECT p.idpedido, p.data, p.valorliqbruto, 
               c.nome AS cliente_nome, 
               f.metodo AS metodo_pagamento
        FROM pedido p
        JOIN cliente c ON p.cliente_idcliente = c.idcliente
        JOIN formadepagamento f ON p.idpedido = f.pedido_idpedido
        WHERE p.idpedido = ?
    ");
    $stmt->execute([$pedido_id]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    // Buscar itens do pedido
    $stmt = $db->prepare("
        SELECT pr.nome, ip.qnt, ip.precounitario
        FROM itempedido ip
        JOIN produto pr ON ip.produto_idproduto = pr.idproduto
        WHERE ip.pedido_idpedido = ?
    ");
    $stmt->execute([$pedido_id]);
    $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    error_log($e->getMessage());
    header('Location: index.php');
    exit;
}

include('header.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Finalizado</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="./assets/pages/css/style2.css" rel="stylesheet">
    <style>
        .success-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .success-icon {
            color: #28a745;
            font-size: 80px;
            margin-bottom: 20px;
        }

        .success-message {
            margin-bottom: 30px;
        }

        .order-details {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            text-align: left;
        }

        .order-details h3 {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .total-line {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-top: 1px solid #ddd;
        }

        .btn-continue {
            display: inline-block;
            background-color: #ff0000;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .btn-continue:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>

        <div class="success-message">
            <h1>Pedido Concluído com Sucesso!</h1>
            <p>Obrigado por comprar conosco, <?php echo htmlspecialchars($pedido['cliente_nome']); ?>.</p>
            <p>Seu pedido #<?php echo $pedido_id; ?> foi processado e está sendo preparado.</p>
        </div>

        <div class="order-details">
            <h3>Detalhes do Pedido</h3>
            
            <div class="order-items">
                <?php foreach ($itens as $item): ?>
                    <div class="order-item">
                        <span><?php echo htmlspecialchars($item['nome']); ?> (<?php echo $item['qnt']; ?>x)</span>
                        <span>R$ <?php echo number_format($item['precounitario'] * $item['qnt'], 2, ',', '.'); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="total-line subtotal">
                <span>Subtotal:</span>
                <span>R$ <?php 
                    $subtotal = $pedido['valorliqbruto'] - 50.00; // Subtraindo o frete
                    echo number_format($subtotal, 2, ',', '.');
                ?></span>
            </div>

            <div class="total-line frete">
                <span>Frete:</span>
                <span>R$ 50,00</span>
            </div>

            <div class="total-line total">
                <strong>Total:</strong>
                <strong>R$ <?php echo number_format($pedido['valorliqbruto'], 2, ',', '.'); ?></strong>
            </div>

            <div class="payment-method">
                <p><strong>Método de Pagamento:</strong> 
                    <?php 
                    $metodos = [
                        'pix' => 'PIX',
                        'cartao' => 'Cartão de Crédito',
                        'boleto' => 'Boleto Bancário'
                    ];
                    echo $metodos[$pedido['metodo_pagamento']] ?? $pedido['metodo_pagamento']; 
                    ?>
                </p>
            </div>
        </div>

        <a href="index.php" class="btn-continue">Continuar Comprando</a>
    </div>
</body>
</html>