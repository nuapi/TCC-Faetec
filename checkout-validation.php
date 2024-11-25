<?php
// Iniciar sessão se ainda não estiver ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar se o usuário está tentando acessar checkout-sucesso.php diretamente
if (basename($_SERVER['PHP_SELF']) === 'checkout-sucesso.php') {
    if (!isset($_SESSION['ultimo_pedido']) || !isset($_SESSION['checkout_completed'])) {
        header('Location: shop-checkout.php');
        exit();
    }
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rua'])) {
    // Array para armazenar erros de validação
    $errors = [];
    
    // Validar campos obrigatórios
    $required_fields = [
        'rua' => 'Rua',
        'num' => 'Número',
        'bairro' => 'Bairro',
        'cep' => 'CEP',
        'cidade' => 'Cidade',
        'estado' => 'Estado',
        'pontoreferencia' => 'Ponto de Referência',
        'metodo_pagamento' => 'Método de Pagamento'
    ];

    foreach ($required_fields as $field => $label) {
        if (empty($_POST[$field])) {
            $errors[] = "O campo {$label} é obrigatório.";
        }
    }

    // Validar se há itens no carrinho
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        $errors[] = "Seu carrinho está vazio.";
    }

    // Se houver erros, redirecionar de volta para o checkout
    if (!empty($errors)) {
        $_SESSION['checkout_errors'] = $errors;
        header('Location: shop-checkout.php');
        exit();
    }

    // Se passou pela validação, marcar checkout como completo
    $_SESSION['checkout_completed'] = true;
}

// Se tentar acessar checkout-sucesso sem ter completado o checkout
if (basename($_SERVER['PHP_SELF']) === 'checkout-sucesso.php' && !isset($_SESSION['checkout_completed'])) {
    header('Location: shop-checkout.php');
    exit();
}
?>