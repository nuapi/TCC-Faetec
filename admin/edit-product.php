<?php 
include('header.php');

// Verifica se um ID de produto foi passado
if(isset($_GET['idproduto'])) {
    $idproduto = $_GET['idproduto'];
    $stmt = $conn->prepare("SELECT * FROM produto WHERE idproduto = ?");
    $stmt->bind_param('i', $idproduto);
    $stmt->execute();
    $produtos = $stmt->get_result();
    
    if($produtos->num_rows == 0) {
        header('Location: products.php');
        exit;
    }
} else {
    header('Location: products.php');
    exit;
}

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prod_nome = $_POST['prod_nome'];
    $prod_preco = $_POST['prod_preco'];
    $prod_desc = $_POST['prod_desc'];
    $prod_categoria = $_POST['prod_categoria'];
    $prod_quant = $_POST['prod_quant'];
    
    // Inicializa a query base
    $query = "UPDATE produto SET 
        prod_nome = ?,
        prod_preco = ?,
        prod_desc = ?,
        prod_categoria = ?,
        prod_quant = ?";
    
    $params = array($prod_nome, $prod_preco, $prod_desc, $prod_categoria, $prod_quant);
    $types = 'sdssi';
    
    // Processa as imagens
    $image_fields = ['prod_imagem', 'prod_imagem2', 'prod_imagem3', 'prod_imagem4'];
    foreach($image_fields as $field) {
        if(isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $filename = $_FILES[$field]['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            if(in_array($ext, $allowed)) {
                $new_filename = uniqid() . '.' . $ext;
                $upload_path = 'img/' . $new_filename;
                
                if(move_uploaded_file($_FILES[$field]['tmp_name'], $upload_path)) {
                    $query .= ", $field = ?";
                    $params[] = $new_filename;
                    $types .= 's';
                }
            }
        }
    }
    
    $query .= " WHERE idproduto = ?";
    $params[] = $idproduto;
    $types .= 'i';
    
    // Preparar e executar a query
    $update_stmt = $conn->prepare($query);
    $update_stmt->bind_param($types, ...$params);
    
    if ($update_stmt->execute()) {
        echo "<script>alert('Produto atualizado com sucesso!'); window.location.href='products.php';</script>";
    } else {
        echo "<script>alert('Erro ao atualizar o produto!');</script>";
    }
}
?>

