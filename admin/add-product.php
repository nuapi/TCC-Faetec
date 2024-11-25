<?php
// Iniciar sessão para verificação de admin
session_start();

// Verificar se o administrador está logado
if (!isset($_SESSION['idadm'])) {
    header("Location: login.php");
    exit();
}

// Configuração da conexão com o banco de dados
$conn = new mysqli("localhost", "root", "", "tcc");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para upload de imagem
function uploadImagem($file, $index) {
    $target_dir = "assets/prodG/";
    $imageFileType = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
    $newFileName = uniqid() . "." . $imageFileType;
    $target_file = $target_dir . $newFileName;

    // Verificar se é uma imagem real
    if(getimagesize($file["tmp_name"]) === false) {
        return false;
    }

    // Permitir apenas certos formatos de arquivo
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return false;
    }

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return $newFileName;
    }
    return false;
}

// Processar o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['name'];
    $descricao = $_POST['description'];
    $categoria = $_POST['category'];
    $preco = $_POST['price'];
    $quantidade = $_POST['stock'];
    $idadm = $_SESSION['idadm'];

    // Upload das imagens
    $imagem1 = isset($_FILES['imagem1']) ? uploadImagem($_FILES['imagem1'], 1) : '';
    $imagem2 = isset($_FILES['imagem2']) ? uploadImagem($_FILES['imagem2'], 2) : '';
    $imagem3 = isset($_FILES['imagem3']) ? uploadImagem($_FILES['imagem3'], 3) : '';
    $imagem4 = isset($_FILES['imagem4']) ? uploadImagem($_FILES['imagem4'], 4) : '';

    // Preparar e executar a query
    $stmt = $conn->prepare("INSERT INTO produto (prod_nome, prod_preco, prod_desc, prod_categoria, prod_quant, prod_imagem, prod_imagem2, prod_imagem3, prod_imagem4, administrador_idadm) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("sdsssssssi", $nome, $preco, $descricao, $categoria, $quantidade, $imagem1, $imagem2, $imagem3, $imagem4, $idadm);

    if ($stmt->execute()) {
        $mensagem = "Produto adicionado com sucesso!";
        $tipo = "success";
    } else {
        $mensagem = "Erro ao adicionar produto: " . $stmt->error;
        $tipo = "error";
    }

    $stmt->close();
}

// Buscar categorias existentes
$query = "SELECT DISTINCT prod_categoria FROM produto";
$categorias = $conn->query($query);
?>

<?php include('header.php')?>

    <div class="container tm-mt-big tm-mb-big">
        <div class="row">
            <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
                <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="tm-block-title d-inline-block">Adicionar Produto</h2>
                            <?php if(isset($mensagem)): ?>
                                <div class="alert alert-<?php echo $tipo == 'success' ? 'success' : 'danger'; ?>">
                                    <?php echo $mensagem; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row tm-edit-product-row">
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <form action="" method="POST" enctype="multipart/form-data" class="tm-edit-product-form">
                                <div class="form-group mb-3">
                                    <label for="name">Nome do Produto</label>
                                    <input id="name" name="name" type="text" class="form-control validate" required />
                                </div>

                                <div class="form-group mb-3">
                                    <label for="description">Descrição</label>
                                    <textarea name="description" class="form-control validate" rows="3" required></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="category">Categoria</label>
                                    <select name="category" class="custom-select tm-select-accounts" required>
                                        <option value="">Selecione uma categoria</option>
                                        <?php while($cat = $categorias->fetch_assoc()): ?>
                                            <option value="<?php echo htmlspecialchars($cat['prod_categoria']); ?>">
                                                <?php echo htmlspecialchars($cat['prod_categoria']); ?>
                                            </option>
                                        <?php endwhile; ?>
                                        <option value="nova">Nova Categoria</option>
                                    </select>
                                </div>

                                <div class="form-group mb-3" id="novaCategoriaDiv" style="display: none;">
                                    <label for="novaCategoria">Nova Categoria</label>
                                    <input type="text" name="novaCategoria" class="form-control" />
                                </div>

                                <div class="form-group mb-3">
                                    <label for="price">Preço</label>
                                    <input id="price" name="price" type="number" step="0.01" class="form-control validate" required />
                                </div>

                                <div class="form-group mb-3">
                                    <label for="stock">Quantidade em Estoque</label>
                                    <input id="stock" name="stock" type="number" class="form-control validate" required />
                                </div>

                                <div class="form-group mb-3">
                                    <label>Imagens do Produto</label>
                                    <input type="file" name="imagem1" class="form-control" required />
                                    <input type="file" name="imagem2" class="form-control" />
                                    <input type="file" name="imagem3" class="form-control" />
                                    <input type="file" name="imagem4" class="form-control" />
                                </div>

                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block text-uppercase">Adicionar Produto</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('select[name="category"]').addEventListener('change', function() {
            const novaCategoriaDiv = document.getElementById('novaCategoriaDiv');
            if (this.value === 'nova') {
                novaCategoriaDiv.style.display = 'block';
            } else {
                novaCategoriaDiv.style.display = 'none';
            }
        });
    </script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- https://jquery.com/download/ -->
    <script src="jquery-ui-datepicker/jquery-ui.min.js"></script>
    <!-- https://jqueryui.com/download/ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- https://getbootstrap.com/ -->
    <script>
      $(function() {
        $("#expire_date").datepicker();
      });
    </script>
  </body>
</html>
