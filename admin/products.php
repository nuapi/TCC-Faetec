<?php include('header.php')?>
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
                $stmt1= $conn->prepare("SELECT COUNT(*) As total_records FROM produto");
                $stmt1->execute();
                $stmt1->bind_result($total_records);
                $stmt1->store_result();
                $stmt1->fetch();

                //3. produtos por pagina
                $total_records_per_page = 5;

                $offset = ($page_no-1) * $total_records_per_page;

                $previous_page = $page_no - 1;
                $next_page = $page_no + 1;

                $adjacents = "2";

                $total_no_of_pages = ceil($total_records/$total_records_per_page);

                //4. get all products
                $stmt2 = $conn->prepare("SELECT * FROM produto LIMIT $offset, $total_records_per_page");
                $stmt2->execute();
                $produtos = $stmt2->get_result();



                ?>

    <div class="container mt-5">
      <div class="row tm-content-row">
        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 tm-block-col">
          <div class="tm-bg-primary-dark tm-block tm-block-products">
            <div class="tm-product-table-container">
              <table class="table table-hover tm-table-small tm-product-table">
                <thead>
                  <tr>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">ID PRODUTO</th>
                    <th scope="col">NOME</th>
                    <th scope="col">PREÇO</th>
                    <th scope="col">EM ESTOQUE</th>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">&nbsp;</th>
                  </tr>
                </thead>
                <tbody>
                <?php foreach($produtos as $produto) {?>
                  <tr>
                    <th scope="row"><input type="checkbox" /></th>
                    <td class="tm-product-name"><?php echo $produto['idproduto'];?></td>
                    <td><?php echo $produto['prod_nome'];?></td>
                    <td>R$ <?php echo $produto['prod_preco'];?></td>
                    <td>28 March 2019</td>
                    <td><a class="btn btn-primary" href="edit-product.php?idproduto=<?php echo $produto['idproduto'];?>">Editar</a></td>
                    <td>
                      <a href="#" class="tm-product-delete-link">
                        <i class="far fa-trash-alt tm-product-delete-icon"></i>
                      </a>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <!-- table container -->
            <a
              href="add-product.html"
              class="btn btn-primary btn-block text-uppercase mb-3">Adicionar produto</a>
            <button class="btn btn-primary btn-block text-uppercase">
              Remover produtos selecionados
            </button>
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

    <script src="js/jquery-3.3.1.min.js"></script>
    <!-- https://jquery.com/download/ -->
    <script src="js/bootstrap.min.js"></script>
    <!-- https://getbootstrap.com/ -->
    <script>
      $(function() {
        $(".tm-product-name").on("click", function() {
          window.location.href = "edit-product.html";
        });
      });
    </script>
  </body>
</html>