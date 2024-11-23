<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM produto WHERE prod_categoria='ribbon' LIMIT 4");

$stmt->execute();

$bobina_products = $stmt->get_result();

?>