<?php include('header.php')?>
<?php
// Função para buscar dados de pedidos por período
function getOrderData($conn, $period = 'daily') {
    $orderData = [];

    switch ($period) {
        case 'daily':
            // Buscar dados de pedidos dos últimos 30 dias
            $query = "SELECT DATE(data) as order_date, COUNT(*) as order_count 
                      FROM pedido 
                      WHERE data >= DATE_SUB(CURDATE(), INTERVAL 30 DAY) 
                      GROUP BY order_date 
                      ORDER BY order_date";
            break;
        
        case 'monthly':
            // Buscar dados de pedidos dos últimos 12 meses
            $query = "SELECT DATE_FORMAT(data, '%Y-%m') as order_month, COUNT(*) as order_count 
                      FROM pedido 
                      WHERE data >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH) 
                      GROUP BY order_month 
                      ORDER BY order_month";
            break;
        
        case 'annual':
        default:
            // Buscar dados de pedidos dos últimos 5 anos
            $query = "SELECT YEAR(data) as order_year, COUNT(*) as order_count 
                      FROM pedido 
                      WHERE data >= DATE_SUB(CURDATE(), INTERVAL 5 YEAR) 
                      GROUP BY order_year 
                      ORDER BY order_year";
            break;
    }

    $result = $conn->query($query);
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $orderData[] = $row;
        }
    }

    return $orderData;
}

// Buscar dados de pedidos para diferentes períodos
$dailyOrderCount = getOrderData($conn, 'daily');
$monthlyOrderCount = getOrderData($conn, 'monthly');
$annualOrderCount = getOrderData($conn, 'annual');

// Adicionar função para gerar dados de vendas fictícios (para demonstração)
function generateSalesData($orderData) {
    return array_map(function($item) {
        $baseValue = isset($item['order_count']) ? $item['order_count'] * 50 : 1000;
        return [
            'label' => isset($item['order_date']) ? $item['order_date'] : 
                       (isset($item['order_month']) ? $item['order_month'] : $item['order_year']),
            'value' => rand($baseValue * 0.8, $baseValue * 1.2)
        ];
    }, $orderData);
}

$dailyOrderChartData = [
    'labels' => array_column($dailyOrderCount, 'order_date'),
    'data' => array_column($dailyOrderCount, 'order_count')
];

$monthlyOrderChartData = [
    'labels' => array_column($monthlyOrderCount, 'order_month'),
    'data' => array_column($monthlyOrderCount, 'order_count')
];

$annualOrderChartData = [
    'labels' => array_column($annualOrderCount, 'order_year'),
    'data' => array_column($annualOrderCount, 'order_count')
];

// Função para calcular receita anual
function calculateAnnualRevenue($conn) {
    $annualRevenueData = [];

    // Consulta usando valorliqbruto
    $query = "SELECT 
                YEAR(data) as order_year, 
                SUM(valorliqbruto) as total_revenue,
                COUNT(*) as total_orders
              FROM pedido 
              GROUP BY YEAR(data) 
              ORDER BY order_year DESC 
              LIMIT 5";

    $result = $conn->query($query);
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $annualRevenueData[] = $row;
        }
    }

    return $annualRevenueData;
}

// Calcular dados de receita anual
$annualRevenueReport = calculateAnnualRevenue($conn);
?>

<div class="container">
            <div class="row">
                <div class="col">
                    <p class="text-white mt-5 mb-5">Bem vindo, <b>Admin</b></p>
                </div>
            </div>
            <!-- row -->
            <div class="row tm-content-row">
                            <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Número de Pedidos Diários</h2>
                        <canvas id="dailyOrderCountChart"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block">
                        <h2 class="tm-block-title">Número de Pedidos Mensais</h2>
                        <canvas id="monthlyOrderCountChart"></canvas>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller">
                        <h2 class="tm-block-title">Número de Pedidos Anuais</h2>
                        <canvas id="annualOrderCountChart" class="chartjs-render-monitor" width="200" height="200"></canvas>
                    </div>
                </div>
                <style>
                    #annualOrderCountChart {
                        max-width: 100%;
                        height: auto !important;
                        max-height: 300px;
                    }

                    .tm-block-taller canvas {
                        width: 100%;
                        height: auto !important;
                    }
                </style>
                <div class="col-sm-12 col-md-12 col-lg-6 col-xl-6 tm-block-col">
    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-overflow">
        <h2 class="tm-block-title">Relatório de Receita Anual</h2>
        <div class="tm-revenue-items">
            <?php foreach($annualRevenueReport as $yearData): ?>
                <div class="media tm-revenue-item">
                    <div class="media-body">
                        <h3 class="text-white mb-2">Ano <?php echo $yearData['order_year']; ?></h3>
                        <p class="mb-1">
                            <strong>Receita Total:</strong> 
                            R$ <?php echo number_format($yearData['total_revenue'], 2, ',', '.'); ?>
                        </p>
                        <p class="mb-1">
                            <strong>Total de Pedidos:</strong> 
                            <?php echo $yearData['total_orders']; ?>
                        </p>
                        <span class="tm-small tm-text-color-secondary">
                            Média por Pedido: 
                            R$ <?php echo number_format($yearData['total_revenue'] / $yearData['total_orders'], 2, ',', '.'); ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<style>
    .tm-revenue-items {
    max-height: 400px;
    overflow-y: auto;
}

