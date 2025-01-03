<?php 
include('header.php');

?>

    <!-- BEGIN SLIDER -->
    <div class="page-slider margin-bottom-35">
        <div id="carousel-example-generic" class="carousel slide carousel-slider">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                <li data-target="#carousel-example-generic" data-slide-to="3"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">
                <!-- First slide -->
                <div class="item carousel-item-four active" style="background: url('./assets/pages/img/shop-slider/slide1/fundograd.png') no-repeat center center; background-size: cover;">
                </div>
                
                <!-- Second slide -->
                <div class="item carousel-item-five" style="background: url('./assets/pages/img/shop-slider/slide1/slide2.png') no-repeat center center; background-size: cover;">
                    <div class="container">
                        <div class="carousel-position-four text-center">
                        </div>
                    </div>
                </div>

                <!-- Third slide -->
                <div class="item carousel-item-six" style="background: url('./assets/pages/img/shop-slider/slide1/slide3.png') no-repeat center center; background-size: cover;">
                    <div class="container">
                        <div class="carousel-position-four text-center">
                        </div>
                    </div>
                </div>

                <!-- Fourth slide -->
            </div>

            <!-- Controls -->
            <a class="left carousel-control carousel-control-shop" href="#carousel-example-generic" role="button" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <a class="right carousel-control carousel-control-shop" href="#carousel-example-generic" role="button" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <!-- END SLIDER -->

    <div class="main">
      <div class="container">
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
                    <img src="./assets/prodG/<?php echo $row['prod_imagem'];?>" class="img-responsive" alt="produto" style="max-height: 200px; width: auto;"> <!-- Adicionado max-height -->
                    <div>
                      <a href="<?php echo "shop-60x40.php?idproduto=". $row['idproduto'];?>" class="btn btn-default fancybox-fast-view">Ver</a>
                    </div>
                  </div>
                  <h3><a href="<?php echo "shop-60x40.php?idproduto=". $row['idproduto'];?>"><?php echo $row['prod_nome'];?></a></h3>
                  <div class="pi-price">R$ <?php echo $row['prod_preco'];?></div>
                  <a href="<?php echo "shop-60x40.php?idproduto=". $row['idproduto'];?>" class="btn btn-default add2cart">Comprar</a>
                  <div class="sticker sticker-sale"></div>
                </div>
              </div>
              <!-- END SALE PRODUCT -->
            <?php } ?>
          </div>
        </div>
        <!-- END SALE PRODUCT & NEW ARRIVALS -->

        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40 ">
          <!-- BEGIN SIDEBAR -->
          <div class="sidebar col-md-3 col-sm-4">
            <ul class="list-group margin-bottom-25 sidebar-menu">
              <li class="list-group-item clearfix"><a href="shop-product-list-etiqueta.php"><i class="fa fa-angle-right"></i> Etiquetas</a></li>
              <li class="list-group-item clearfix"><a href="shop-product-list-bobina.php"><i class="fa fa-angle-right"></i> Bobinas</a></li>
              <li class="list-group-item clearfix"><a href="shop-product-list-ribbon.php"><i class="fa fa-angle-right"></i> Ribbons</a></li>
              <li class="list-group-item clearfix"><a href="shop-product-list.php"><i class="fa fa-angle-right"></i> Todos</a></li>
            </ul>
          </div>
          <!-- END SIDEBAR -->
          <!-- BEGIN CONTENT -->
          <div class="col-md-9 col-sm-8">
            <h2>Etiquetas</h2>
            <div class="row">
            <?php include('get_3_etiqueta.php'); ?>
            <?php while($row=$etiqueta2_products->fetch_assoc()) { ?>
              <!-- BEGIN SALE PRODUCT -->
              <div class="col-md-4 col-sm-6"> <!-- Mantido col-md-4 col-sm-6 -->
                <div class="product-item">
                  <div class="pi-img-wrapper" style="max-width: 250px; margin: 0 auto;"> <!-- Adicionado max-width e margin -->
                    <img src="./assets/prodG/<?php echo $row['prod_imagem'];?>" class="img-responsive" alt="produto" style="max-height: 200px; width: auto;"> <!-- Adicionado max-height -->
                    <div>
                      <a href="<?php echo "shop-60x40.php?idproduto=". $row['idproduto'];?>" class="btn btn-default fancybox-fast-view">Ver</a>
                    </div>
                  </div>
                  <h3><a href="<?php echo "shop-60x40.php?idproduto=". $row['idproduto'];?>"><?php echo $row['prod_nome'];?></a></h3>
                  <div class="pi-price">R$ <?php echo $row['prod_preco'];?></div>
                  <a href="<?php echo "shop-60x40.php?idproduto=". $row['idproduto'];?>" class="btn btn-default add2cart">Comprar</a>
                </div>
              </div>
              <!-- END SALE PRODUCT -->
            <?php } ?>
          </div>
          </div>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->

        <!-- BEGIN TWO FIXED IMAGES -->
      <style>
      .image-container {
          position: relative;
          overflow: hidden;
          margin-bottom: 20px;
          border-radius: 4px;
      }

      .image-container img {
          width: 100%;
          height: auto;
          max-height: 400px;
          object-fit: cover;
          transition: transform 0.3s ease;
      }

      .image-container:hover img {
          transform: scale(1.05);
      }

      .image-overlay {
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background: rgba(0, 0, 0, 0);
          display: flex;
          align-items: center;
          justify-content: center;
          opacity: 0;
          transition: all 0.3s ease;
      }

      .image-container:hover .image-overlay {
          background: rgba(0, 0, 0, 0.5);
          opacity: 1;
      }

      .overlay-text {
          color: white;
          font-size: 24px;
          font-weight: bold;
          text-align: center;
          transform: translateY(20px);
          transition: transform 0.3s ease;
      }

      .image-container:hover .overlay-text {
          transform: translateY(0);
      }

      .btn-overlay {
          padding: 10px 20px;
          background-color: #ff0000;
          color: white;
          text-decoration: none;
          border-radius: 4px;
          margin-top: 10px;
          display: inline-block;
          transition: background-color 0.3s ease;
      }

      .btn-overlay:hover {
          background-color: #ff0000;
          color: white;
          text-decoration: none;
      }
      </style>

      <div class="row margin-bottom-35">
          <!-- First Image -->
          <div class="col-md-6">
              <div class="image-container">
                  <img src="assets/pages/img/index-sliders/bobina.jpg" alt="Bobinas">
                  <div class="image-overlay">
                      <div class="overlay-text">
                          <h3 style="color: white; margin-bottom: 15px;">Bobinas Térmicas</h3>
                          <a href="shop-product-list-bobina.php" class="btn-overlay">Ver Produtos</a>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Second Image -->
          <div class="col-md-6">
              <div class="image-container">
                  <img src="assets/pages/img/index-sliders/ribbon.jpg" alt="Ribbons">
                  <div class="image-overlay">
                      <div class="overlay-text">
                          <h3 style="color: white; margin-bottom: 15px;">Ribbons</h3>
                          <a href="shop-product-list-ribbon.php" class="btn-overlay">Ver Produtos</a>
                      </div>
                  </div>
              </div>
          </div>
      </div>
<!-- END TWO FIXED IMAGES -->
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
                    <p>Lorem ipsum dolor ut sit ame dolore  adipiscing elit, sed nonumy nibh sed euismod laoreet dolore magna aliquarm erat volutpat Nostrud duis molestie at dolore.</p>
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

    <script src="assets/corporate/scripts/layout.js" type="text/javascript"></script>
    <script src="assets/pages/scripts/bs-carousel.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            Layout.init();    
            Layout.initOWL();
            Layout.initImageZoom();
            Layout.initTouchspin();
            Layout.initTwitter();
        });
    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>