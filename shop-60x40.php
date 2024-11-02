<?php 
include('connection.php');

if (isset($_GET['idproduto'])) {
    $idproduto = $_GET['idproduto'];
    
    $stmt = $conn->prepare("SELECT * FROM produto WHERE idproduto = ?");
    $stmt -> bind_param("i", $idproduto);

    $stmt->execute();

    $products = $stmt->get_result();

    
} else {
    echo "ID do produto não especificado.";
}
?>



<?php 
include('header.php');

?>
    
    <div class="main">
      <div class="container">
        <ul class="breadcrumb">
            <li><a href="index.html">Início</a></li>
            <li><a href="">Etiquetas</a></li>
            <li class="active">Etiqueta 60x40</li>
        </ul>
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN SIDEBAR -->
          <div class="sidebar col-md-3 col-sm-5">
            <ul class="list-group margin-bottom-25 sidebar-menu">
              <li class="list-group-item clearfix dropdown" data-bs-toggle="list">
                <a href="shop-product-list.html" class="collapsed">
                  <i class="fa fa-angle-right"></i>
                  Etiquetas
                  
                </a>
                <ul class="dropdown-menu" style="display:block;">
                  <li class="list-group-item dropdown clearfix">
                    <a href="shop-product-list.html" class="collapsed"><i class="fa fa-angle-right"></i> Para Balanças</a>
                      <ul class="dropdown-menu" style="display:block;">
                        <li class="list-group-item dropdown clearfix">
                          <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 60x30 </a>
                          <a href="shop-60x40.html"><i class="fa fa-angle-right"></i> 60x40 </a>
                          <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 60x60 </a>
                          <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 40x30 </a>
                          <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 40x40 </a>
                          <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 40x60 </a>
                        </li>
                      </ul>

                      <li class="list-group-item dropdown clearfix">
                        <a href="shop-product-list.html" class="collapsed"><i class="fa fa-angle-right"></i> Para Gôndolas</a>
                          <ul class="dropdown-menu" style="display:block;">
                            <li class="list-group-item dropdown clearfix">
                              <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 105x40 </a>
                              <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 108x30 </a>
                            </li>
                          </ul>

                          <li class="list-group-item dropdown clearfix">
                            <a href="shop-product-list.html" class="collapsed"><i class="fa fa-angle-right"></i> Para Código de Barras</a>
                              <ul class="dropdown-menu" style="display:block;">
                                <li class="list-group-item dropdown clearfix">
                                  <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 33x22 </a>
                                  <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 33x26 </a>
                                </li>
                              </ul>

                              <li class="list-group-item dropdown clearfix">
                                <a href="shop-product-list.html" class="collapsed"><i class="fa fa-angle-right"></i> Para Precificação</a>
                                  <ul class="dropdown-menu" style="display:block;">
                                    <li class="list-group-item dropdown clearfix">
                                      <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> MX </a>
                                      <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 60x40 </a>
                                    </li>
                                  </ul>
                  </li>
                  <li><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> T-Shirts</a></li>
                </ul>
              </li>
              <li class="list-group-item clearfix dropdown active">
                <a href="shop-product-list.html" class="collapsed">
                  <i class="fa fa-angle-right"></i>
                  Bobinas
                  
                </a>
                <ul class="dropdown-menu" style="display:block;">
                  <li class="list-group-item dropdown clearfix active">
                            <li class="list-group-item dropdown clearfix">
                              <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 80x40 </a>
                              <a href="shop-product-list.html"><i class="fa fa-angle-right"></i> 80x80 </a>
                            </li>
                          </ul>
              <li class="list-group-item clearfix"><a href="shop-ribbon.html"><i class="fa fa-angle-right"></i> Ribbons</a></li>
              <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Personalizados</a></li>
              <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Brands</a></li>
            </ul>

            <div class="sidebar-products clearfix">
              <h2>Bestsellers</h2>
              <div class="item">
                <a href="shop-item.html"><img src="assets/pages/img/products/k1.jpg" alt="Some Shoes in Animal with Cut Out"></a>
                <h3><a href="shop-item.html">Some Shoes in Animal with Cut Out</a></h3>
                <div class="price">$31.00</div>
              </div>
              <div class="item">
                <a href="shop-item.html"><img src="assets/pages/img/products/k4.jpg" alt="Some Shoes in Animal with Cut Out"></a>
                <h3><a href="shop-item.html">Some Shoes in Animal with Cut Out</a></h3>
                <div class="price">$23.00</div>
              </div>
              <div class="item">
                <a href="shop-item.html"><img src="assets/pages/img/products/k3.jpg" alt="Some Shoes in Animal with Cut Out"></a>
                <h3><a href="shop-item.html">Some Shoes in Animal with Cut Out</a></h3>
                <div class="price">$86.00</div>
              </div>
            </div>
          </div>
          <!-- END SIDEBAR -->

          <!-- BEGIN CONTENT -->
          <div class="col-md-9 col-sm-7">
            <div class="product-page">
              <div class="row">
                <form method="POST" action="shop-shopping-cart.php">
                  <input type="hidden" name="prod_imagem" value="<?php echo $row['prod_imagem'];?>"/>
                  <input type="hidden" name="prod_nome" value="<?php echo $row['prod_nome'];?>"/>
                  <input type="hidden" name="prod_preco" value="<?php echo $row['prod_preco'];?>"/>
              <?php while($row = $products->fetch_assoc()) { ?>
                <div class="col-md-6 col-sm-6">
                  <div class="product-main-image">
                    <img src="./assets/pages/img/prodcrispel/<?php echo $row['prod_imagem'];?>" alt="Cool green dress with red bell" class="img-responsive" data-BigImgsrc="./assets/pages/img/prodcrispel/<?php echo $row['prod_imagem'];?>">
                  </div>
                  <div class="product-other-images">
                    <a href="assets/pages/img/products/model3.jpg" class="fancybox-button" rel="photos-lib"><img alt="Berry Lace Dress" src="assets/pages/img/products/model3.jpg"></a>
                    <a href="assets/pages/img/products/model4.jpg" class="fancybox-button" rel="photos-lib"><img alt="Berry Lace Dress" src="assets/pages/img/products/model4.jpg"></a>
                    <a href="assets/pages/img/products/model5.jpg" class="fancybox-button" rel="photos-lib"><img alt="Berry Lace Dress" src="assets/pages/img/products/model5.jpg"></a>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <h1><?php echo $row['prod_nome'];?></h1>
                  <div class="price-availability-block clearfix">
                    <div class="price">
                      <strong><span>R$</span><?php echo $row['prod_preco'];?></strong>
                    </div>
                    <div class="availability">
                      Disponibilidade: <strong>Em estoque</strong>
                    </div>
                  </div>
                  <div class="description">
                    <p><?php echo $row['prod_desc'];?></p>
                  </div>
                  <div class="product-page-options">
                    <div class="pull-left">
                      <label class="control-label">Quantidade:</label>
                      <select class="form-control input-sm" name="prod_quant" id="prod_quant">
                        <option value="100">100</option>
                        <option value="150">150</option>
                        <option value="200">200</option>
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
                    <form method="POST" action="shop-shopping-cart.php">
                      <input type="hidden" name="idproduto" value="<?php echo $row['idproduto'];?>"/>
                      <input type="hidden" name="prod_imagem" value="<?php echo $row['prod_imagem'];?>"/>
                      <input type="hidden" name="prod_nome" value="<?php echo $row['prod_nome'];?>"/>
                      <input type="hidden" name="prod_preco" value="<?php echo $row['prod_preco'];?>"/>
                      <button class="btn btn-primary" type="submit" name="add_to_cart">Carrinho</button>
                    </form>
                  </div>
                  <div class="review">
                    <input type="range" value="4" step="0.25" id="backing4">
                    <div class="rateit" data-rateit-backingfld="#backing4" data-rateit-resetable="false"  data-rateit-ispreset="true" data-rateit-min="0" data-rateit-max="5">
                    </div>
                  </div>
                </div>

                <div class="product-page-content">
                  <ul id="myTab" class="nav nav-tabs">
                    <li><a href="#Description" data-toggle="tab" class="active">Description</a></li>
                    <li><a href="#Information" data-toggle="tab">Information</a></li>
                  </ul>
                  <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade" id="Description">
                      <p>Lorem ipsum dolor ut sit ame dolore  adipiscing elit, sed sit nonumy nibh sed euismod laoreet dolore magna aliquarm erat sit volutpat Nostrud duis molestie at dolore. Lorem ipsum dolor ut sit ame dolore  adipiscing elit, sed sit nonumy nibh sed euismod laoreet dolore magna aliquarm erat sit volutpat Nostrud duis molestie at dolore. Lorem ipsum dolor ut sit ame dolore  adipiscing elit, sed sit nonumy nibh sed euismod laoreet dolore magna aliquarm erat sit volutpat Nostrud duis molestie at dolore. </p>
                    </div>
                    <div class="tab-pane fade" id="Information">
                      <table class="datasheet">
                        <tr>
                          <th colspan="2">Additional features</th>
                        </tr>
                        <tr>
                          <td class="datasheet-features-type">Value 1</td>
                          <td>21 cm</td>
                        </tr>
                        <tr>
                          <td class="datasheet-features-type">Value 2</td>
                          <td>700 gr.</td>
                        </tr>
                        <tr>
                          <td class="datasheet-features-type">Value 3</td>
                          <td>10 person</td>
                        </tr>
                        <tr>
                          <td class="datasheet-features-type">Value 4</td>
                          <td>14 cm</td>
                        </tr>
                        <tr>
                          <td class="datasheet-features-type">Value 5</td>
                          <td>plastic</td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
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

    <!-- BEGIN BRANDS -->
    <div class="brands">
      <div class="container">
            <div class="owl-carousel owl-carousel6-brands">
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/canon.jpg" alt="canon" title="canon"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/esprit.jpg" alt="esprit" title="esprit"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/gap.jpg" alt="gap" title="gap"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/next.jpg" alt="next" title="next"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/puma.jpg" alt="puma" title="puma"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/zara.jpg" alt="zara" title="zara"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/canon.jpg" alt="canon" title="canon"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/esprit.jpg" alt="esprit" title="esprit"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/gap.jpg" alt="gap" title="gap"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/next.jpg" alt="next" title="next"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/puma.jpg" alt="puma" title="puma"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/zara.jpg" alt="zara" title="zara"></a>
            </div>
        </div>
    </div>
    <!-- END BRANDS -->

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
                  <h2>Cool green dress with red bell</h2>
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
                        <input id="product-quantity2" type="text" value="1" readonly class="form-control input-sm">
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
    <!-- BEGIN CORE PLUGINS(REQUIRED FOR ALL PAGES) -->
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

    <script src="assets/corporate/scripts/layout.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            Layout.init();    
            Layout.initOWL();
            Layout.initTwitter();
            Layout.initImageZoom();
            Layout.initTouchspin();
            Layout.initUniform();
        });
    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>