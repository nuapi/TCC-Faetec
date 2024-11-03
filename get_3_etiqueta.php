<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM produto WHERE prod_categoria='etiqueta' LIMIT 3");

$stmt->execute();

$etiqueta2_products = $stmt->get_result();

?>