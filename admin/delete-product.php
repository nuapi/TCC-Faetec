<?php
    session_start();
    include('../connection.php');
    
    if(isset($_GET['idproduto'])) {
        $idproduto = $_GET['idproduto'];
        
        // Preparar a query de delete
        $stmt = $conn->prepare("DELETE FROM produto WHERE idproduto = ?");
        $stmt->bind_param("i", $idproduto);
        
        // Executar a query
        if($stmt->execute()) {
            // Sucesso - redirecionar de volta para a página de produtos
            header('location: products.php?success=produto_deletado');
            exit();
        } else {
            // Erro - redirecionar com mensagem de erro
            header('location: products.php?error=erro_ao_deletar');
            exit();
        }
    } else {
        // Se não houver ID do produto, redirecionar para a página de produtos
        header('location: products.php');
        exit();
    }
?>