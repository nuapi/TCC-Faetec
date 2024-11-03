<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM produto");

$stmt->execute();

$all_products = $stmt->get_result();

?>