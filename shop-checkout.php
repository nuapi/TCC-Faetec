<?php
// Iniciar sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'checkout-validation.php';

// Processar formulário de checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Salvar todos os dados do formulário na sessão primeiro
    $_SESSION['ultimo_pedido'] = [
        'endereco' => [
            'rua' => $_POST['rua'],
            'num' => $_POST['num'],
            'bairro' => $_POST['bairro'],
            'cep' => $_POST['cep'],
            'complemento' => $_POST['complemento'] ?? '',
            'pontoreferencia' => $_POST['pontoreferencia'],
            'cidade' => $_POST['cidade'],
            'estado' => $_POST['estado']
        ],
        'metodo_pagamento' => $_POST['metodo_pagamento'],
        'data' => date('Y-m-d H:i:s'),
        'itens' => $_SESSION['cart'] ?? [],
        'status' => 'Pendente'
    ];

    // Calcular valores
    $subtotal = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['prod_preco'] * $item['prod_quant'];
        }
    }
    $frete = 50.00;
    $total = $subtotal + $frete;
    
    $_SESSION['ultimo_pedido']['valor_total'] = $total;

    try {
        $db = new PDO("mysql:host=localhost;dbname=tcc;charset=utf8mb4", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Iniciar transação
        $db->beginTransaction();
        
        // 1. Salvar endereço
        $stmt = $db->prepare("
            INSERT INTO endereco 
            (rua, num, bairro, cep, complemento, pontoreferencia, endprincipal, cidade, estado, cliente_idcliente) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $_POST['rua'],
            $_POST['num'],
            $_POST['bairro'],
            $_POST['cep'],
            $_POST['complemento'] ?? null,
            $_POST['pontoreferencia'],
            isset($_POST['endprincipal']) ? 'S' : 'N',
            $_POST['cidade'],
            $_POST['estado'],
            $_SESSION['idcliente'] ?? 0
        ]);
        
        $endereco_id = $db->lastInsertId();
        $_SESSION['ultimo_pedido']['endereco_id'] = $endereco_id;

        // 2. Criar pedido
        $stmt = $db->prepare("
            INSERT INTO pedido 
            (data, statuspedido, valorliqbruto, cliente_idcliente, endereco_identrega) 
            VALUES (CURRENT_TIMESTAMP, 'Pendente', ?, ?, ?)
        ");
        
        $stmt->execute([
            $total,
            $_SESSION['idcliente'] ?? 0,
            $endereco_id
        ]);
        
        $pedido_id = $db->lastInsertId();
        $_SESSION['ultimo_pedido']['pedido_id'] = $pedido_id;

        // 3. Inserir itens do pedido
        $stmt = $db->prepare("
            INSERT INTO itempedido 
            (qnt, precounitario, pedido_idpedido, produto_idproduto, pedido_idcliente, produto_idadm) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($_SESSION['cart'] as $item) {
            $stmt->execute([
                $item['prod_quant'],
                $item['prod_preco'],
                $pedido_id,
                $item['idproduto'],
                $_SESSION['idcliente'] ?? 0,
                $item['administrador_idadm']
            ]);
        }

        // 4. Salvar forma de pagamento
        $stmt = $db->prepare("
            INSERT INTO formadepagamento 
            (metodo, valor, data, itemdesconto, pedido_idpedido, pedido_idcliente) 
            VALUES (?, ?, CURRENT_TIMESTAMP, 0, ?, ?)
        ");
        
        $stmt->execute([
            $_POST['metodo_pagamento'],
            $total,
            $pedido_id,
            $_SESSION['idcliente'] ?? 0
        ]);

        // Commit da transação
        $db->commit();
        
        // Limpar carrinho apenas se a transação for bem-sucedida
        unset($_SESSION['cart']);
        
    } catch (Exception $e) {
        // Rollback em caso de erro
        if (isset($db)) {
            $db->rollBack();
        }
        error_log("Erro no checkout: " . $e->getMessage());
    }

    // Redirecionar para página de sucesso independentemente do resultado
    header('Location: checkout-sucesso.php');
    $_SESSION['checkout_completed'] = true;
    exit();
}
?>

<?php 
include('header.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="./assets/pages/css/style2.css" rel="stylesheet">
    <style>
        .checkout-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border:  1px solid #ddd;
            border-radius: 4px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .order-summary {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }

        .order-summary h3 {
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .product-list {
            margin: 15px 0;
        }

        .product-item {
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

        .payment-methods {
            margin: 20px 0;
        }

        .payment-method {
            display: block;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }

        .payment-method input {
            margin-right: 10px;
        }

        .btn-primary {
            background: #ff0000;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .btn-primary:hover {
            background: #ff0000;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="checkout-container">
        <?php 
        // Exibir erros de checkout
        if (isset($_SESSION['checkout_error'])): ?>
            <div class="error-message">
                <?php 
                echo htmlspecialchars($_SESSION['checkout_error']); 
                unset($_SESSION['checkout_error']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['checkout_errors'])): ?>
            <div class="error-message">
                <?php 
                foreach ($_SESSION['checkout_errors'] as $error) {
                    echo htmlspecialchars($error) . '<br>';
                }
                unset($_SESSION['checkout_errors']);
                ?>
            </div>
        <?php endif; ?>

        <?php 
        // Verificar se o carrinho não está vazio
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])): ?>
            <div class="error-message">
                Seu carrinho está vazio. <a href="shop-product-list.php">Continue comprando</a>
            </div>
        <?php exit(); endif; ?>

        <form method="POST" action="shop-checkout.php">
            <div class="checkout-grid">
                <div class="shipping-form">
                    <h2>Endereço de Entrega</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="rua">Rua *</label>
                            <input type="text" id="rua" name="rua" required>
                        </div>
                        <div class="form-group">
                            <label for="num">Número *</label>
                            <input type="text" id="num" name="num" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" id="complemento" name="complemento">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="bairro">Bairro *</label>
                            <input type="text" id="bairro" name="bairro" required>
                        </div>
                        <div class="form-group">
                            <label for="cep">CEP *</label>
                            <input type="text" id="cep" name="cep" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="cidade">Cidade *</label>
                            <input type="text" id="cidade" name="cidade" required>
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado *</label>
                            <select id="estado" name="estado" required>
                                <option value="">Selecione...</option>
                                <option value="AC">Acre</option>
                                <option value="AL">Alagoas</option>
                                <option value="AP">Amapá</option>
                                <option value="AM">Amazonas</option>
                                <option value="BA">Bahia</option>
                                <option value="CE">Ceará</option>
                                <option value="DF">Distrito Federal</option>
                                <option value="ES">Espírito Santo</option>
                                <option value="GO">Goiás</option>
                                <option value="MA">Maranhão</option>
                                <option value="MT">Mato Grosso</option>
                                <option value="MS">Mato Grosso do Sul</option>
                                <option value="MG">Minas Gerais</option>
                                <option value="PA">Pará</option>
                                <option value="PB">Paraíba</option>
                                <option value="PR">Paraná</option>
                                <option value="PE">Pernambuco</option>
                                <option value="PI">Piauí</option>
                                <option value="RJ">Rio de Janeiro</option>
                                <option value="RN">Rio Grande do Norte</option>
                                <option value="RS">Rio Grande do Sul</option>
                                <option value="RO">Rondônia</option>
                                <option value="RR">Roraima</option>
                                <option value="SC">Santa Catarina</option>
                                <option value="SP">São Paulo</option>
                                <option value="SE">Sergipe</option>
                                <option value="TO">Tocantins</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="pontoreferencia">Ponto de Referência *</label>
                        <input type="text" id="pontoreferencia" name="pontoreferencia" required>
                    </div>

                    <div class="form-group checkbox-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="endprincipal" value="S">
                            <span>Definir como endereço principal</span>
                        </label>
                    </div>

                    <div class="payment-methods">
                        <h2>Método de Pagamento</h2>
                        <label class="payment-method">
                            <input type="radio" name="metodo_pagamento" value="pix" required>
                            <i class="fas fa-qrcode"></i> PIX
                        </label>
                        <label class="payment-method">
                            <input type="radio" name="metodo_pagamento" value="boleto" required>
                            <i class="fas fa-barcode"></i> Boleto Bancário
                        </label>
                    </div>
                </div>

                <div class="order-summary">
                    <h3>Resumo do Pedido</h3>
                    
                    <div class="product-list">
                        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <div class="product-item">
                                    <span><?php echo htmlspecialchars($item['prod_nome']); ?> (<?php echo $item['prod_quant']; ?>x)</span>
                                    <span>R$ <?php echo number_format($item['prod_preco'] * $item['prod_quant'], 2, ',', '.'); ?></span>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <?php 
                        $frete = 50.00; // Valor fixo do frete
                    ?>
                    <div class="total-line subtotal">
                        <span>Subtotal:</span>
                        <span>R$ <?php 
                            $subtotal = 0;
                            if (isset($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $item) {
                                    $subtotal += $item['prod_preco'] * $item['prod_quant'];
                                }
                            }
                            echo number_format($subtotal, 2, ',', '.');
                        ?></span>
                    </div>

                    <div class="total-line frete">
                        <span>Frete:</span>
                        <span>R$ <?php echo number_format($frete, 2, ',', '.'); ?></span>
                    </div>

                    <div class="total-line total">
                        <strong>Total:</strong>
                        <strong>R$ <?php 
                            $total = $subtotal + $frete;
                            echo number_format($total, 2, ',', '.');
                        ?></strong>
                    </div>

                    <button type="submit" class="btn-primary">Finalizar Pedido</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Máscara para CEP
        document.getElementById('cep').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 8) value = value.slice(0, 8);
            if (value.length > 5) {
                value = value.slice(0, 5) + '-' + value.slice(5);
            }
            e.target.value = value;
        });

        // Validação do formulário
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['rua', 'num', 'bairro', 'cep', 'cidade', 'estado', 'pontoreferencia'];
            let hasError = false;

            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                if (!input.value.trim()) {
                    input.style.borderColor = 'red';
                    hasError = true;
                } else {
                    input.style.borderColor = '#ddd';
                }
            });

            if (!document.querySelector('input[name="metodo_pagamento"]:checked')) {
                alert('Por favor, selecione um método de pagamento');
                hasError = true;
            }

            if (hasError) {
                e.preventDefault();
                alert('Por favor, preencha todos os campos obrigatórios');
            }
        });
    </script>
</body>
</html>