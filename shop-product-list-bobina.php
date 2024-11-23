<?php 
include('header.php');
?>

<div class="title-wrapper" style="background: url('./assets/pages/img/title-bg/bobina.png') no-repeat center center; background-size: cover;">
      <div class="container"><div class="container-inner">
        <h1><span>BOBINAS</span> TÉRMICAS</h1>
        <em>Escolha já o tamanho da sua Bobina!</em>
      </div></div>
    </div>

    <div class="main">
      <div class="container">
        <ul class="breadcrumb">
            <li><a href="shop-index.php">Início</a></li>
            <li class="active">Bobinas</li>
        </ul>
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN SIDEBAR -->
          <div class="sidebar col-md-3 col-sm-5">
            <ul class="list-group margin-bottom-25 sidebar-menu">
              <li class="list-group-item clearfix dropdown active">
                <a href="shop-product-list.html" class="collapsed">
                  <i class="fa fa-angle-right"></i>
                  Etiquetas
                  
                </a>
                <ul class="dropdown-menu" style="display:block;">
                  <li class="list-group-item dropdown clearfix active">
                    <a href="shop-product-list.html" class="collapsed"><i class="fa fa-angle-right"></i> Para Balanças</a>
                      <ul class="dropdown-menu" style="display:block;">
                        <li class="list-group-item dropdown clearfix">
                          <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 60x30 </a>
                          <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 60x40 </a>
                          <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 60x60 </a>
                          <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 40x30 </a>
                          <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 40x40 </a>
                          <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 40x60 </a>
                        </li>
                      </ul>

                      <li class="list-group-item dropdown clearfix active">
                        <a href="shop-product-list.php" class="collapsed"><i class="fa fa-angle-right"></i> Para Gôndolas</a>
                          <ul class="dropdown-menu" style="display:block;">
                            <li class="list-group-item dropdown clearfix">
                              <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 105x40 </a>
                              <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 108x30 </a>
                            </li>
                          </ul>

                          <li class="list-group-item dropdown clearfix active">
                            <a href="shop-product-list.php" class="collapsed"><i class="fa fa-angle-right"></i> Para Código de Barras</a>
                              <ul class="dropdown-menu" style="display:block;">
                                <li class="list-group-item dropdown clearfix">
                                  <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 33x22 </a>
                                  <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 33x26 </a>
                                </li>
                              </ul>

                              <li class="list-group-item dropdown clearfix active">
                                <a href="shop-product-list.php" class="collapsed"><i class="fa fa-angle-right"></i> Para Precificação</a>
                                  <ul class="dropdown-menu" style="display:block;">
                                    <li class="list-group-item dropdown clearfix">
                                      <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> MX </a>
                                      <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 60x40 </a>
                                    </li>
                                  </ul>
                  </li>
                  <li><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> T-Shirts</a></li>
                </ul>
              </li>
              <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Bobinas</a></li>
              <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Ribbons</a></li>
              <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Personalizados</a></li>
              <li class="list-group-item clearfix"><a href="shop-product-list.html"><i class="fa fa-angle-right"></i> Brands</a></li>
            </ul>

            <div class="sidebar-filter margin-bottom-25">
              <h2>Filtrar</h2>
              <h3>Disponibilidade</h3>
              <div class="checkbox-list">
                <label><input type="checkbox"> Indisponível (3)</label>
                <label><input type="checkbox"> Em Estoque (26)</label>
              </div>

              <h3>Preço</h3>
              <p>
                <label for="amount">Range:</label>
                <input type="text" id="amount" style="border:0; color:#f6931f; font-weight:bold;">
              </p>
              <div id="slider-range"></div>
            </div>

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
            <div class="row list-view-sorting clearfix">
              <div class="col-md-2 col-sm-2 list-view">
                <a href="javascript:;"><i class="fa fa-th-large"></i></a>
                <a href="javascript:;"><i class="fa fa-th-list"></i></a>
              </div>
              <div class="col-md-10 col-sm-10">
                <div class="pull-right">
                  <label class="control-label">Show:</label>
                  <select class="form-control input-sm">
                    <option value="#?limit=24" selected="selected">24</option>
                    <option value="#?limit=25">25</option>
                    <option value="#?limit=50">50</option>
                    <option value="#?limit=75">75</option>
                    <option value="#?limit=100">100</option>
                  </select>
                </div>
                <div class="pull-right">
                  <label class="control-label">Sort&nbsp;By:</label>
                  <select class="form-control input-sm">
                    <option value="#?sort=p.sort_order&amp;order=ASC" selected="selected">Default</option>
                    <option value="#?sort=pd.name&amp;order=ASC">Name (A - Z)</option>
                    <option value="#?sort=pd.name&amp;order=DESC">Name (Z - A)</option>
                    <option value="#?sort=p.price&amp;order=ASC">Price (Low &gt; High)</option>
                    <option value="#?sort=p.price&amp;order=DESC">Price (High &gt; Low)</option>
                    <option value="#?sort=rating&amp;order=DESC">Rating (Highest)</option>
                    <option value="#?sort=rating&amp;order=ASC">Rating (Lowest)</option>
                    <option value="#?sort=p.model&amp;order=ASC">Model (A - Z)</option>
                    <option value="#?sort=p.model&amp;order=DESC">Model (Z - A)</option>
                  </select>
                </div>
              </div>
            </div>
            <!-- BEGIN PRODUCT LIST -->
            <div class="row product-list">
            <?php include('get_bobinas.php'); ?>
            <?php while($row=$bobina_products->fetch_assoc()) { ?>
              <!-- PRODUCT ITEM START -->
              <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="product-item">
                  <div class="pi-img-wrapper">
                    <img src="assets/pages/img/products/60x40 (1).png" class="img-responsive" alt="Berry Lace Dress">
                    <div>
                      <a href="assets/pages/img/products/60x40 (1).png" class="btn btn-default fancybox-button">Zoom</a>
                      <a href="#product-pop-up" class="btn btn-default fancybox-fast-view">Ver</a>
                    </div>
                  </div>
                  <h3><a href="<?php echo "shop-60x40.php?idproduto=". $row['idproduto'];?>"><?php echo $row['prod_nome'];?></a></h3>
                  <div class="pi-price">R$<?php echo $row['prod_preco'];?></div>
                  <a href="<?php echo "shop-60x40.php?idproduto=".$row['idproduto'];?>" class="btn btn-default add2cart">Carrinho</a>
                </div>
              </div>
              <?php } ?>
              <!-- PRODUCT ITEM END -->
            </div>
            <!-- END PRODUCT LIST -->
            <!-- BEGIN PAGINATOR -->
            <div class="row">
              <div class="col-md-4 col-sm-4 items-info">Items 1 to 9 of 10 total</div>
              <div class="col-md-8 col-sm-8">
                <ul class="pagination pull-right">
                  <li><a href="javascript:;">&laquo;</a></li>
                  <li><span>1</span></li>
                  <li><a href="javascript:;">2</a></li>
                  <li><a href="javascript:;">3</a></li>
                  <li><a href="javascript:;">4</a></li>
                  <li><a href="javascript:;">5</a></li>
                  <li><a href="javascript:;">&raquo;</a></li>
                </ul>
              </div>
            </div>
            <!-- END PAGINATOR -->
          </div>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
      </div>
    </div>

<!-- BEGIN BRANDS -->
<div class="brands">
      <div class="container">
            <div class="owl-carousel owl-carousel6-brands">
              <a href="shop-product-list.php"><img src="./assets/pages/img/brands/filizola.png" alt="filizola" title="filizola"></a>
              <a href="shop-product-list.html"><img src="./assets/pages/img/brands/toledo.png" alt="toledo" title="toledo"></a>
              <a href="shop-product-list.html"><img src="./assets/pages/img/brands/weightech.jpg" alt="weightech" title="weightech"></a>
              <a href="shop-product-list.html"><img src="./assets/pages/img/brands/urano.png" alt="urano" title="urano"></a>
              <a href="shop-product-list.html"><img src="./assets/pages/img/brands/triunfo.png" alt="triunfo" title="triunfo"></a>
              <a href="shop-product-list.html"><img src="assets/pages/img/brands/digitron.png" alt="digitron" title="digitron"></a>
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
                        <input id="product-quantity" type="text" value="1" readonly name="product-quantity" class="form-control input-sm">
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