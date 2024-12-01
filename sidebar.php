<!-- BEGIN SIDEBAR -->
<div class="sidebar col-md-3 col-sm-5">
            <ul class="list-group margin-bottom-25 sidebar-menu">
              <li class="list-group-item clearfix dropdown active">
                <a href="shop-product-list-etiqueta.php" class="collapsed"><i class="fa fa-angle-right"></i>Etiquetas</a>
                <ul class="dropdown-menu" style="display:block;">
                  <li class="list-group-item dropdown clearfix active">
                    <a href="" class="collapsed"><i class="fa fa-angle-right"></i> Para Balanças</a>
                      <ul class="dropdown-menu" style="display:block;">
                        <li class="list-group-item dropdown clearfix">
                          <a href="<?php echo "shop-60x40.php?idproduto=13";?>"><i class="fa fa-angle-right"></i> 60x30 </a>
                          <a href="<?php echo "shop-60x40.php?idproduto=8";?>"><i class="fa fa-angle-right"></i> 60x40 </a>
                          <a href="<?php echo "shop-60x40.php?idproduto=18";?>"><i class="fa fa-angle-right"></i> 60x60 </a>
                          <a href="<?php echo "shop-60x40.php?idproduto=5";?>"><i class="fa fa-angle-right"></i> 40x40 </a>
                          <a href="shop-product-list.php"><i class="fa fa-angle-right"></i> 40x60 </a>
                        </li>
                      </ul>

                      <li class="list-group-item dropdown clearfix active">
                        <a href="" class="collapsed"><i class="fa fa-angle-right"></i> Para Gôndolas</a>
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
                                <a href="<?php echo "shop-60x40.php?idproduto=17";?>"><i class="fa fa-angle-right"></i> 33x22 </a>
                                </li>
                              </ul>
                </ul>
              </li>
              <li class="list-group-item clearfix dropdown active">
                <a href="shop-product-list-bobina.php" class="collapsed"><i class="fa fa-angle-right"></i>Bobinas</a>
                <ul class="dropdown-menu" style="display:block;">
                        <li class="list-group-item dropdown clearfix">
                          <a href="<?php echo "shop-60x40.php?idproduto=6";?>"><i class="fa fa-angle-right"></i> 80x40 </a>
                          <a href="<?php echo "shop-60x40.php?idproduto=16";?>"><i class="fa fa-angle-right"></i> 80x80 </a>
                        </li>
                      </ul>
                      <li class="list-group-item clearfix dropdown active">
                <a href="shop-product-list-ribbon.php" class="collapsed"><i class="fa fa-angle-right"></i>Ribbons</a>
                <ul class="dropdown-menu" style="display:block;">
                        <li class="list-group-item dropdown clearfix">
                          <a href="<?php echo "shop-60x40.php?idproduto=7";?>"><i class="fa fa-angle-right"></i> 110x74 </a>
                          <a href="<?php echo "shop-60x40.php?idproduto=14";?>"><i class="fa fa-angle-right"></i> 110x300 </a>
                          <a href="<?php echo "shop-60x40.php?idproduto=15";?>"><i class="fa fa-angle-right"></i> 110x450 </a>
                        </li>
                      </ul>
              <li class="list-group-item clearfix"><a href="shop-product-list.php"><i class="fa fa-angle-right"></i> Todos</a></li>
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
          </div>
          <!-- END SIDEBAR -->