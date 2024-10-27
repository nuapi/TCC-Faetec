<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM produto LIMIT 3");

$stmt->execute();

$featured_products = $stmt->get_result();

?>