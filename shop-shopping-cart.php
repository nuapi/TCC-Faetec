<?php
session_start();

if(isset($_POST['add_to_cart'])){
  //se usuario ja adicionou produto ao carrinho
  if(isset($_SESSION['cart'])){

    $prod_array_ids = array_column($_SESSION['cart'], "idproduto");

    //se o produto ja foi adicionado ao carrinho
    if(!in_array($_POST['idproduto'], $prod_array_ids)){

      $idproduto = $_POST['idproduto'];
    
      $prod_array = array(
      'idproduto' => $_POST['idproduto'],
      'prod_nome' => $_POST['prod_nome'],
      'prod_preco' => $_POST['prod_preco'],
      'prod_imagem' => $_POST['prod_imagem'],
      'prod_quant' => $_POST['prod_quant']
    );

    $_SESSION['cart'][$idproduto] = $prod_array;

      //produto ja adicionado
    }else{

      //echo '<script>alert("Produto já está no carrinho");</script>';
      //echo '<script>window.location="index.php";</script>';
    }

    //produto novo no carrinho
  }else{
    $idproduto = $_POST['idproduto'];
    $prod_nome = $_POST['prod_nome'];
    $prod_preco = $_POST['prod_preco'];
    $prod_imagem = $_POST['prod_imagem'];
    $prod_quant = $POST['prod_quant'];

    $prod_array = array(
      'idproduto' => $idproduto,
      'prod_nome' => $prod_nome,
      'prod_preco' => $prod_preco,
      'prod_imagem' => $prod_imagem,
      'prod_quant' => $prod_quant
    );

    $_SESSION['cart'][$idproduto] = $prod_array;
  }

  //calcular total
  calculateTotalCart();



//remover do carrinho
}else if(isset($_POST['remove_product'])){

  $idproduto = $_POST['idproduto'];
  unset($_SESSION['cart'][$idproduto]);
  //calcular total
  calculateTotalCart();

}else if(isset($_POST['edit_quantity'])){

  //pegar id e quantidade do form
  $idproduto = $_POST['idproduto'];
  $prod_quant = $_POST['prod_quant'];

  //pegar o array da sessao
  $product_array = $_SESSION['cart'][$idproduto];

  //atualizar a quantidade do produto
  $product_array['prod_quant'] = $prod_quant;

  //retornar array para seu lugar
  $_SESSION['cart'][$idproduto] = $product_array;

  //calcular total
  calculateTotalCart();

}
else{
  header('location: shop-index.php');
}



function calculateTotalCart(){

  $total = 0;

  foreach($_SESSION['cart'] as $key => $value){
    
    $produto = $_SESSION['cart'][$key];

    $preco = $produto['prod_preco'];
    $quant = $produto['prod_quant'];

    $total = $total + ($preco * $quant);
  }

  $_SESSION['total'] = $total;

}

?>

<?php 
include('header.php');
?>

    <div class="main">
      <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN CONTENT -->
          <div class="col-md-12 col-sm-12">
            <h1>Carrinho de Compras</h1>
            <div class="goods-page">
              <div class="goods-data clearfix">
                <div class="table-wrapper-responsive">
                <table summary="Shopping cart">
                  <tr>
                    <th class="goods-page-image">Imagem</th>
                    <th class="goods-page-description">Descrição</th>
                    <th class="goods-page-ref-no">Ref No</th>
                    <th class="goods-page-quantity">Quantidade</th>
                    <th class="goods-page-price">Preço Unit</th>
                    <th class="goods-page-total" colspan="2">Total</th>
                  </tr>

                  <?php foreach($_SESSION['cart'] as $key => $value){ ?>
                  <tr>
                  <td class="goods-page-image">
                    <a href="javascript:;">
                      <img src="assets/pages/img/prodcrispel/<?php echo $value['prod_imagem'];?>" 
                          alt="<?php echo $value['prod_nome'];?>"
                          style="width: 100px; height: 100px; object-fit: cover;"
                          class="img-thumbnail">
                    </a>
                  </td> 
                    <td class="goods-page-description">
                      <h3><a href="javascript:;"><?php echo $value['prod_nome'];?></a></h3>
                      <p><strong>Item 1</strong> - Color: Green; Size: S</p>
                      <em>More info is here</em>
                    </td>
                    <td class="goods-page-ref-no">
                      javc2133
                    </td>
                    <td class="goods-page-quantity">
                        <div class="product-quantity">
                            <form method="post" action="shop-shopping-cart.php" style="display: flex; align-items: center; gap: 5px;">
                                <input type="hidden" name="idproduto" value="<?php echo $value['idproduto'];?>"/>
                                <input type="number" name="prod_quant" value="<?php echo $value['prod_quant'];?>" min="1"/>
                                <input type="submit" class="edit-btn" value="Editar" name="edit_quantity"/>
                            </form>
                        </div>
                    </td>
                  <td class="goods-page-price">
                      <strong><span>R$</span><?php echo $value['prod_preco'];?></strong>
                    </td>
                    <td class="goods-page-total">
                      <strong><span>R$</span><?php echo $value['prod_preco'] * $value['prod_quant'];?></strong>
                    </td>
                    <td class="del-goods-col">
                        <form method="POST" action="shop-shopping-cart.php">
                            <input type="hidden" name="idproduto" value="<?php echo $value['idproduto'];?>"/>
                            <input type="submit" name="remove_product" class="remove-btn" value="Remover"/>
                        </form>
                    </td>
                  </tr>
                  <?php } ?>
                </table>
                </div>

                <div class="shopping-total">
                  <ul>
                    <li>
                      <em>Sub total</em>
                      <strong class="price"><span>R$</span>-</strong>
                    </li>
                    <li>
                      <em>Frete</em>
                      <strong class="price"><span>R$</span>-</strong>
                    </li>
                    <li class="shopping-total-price">
                      <em>Total</em>
                      <strong class="price"><span>R$</span><?php echo $_SESSION['total'];?></strong>
                    </li>
                  </ul>
                </div>
              </div>
              <a href="shop-product-list.php"><button class="btn btn-default" type="submit">Continue shopping <i class="fa fa-shopping-cart"></i></button></a>
              <form method="POST" action="shop-checkout.php">
              <input class="btn btn-primary" type="submit" value="Checkout" name="checkout"><i class="fa fa-check"></i>
              </form>
            </div>
          </div>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->

        <!-- BEGIN SALE PRODUCT & NEW ARRIVALS -->
        <div class="row margin-bottom-40">
          <h2>Mais Pedidos</h2>
          <div class="row">
            <?php include('get_featured_products.php'); ?>
            <?php while($row=$featured_products->fetch_assoc()) { ?>
              <!-- BEGIN SALE PRODUCT -->
              <div class="col-md-4 col-sm-6"> <!-- Mantido col-md-4 col-sm-6 -->
                <div class="product-item">
                  <div class="pi-img-wrapper" style="max-width: 250px; margin: 0 auto;"> <!-- Adicionado max-width e margin -->
                    <img src="./assets/prodcrispel/<?php echo $row['prod_imagem'];?>" class="img-responsive" alt="Berry Lace Dress" style="max-height: 200px; width: auto;"> <!-- Adicionado max-height -->
                    <div>
                      <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">Ver</a>
                    </div>
                  </div>
                  <h3><a href="<?php echo "shop-60x40.php?idproduto=". $row['idproduto'];?>"><?php echo $row['prod_nome'];?></a></h3>
                  <div class="pi-price">R$ <?php echo $row['prod_preco'];?></div>
                  <a href="<?php echo "shop-60x40.php?idproduto=". $row['idproduto'];?>" class="btn btn-default add2cart">Carrinho</a>
                  <div class="sticker sticker-sale"></div>
                </div>
              </div>
              <!-- END SALE PRODUCT -->
            <?php } ?>
          </div>
        </div>
        <!-- END SALE PRODUCT & NEW ARRIVALS -->
      </div>
    </div>

    <?php 
