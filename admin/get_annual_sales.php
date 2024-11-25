<?php
// Arquivo: get_annual_sales.php
// Adicione este arquivo para buscar os dados das vendas

function getAnnualSales($conn) {
    $query = "SELECT 
                MONTH(data) as month,
                YEAR(data) as year,
                SUM(valorliqbruto) as total_sales
              FROM pedido 
              WHERE YEAR(data) = YEAR(CURRENT_DATE)
              GROUP BY MONTH(data), YEAR(data)
              ORDER BY YEAR(data), MONTH(data)";
              
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $monthNames = [
        1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr',
        5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
        9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'
    ];
    
    $salesData = array_fill(0, 12, 0); // Initialize all months with zero
    
    while ($row = $result->fetch_assoc()) {
        $monthIndex = (int)$row['month'] - 1;
        $salesData[$monthIndex] = (float)$row['total_sales'];
    }
    
    return [
        'labels' => array_values($monthNames),
        'data' => array_values($salesData)
    ];
}

// Modificação no index.php
// Adicione antes do HTML onde o gráfico é renderizado:
$annualSales = getAnnualSales($conn);
?>