.tm-revenue-item {
    border-bottom: 1px solid rgba(255,255,255,0.1);
    padding: 15px 0;
}

.tm-revenue-item:last-child {
    border-bottom: none;
}

.tm-revenue-item .media-body {
    color: white;
}
</style>

                <?php
                //1. numero da pagina
                if(isset($_GET['page_no']) && $_GET['page_no'] != ""){
                    //if user has already entered page then page number is the one that they selected
                    $page_no = $_GET['page_no'];
                }else{
                    //if user just entered the page then default page is 1
                    $page_no = 1;
                }

                //2. retornar numero de produtos
                $stmt1= $conn->prepare("SELECT COUNT(*) As total_records FROM pedido");
                $stmt1->execute();
                $stmt1->bind_result($total_records);
                $stmt1->store_result();
                $stmt1->fetch();

                //3. produtos por pagina
                $total_records_per_page = 2;

                $offset = ($page_no-1) * $total_records_per_page;

                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;

                $adjacents = "2";

                $total_no_of_pages = ceil($total_records/$total_records_per_page);

                //4. get all products
                $stmt2 = $conn->prepare("SELECT * FROM pedido LIMIT $offset, $total_records_per_page");
                $stmt2->execute();
                $pedidos = $stmt2->get_result();



                ?>

                <div class="col-12 tm-block-col">
                    <div class="tm-bg-primary-dark tm-block tm-block-taller tm-block-scroll">
                        <h2 class="tm-block-title">Pedidos</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">PEDIDO NO.</th>
                                    <th scope="col">STATUS</th>
                                    <th scope="col">ID CLIENTE</th>
                                    <th scope="col">TELEFONE CLIENTE</th>
                                    <th scope="col">DATA PEDIDO</th>
                                    <th scope="col">EDITAR</th>
                                    <th scope="col">APAGAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($pedidos as $pedido) {?>
                                <tr>
                                    <th scope="row"><b><?php echo $pedido['idpedido'];?></b></th>
                                    <td>
                                        <div class="tm-status-circle moving">
                                        </div><?php echo $pedido['statuspedido'];?>
                                    </td>
                                    <td><b><?php echo $pedido['cliente_idcliente'];?></b></td>
                                    <td><b>London, UK</b></td>
                                    <td><?php echo $pedido['data'];?></td>
                                    <td><a class="btn btn-primary">Editar</a></td>
                                    <td><a class="btn btn-danger">Apagar</a></td>

                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                        <nav aria-label="Page navigation example" class="mx-auto">
                            <ul class="pagination mt-5 mx-auto">

                            <li class="page-item <?php if($page_no<=1){echo 'disabled' ;}?>">
                                <a class="page-link" href="<?php if($page_no <= 1){echo '#';} else{echo "?page_no=".($page_no-1) ;}?>">Anterior</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="?page_no=1">1</a></li>
                            <li class="page-item"><a class="page-link" href="?page_no=2">2</a></li>

                            <?php if($page_no >=3 ) { ?>
                                <li class="page-item"><a class="page-link" href="#">...</a></li>
                                <li class="page-item"><a class="page-link" href="<?php echo "?page_no=".$page_no;?>"><?php echo $page_no;?></a></li>
                            <?php }?>
                                
                            <li class="page-item <?php if($page_no >= $total_no_of_pages){echo 'disabled';}?>">
                                <a class="page-link" href="<?php if($page_no >= $total_no_of_pages){echo '#';} else{echo "?page_no=".($page_no+1);}?>">Próxima</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <footer class="tm-footer row tm-mt-small">
            <div class="col-12 font-weight-light">
                <p class="text-center text-white mb-0 px-4 small">
                    Copyright &copy; <b>2018</b> All rights reserved. 
                    
                    Design: <a rel="nofollow noopener" href="https://templatemo.com" class="tm-footer-link">Template Mo</a>
                </p>
            </div>
        </footer>
    </div>

    <script>
function drawDailyOrderCountChart() {
    if ($("#dailyOrderCountChart").length) {
        ctxDailyOrderCount = document.getElementById("dailyOrderCountChart").getContext("2d");
        
        // Dados do PHP convertidos para JavaScript
        const dailyOrderCountData = <?php echo json_encode($dailyOrderChartData); ?>;
        
        configDailyOrderCount = {
            type: "line",
            data: {
                labels: dailyOrderCountData.labels,
                datasets: [{
                    label: "Número de Pedidos Diários",
                    data: dailyOrderCountData.data,
                    borderColor: "rgba(255, 99, 132, 1)",
                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                    fill: true
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        };

        dailyOrderCountChart = new Chart(ctxDailyOrderCount, configDailyOrderCount);
    }
}

function drawMonthlyOrderCountChart() {
    if ($("#monthlyOrderCountChart").length) {
        ctxMonthlyOrderCount = document.getElementById("monthlyOrderCountChart").getContext("2d");
        
        // Dados do PHP convertidos para JavaScript
        const monthlyOrderCountData = <?php echo json_encode($monthlyOrderChartData); ?>;
        
        configMonthlyOrderCount = {
            type: "bar",
            data: {
                labels: monthlyOrderCountData.labels,
                datasets: [{
                    label: "Número de Pedidos Mensais",
                    data: monthlyOrderCountData.data,
                    backgroundColor: "rgba(54, 162, 235, 0.6)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        };

        monthlyOrderCountChart = new Chart(ctxMonthlyOrderCount, configMonthlyOrderCount);
    }
}

function drawAnnualOrderCountChart() {
    if ($("#annualOrderCountChart").length) {
        ctxAnnualOrderCount = document.getElementById("annualOrderCountChart").getContext("2d");
        
        // Dados do PHP convertidos para JavaScript
        const annualOrderCountData = <?php echo json_encode($annualOrderChartData); ?>;
        
        configAnnualOrderCount = {
            type: "bar",
            data: {
                labels: annualOrderCountData.labels,
                datasets: [{
                    label: "Número de Pedidos Anuais",
                    data: annualOrderCountData.data,
                    backgroundColor: "rgba(75, 192, 192, 0.6)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        };

        annualOrderCountChart = new Chart(ctxAnnualOrderCount, configAnnualOrderCount);
    }
}
</script>

<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/Chart.min.js"></script>

<script>
// Configurações globais do Chart.js
Chart.defaults.global.defaultFontColor = 'white';

// Adicione esta verificação no início
if (typeof Chart === 'undefined') {
    console.error('Chart.js não foi carregado corretamente');
}

function drawCharts() {
    const chartConfigs = [
        {
            elementId: "dailyOrderCountChart",
            type: "line",
            data: <?php echo json_encode($dailyOrderChartData); ?>,
            label: "Número de Pedidos Diários",
            borderColor: "rgba(255, 99, 132, 1)",
            backgroundColor: "rgba(255, 99, 132, 0.2)"
        },
        {
            elementId: "monthlyOrderCountChart",
            type: "bar",
            data: <?php echo json_encode($monthlyOrderChartData); ?>,
            label: "Número de Pedidos Mensais",
            backgroundColor: "rgba(54, 162, 235, 0.6)"
        },
        {
            elementId: "annualOrderCountChart",
            type: "bar",
            data: <?php echo json_encode($annualOrderChartData); ?>,
            label: "Número de Pedidos Anuais",
            backgroundColor: "rgba(75, 192, 192, 0.6)"
        }
    ];

    chartConfigs.forEach(function(config) {
        const ctx = document.getElementById(config.elementId);
        if (ctx) {
            new Chart(ctx.getContext("2d"), {
                type: config.type,
                data: {
                    labels: config.data.labels,
                    datasets: [{
                        label: config.label,
                        data: config.data.data,
                        borderColor: config.borderColor,
                        backgroundColor: config.backgroundColor,
                        fill: config.type === 'line'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    });
}

// Certifique-se de que o jQuery está carregado
$(document).ready(function() {
    if (window.Chart) {
        drawCharts();
    } else {
        console.error('Chart.js não foi carregado');
    }
});
</script>

</body>

</html>