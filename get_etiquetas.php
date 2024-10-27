<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM produto WHERE prod_categoria='etiqueta' LIMIT 4");

$stmt->execute();

$etiqueta_products = $stmt->get_result();

?>