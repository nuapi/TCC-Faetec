<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM produto WHERE prod_categoria='bobina' LIMIT 4");

$stmt->execute();

$bobina_products = $stmt->get_result();

?>