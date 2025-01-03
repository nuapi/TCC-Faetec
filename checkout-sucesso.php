<?php
// Iniciar sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'checkout-validation.php';

// Verificar se existe informação do pedido na sessão
if (!isset($_SESSION['ultimo_pedido'])) {
    header('Location: shop-product-list.php');
    exit();
}

// Conexão com o banco de dados
$db = new PDO("mysql:host=localhost;dbname=tcc;charset=utf8mb4", "root", "");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Preparar os dados para exibição
$order = [
    'idpedido' => $_SESSION['ultimo_pedido']['idpedido'] ?? 'N/A',
    'data' => $_SESSION['ultimo_pedido']['data'],
    'valorliqbruto' => $_SESSION['ultimo_pedido']['valor_total'],
    'statuspedido' => $_SESSION['ultimo_pedido']['status'],
    'metodo_pagamento' => $_SESSION['ultimo_pedido']['metodo_pagamento'],
    // Dados do endereço
    'rua' => $_SESSION['ultimo_pedido']['endereco']['rua'],
    'num' => $_SESSION['ultimo_pedido']['endereco']['num'],
    'bairro' => $_SESSION['ultimo_pedido']['endereco']['bairro'],
    'cidade' => $_SESSION['ultimo_pedido']['endereco']['cidade'],
    'estado' => $_SESSION['ultimo_pedido']['endereco']['estado'],
    'cep' => $_SESSION['ultimo_pedido']['endereco']['cep']
];

// Preparar os itens do pedido
$orderItems = [];
foreach ($_SESSION['ultimo_pedido']['itens'] as $item) {
    $orderItems[] = [
        'prod_nome' => $item['prod_nome'],
        'qnt' => $item['prod_quant'],
        'precounitario' => $item['prod_preco']
    ];
}

// Métodos de pagamento traduzidos
$payment_methods = [
    'pix' => 'PIX',
    'boleto' => 'Boleto Bancário'
];
// O resto do seu HTML permanece o mesmo, mas usando $order e $orderItems
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .success-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
            padding: 30px;
            text-align: center;
        }

        .success-icon {
            color: #28a745;
            font-size: 80px;
            margin-bottom: 20px;
        }

        .order-details {
            text-align: left;
            margin-top: 20px;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }

        .order-items {
            margin-top: 15px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .btn-primary {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="success-container">
        <i class="fas fa-check-circle success-icon"></i>
        <h1>Pedido Confirmado!</h1>
        <p>Agradecemos pela sua compra. Seu pedido foi processado com sucesso.</p>

        <div class="order-details">
            <h2>Detalhes do Pedido</h2>
            <p><strong>Número do Pedido:</strong> #<?php echo $order['idpedido']; ?></p>
            <p><strong>Data:</strong> <?php echo date('d/m/Y', strtotime($order['data'])); ?></p>
            <p><strong>Status:</strong> <?php echo $order['statuspedido']; ?></p>
            <p><strong>Método de Pagamento:</strong> <?php echo $payment_methods[$order['metodo_pagamento']] ?? $order['metodo_pagamento']; ?></p>
            <p><strong>Valor Total:</strong> R$ <?php echo number_format($order['valorliqbruto'], 2, ',', '.'); ?></p>

            <h3>Endereço de Entrega</h3>
            <p>
                <?php echo $order['rua'] . ', ' . $order['num'] . ' - ' . $order['bairro'] . '<br>' . 
                           $order['cidade'] . ' - ' . $order['estado'] . '<br>' . 
                           'CEP: ' . $order['cep']; ?>
            </p>

            <h3>Itens do Pedido</h3>
            <div class="order-items">
                <?php foreach ($orderItems as $item): ?>
                    <div class="order-item">
                        <span><?php echo $item['prod_nome']; ?></span>
                        <span><?php echo $item['qnt'] . 'x R$ ' . number_format($item['precounitario'], 2, ',', '.'); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <a href="shop-product-list.php" class="btn-primary">Continuar Comprando</a>
    </div>

    <?php
    // Limpar os dados do pedido da sessão após exibir
    unset($_SESSION['ultimo_pedido']);
    unset($_SESSION['checkout_completed']);
    ?>
</body>
</html>