include('footer.php');

?>

    <!-- BEGIN fast view of a product -->
    <div id="product-pop-up" style="display: none; width: 700px;">
            <div class="product-page product-pop-up">
              <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-3">
                  <div class="product-main-image">
                    <img src="assets/pages/img/products/model7.jpg" alt="Cool green dress with red bell" class="img-responsive">
                  </div>
                  <div class="product-other-images">
                    <a href="javascript:;" class="active"><img alt="Berry Lace Dress" src="assets/pages/img/products/model3.jpg"></a>
                    <a href="javascript:;"><img alt="Berry Lace Dress" src="assets/pages/img/products/model4.jpg"></a>
                    <a href="javascript:;"><img alt="Berry Lace Dress" src="assets/pages/img/products/model5.jpg"></a>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-9">
                  <h1>Cool green dress with red bell</h1>
                  <div class="price-availability-block clearfix">
                    <div class="price">
                      <strong><span>$</span>47.00</strong>
                      <em>$<span>62.00</span></em>
                    </div>
                    <div class="availability">
                      Availability: <strong>In Stock</strong>
                    </div>
                  </div>
                  <div class="description">
                    <p>Lorem ipsum dolor ut sit ame dolore  adipiscing elit, sed nonumy nibh sed euismod laoreet dolore magna aliquarm erat volutpat 
Nostrud duis molestie at dolore.</p>
                  </div>
                  <div class="product-page-options">
                    <div class="pull-left">
                      <label class="control-label">Size:</label>
                      <select class="form-control input-sm">
                        <option>L</option>
                        <option>M</option>
                        <option>XL</option>
                      </select>
                    </div>
                    <div class="pull-left">
                      <label class="control-label">Color:</label>
                      <select class="form-control input-sm">
                        <option>Red</option>
                        <option>Blue</option>
                        <option>Black</option>
                      </select>
                    </div>
                  </div>
                  <div class="product-page-cart">
                    <div class="product-quantity">
                        <input id="product-quantity3" type="text" value="1" readonly class="form-control input-sm">
                    </div>
                    <button class="btn btn-primary" type="submit">Add to cart</button>
                    <a href="shop-item.html" class="btn btn-default">More details</a>
                  </div>
                </div>

                <div class="sticker sticker-sale"></div>
              </div>
            </div>
    </div>
    <!-- END fast view of a product -->

    <!-- Load javascripts at bottom, this will reduce page load time -->
    <!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
    <!--[if lt IE 9]>
    <script src="assets/plugins/respond.min.js"></script>  
    <![endif]-->  
    <script src="assets/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-migrate.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>      
    <script src="assets/corporate/scripts/back-to-top.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
    <script src="assets/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->
    <script src="assets/plugins/owl.carousel/owl.carousel.min.js" type="text/javascript"></script><!-- slider for products -->
    <script src='assets/plugins/zoom/jquery.zoom.min.js' type="text/javascript"></script><!-- product zoom -->
    <script src="assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script><!-- Quantity -->
    <script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
    <script src="assets/plugins/rateit/src/jquery.rateit.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js" type="text/javascript"></script><!-- for slider-range -->

    <script src="assets/corporate/scripts/layout.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            Layout.init();    
            Layout.initOWL();
            Layout.initTwitter();
            Layout.initImageZoom();
            Layout.initTouchspin();
            Layout.initUniform();
            Layout.initSliderRange();
        });
    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>