<?php

// Iniciar sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class CheckoutHandler {
    private $db;
    private $cliente;
    
    public function __construct($db) {
        $this->db = $db;
        $this->cliente = isset($_SESSION['cliente']) ? $_SESSION['cliente'] : null;
    }
    
    // Validar dados do formulário
    public function validateFormData($data) {
        $errors = [];
        
        // Validar campos obrigatórios do endereço
        $required_fields = ['rua', 'num', 'bairro', 'cep', 'cidade', 'estado'];
        
        foreach ($required_fields as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst($field) . " é obrigatório";
            }
        }
        
        return $errors;
    }
    
    // Salvar endereço de entrega
    public function saveShippingAddress($data) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO endereco 
                (rua, num, bairro, cep, complemento, pontoreferencia, endprincipal, cidade, estado, cliente_idcliente) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $data['rua'],
                $data['num'],
                $data['bairro'],
                $data['cep'],
                $data['complemento'] ?? null,
                $data['pontoreferencia'],
                $data['endprincipal'] ?? 'N',
                $data['cidade'],
                $data['estado'],
                $this->cliente['idcliente']
            ]);
            
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
    
    // Criar pedido
    public function createOrder($endereco_id, $cartItems) {
        try {
            $this->db->beginTransaction();
            
            // Inserir pedido
            $stmt = $this->db->prepare("
                INSERT INTO pedido 
                (data, statuspedido, valorliqbruto, cliente_idcliente) 
                VALUES (CURDATE(), 'Pendente', ?, ?)
            ");
            
            $totalAmount = $this->calculateTotal($cartItems);
            $stmt->execute([$totalAmount, $this->cliente['idcliente']]);
            $pedido_id = $this->db->lastInsertId();
            
            // Inserir itens do pedido
            $stmt = $this->db->prepare("
                INSERT INTO itempedido 
                (qnt, precounitario, pedido_idpedido, produto_idproduto, pedido_idcliente, produto_idadm) 
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            foreach ($cartItems as $item) {
                $stmt->execute([
                    $item['quantidade'],
                    $item['preco'],
                    $pedido_id,
                    $item['idproduto'],
                    $this->cliente['idcliente'],
                    $item['idadm']
                ]);
            }
            
            $this->db->commit();
            return $pedido_id;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }
    
    // Calcular total do pedido
    private function calculateTotal($cartItems) {
      $total = 0;
      foreach ($cartItems as $item) {
          $total += $item['prod_preco'] * $item['prod_quant'];
      }
      $frete = 50.00; // Valor fixo do frete
      return $total + $frete;
  }
    
    // Processar pagamento
    public function processPayment($pedido_id, $paymentMethod) {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO formadepagamento 
                (metodo, valor, data, itemdesconto, pedido_idpedido, pedido_idcliente) 
                SELECT ?, valorliqbruto, CURDATE(), 0, idpedido, cliente_idcliente
                FROM pedido 
                WHERE idpedido = ?
            ");
            
            $stmt->execute([$paymentMethod, $pedido_id]);
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}

// Processar formulário de checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new PDO("mysql:host=localhost;dbname=tcc;charset=utf8mb4", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $checkout = new CheckoutHandler($db);
        
        // Validar dados
        $errors = $checkout->validateFormData($_POST);
        
        if (empty($errors)) {
            // Salvar endereço
            $endereco_id = $checkout->saveShippingAddress($_POST);
            
            if ($endereco_id) {
                // Criar pedido
                $pedido_id = $checkout->createOrder($endereco_id, $_SESSION['cart']);
                
                if ($pedido_id) {
                    // Processar pagamento
                    if ($checkout->processPayment($pedido_id, $_POST['metodo_pagamento'])) {
                        // Limpar carrinho
                        unset($_SESSION['cart']);
                        
                        // Redirecionar para página de sucesso
                        header('Location: checkout-sucesso.php?pedido_id=' . $pedido_id);
                        exit;
                    }
                }
            }
            
            // Se chegou aqui, houve erro no processamento
            $_SESSION['checkout_error'] = "Erro ao processar seu pedido. Por favor, tente novamente.";
        } else {
            $_SESSION['checkout_errors'] = $errors;
        }
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $_SESSION['checkout_error'] = "Erro de conexão com o banco de dados.";
    }
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
            border: 1px solid #ddd;
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

        
        <style>
        .checkbox-group {
            margin: 20px 0;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .checkbox-label input[type="checkbox"] {
            width: auto;
            margin-right: 10px;
        }

        .checkbox-label span {
            font-weight: normal;
        }
        </style>
        <form method="POST" action="checkout.php">
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
                        <label for="pontoreferencia">Ponto de Referência</label>
                        <input type="text" id="pontoreferencia" name="pontoreferencia">
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
                            <input type="radio" name="metodo_pagamento" value="cartao" required>
                            <i class="fas fa-credit-card"></i> Cartão de Crédito
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
            const requiredFields = ['rua', 'num', 'bairro', 'cep', 'cidade', 'estado'];
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