<div class="container tm-mt-big tm-mb-big">
  <div class="row">
    <div class="col-xl-9 col-lg-10 col-md-12 col-sm-12 mx-auto">
      <div class="tm-bg-primary-dark tm-block tm-block-h-auto">
        <div class="row">
          <div class="col-12">
            <h2 class="tm-block-title d-inline-block">Editar Produto</h2>
          </div>
        </div>
        <div class="row tm-edit-product-row">
          <div class="col-xl-6 col-lg-6 col-md-12">
            <?php foreach($produtos as $produto) { ?>
            <form action="" method="post" class="tm-edit-product-form" enctype="multipart/form-data">
              <div class="form-group mb-3">
                <label for="prod_nome">Nome</label>
                <input
                  type="text"
                  class="form-control"
                  id="prod_nome"
                  name="prod_nome"
                  value="<?php echo htmlspecialchars($produto['prod_nome']); ?>"
                  required
                />
              </div>
              <div class="form-group mb-3">
                <label for="prod_preco">Preço</label>
                <input
                  id="prod_preco"
                  name="prod_preco"
                  type="number"
                  step="0.01"
                  value="<?php echo htmlspecialchars($produto['prod_preco']); ?>"
                  class="form-control validate"
                  required
                />
              </div>
              <div class="form-group mb-3">
                <label for="prod_desc">Descrição</label>
                <textarea
                  class="form-control validate"
                  id="prod_desc"
                  name="prod_desc"
                  rows="3"
                  required
                ><?php echo htmlspecialchars($produto['prod_desc']); ?></textarea>
              </div>
              <div class="form-group mb-3">
                <label for="prod_categoria">Categoria</label>
                <select
                  class="custom-select tm-select-accounts"
                  id="prod_categoria"
                  name="prod_categoria"
                  required
                >
                  <option value="">Selecionar categoria</option>
                  <option value="Etiqueta" <?php echo ($produto['prod_categoria'] == 'Etiqueta') ? 'selected' : ''; ?>>Etiqueta</option>
                  <option value="Bobina" <?php echo ($produto['prod_categoria'] == 'Bobina') ? 'selected' : ''; ?>>Bobina</option>
                  <option value="Ribbon" <?php echo ($produto['prod_categoria'] == 'Ribbon') ? 'selected' : ''; ?>>Ribbon</option>
                </select>
              </div>
              <div class="form-group mb-3">
                <label for="prod_quant">Quantidade em Estoque</label>
                <input
                  id="prod_quant"
                  name="prod_quant"
                  type="number"
                  value="<?php echo htmlspecialchars($produto['prod_quant']); ?>"
                  class="form-control validate"
                  required
                />
              </div>
              
              <!-- Seção de Imagens -->
              <div class="form-group mb-3">
                <label>Imagens do Produto</label>
                <div class="custom-file mt-3 mb-3">
                  <input type="file" name="prod_imagem" class="custom-file-input" id="fileInput1" accept="image/*">
                  <label class="custom-file-label" for="fileInput1">Imagem Principal</label>
                </div>
                <div class="custom-file mt-3 mb-3">
                  <input type="file" name="prod_imagem2" class="custom-file-input" id="fileInput2" accept="image/*">
                  <label class="custom-file-label" for="fileInput2">Imagem 2</label>
                </div>
                <div class="custom-file mt-3 mb-3">
                  <input type="file" name="prod_imagem3" class="custom-file-input" id="fileInput3" accept="image/*">
                  <label class="custom-file-label" for="fileInput3">Imagem 3</label>
                </div>
                <div class="custom-file mt-3 mb-3">
                  <input type="file" name="prod_imagem4" class="custom-file-input" id="fileInput4" accept="image/*">
                  <label class="custom-file-label" for="fileInput4">Imagem 4</label>
                </div>
              </div>
              
              <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block text-uppercase">Atualizar Produto</button>
              </div>
            </form>
            <?php } ?>
          </div>
          <div class="col-xl-6 col-lg-6 col-md-12 mx-auto mb-4">
            <!-- Exibição das imagens atuais -->
            <div class="row">
              <div class="col-6 mb-4">
                <div class="tm-product-img-edit mx-auto">
                  <img src="img/<?php echo htmlspecialchars($produto['prod_imagem']); ?>" alt="Imagem Principal" class="img-fluid">
                  <p class="text-center mt-2">Imagem Principal</p>
                </div>
              </div>
              <div class="col-6 mb-4">
                <div class="tm-product-img-edit mx-auto">
                  <img src="img/<?php echo htmlspecialchars($produto['prod_imagem2']); ?>" alt="Imagem 2" class="img-fluid">
                  <p class="text-center mt-2">Imagem 2</p>
                </div>
              </div>
              <div class="col-6 mb-4">
                <div class="tm-product-img-edit mx-auto">
                  <img src="img/<?php echo htmlspecialchars($produto['prod_imagem3']); ?>" alt="Imagem 3" class="img-fluid">
                  <p class="text-center mt-2">Imagem 3</p>
                </div>
              </div>
              <div class="col-6 mb-4">
                <div class="tm-product-img-edit mx-auto">
                  <img src="img/<?php echo htmlspecialchars($produto['prod_imagem4']); ?>" alt="Imagem 4" class="img-fluid">
                  <p class="text-center mt-2">Imagem 4</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Script para mostrar o nome do arquivo selecionado -->
<script>
document.querySelectorAll('.custom-file-input').forEach(function(input) {
    input.addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var label = e.target.nextElementSibling;
        label.innerHTML = fileName;
    });
});
</script>

<?php include('footer.php'); ?>