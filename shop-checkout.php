<?php 
include('header.php');

?>

    <div class="main">
      <div class="container">
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a></li>
            <li><a href="">Store</a></li>
            <li class="active">Checkout</li>
        </ul>
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
          <!-- BEGIN CONTENT -->
          <div class="col-md-12 col-sm-12">
            <h1>Checkout</h1>
            <!-- BEGIN CHECKOUT PAGE -->
            <div class="panel-group checkout-page accordion scrollable" id="checkout-page">

              <!-- BEGIN CHECKOUT -->
              <div id="checkout" class="panel panel-default">
                <div class="panel-heading">
                  <h2 class="panel-title">
                    <a data-toggle="collapse" data-parent="#checkout-page" href="#checkout-content" class="accordion-toggle">
                      Step 1: Checkout Options
                    </a>
                  </h2>
                </div>
                <div id="checkout-content" class="panel-collapse collapse in">
                  <div class="panel-body row">
                    <div class="col-md-6 col-sm-6">
                      <h3>New Customer</h3>
                      <p>Checkout Options:</p>
                      <div class="radio-list">
                        <label>
                          <input type="radio" name="account"  value="register"> Register Account
                        </label>
                        <label>
                          <input type="radio" name="account"  value="guest"> Guest Checkout
                        </label> 
                      </div>
                      <p>By creating an account you will be able to shop faster, be up to date on an order's status, and keep track of the orders you have previously made.</p>
                      <button class="btn btn-primary" type="submit" data-toggle="collapse" data-parent="#checkout-page" data-target="#payment-address-content">Continue</button>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <h3>Returning Customer</h3>
                      <p>I am a returning customer.</p>
                      <form role="form" action="#">
                        <div class="form-group">
                          <label for="email-login">E-Mail</label>
                          <input type="text" id="email-login" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="password-login">Password</label>
                          <input type="password" id="password-login" class="form-control">
                        </div>
                        <a href="javascript:;">Forgotten Password?</a>
                        <div class="padding-top-20">                  
                          <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                        <hr>
                        <div class="login-socio">
                          <p class="text-muted">or login using:</p>
                          <ul class="social-icons">
                            <li><a href="javascript:;" data-original-title="facebook" class="facebook" title="facebook"></a></li>
                            <li><a href="javascript:;" data-original-title="Twitter" class="twitter" title="Twitter"></a></li>
                            <li><a href="javascript:;" data-original-title="Google Plus" class="googleplus" title="Google Plus"></a></li>
                            <li><a href="javascript:;" data-original-title="Linkedin" class="linkedin" title="LinkedIn"></a></li>
                          </ul>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END CHECKOUT -->

              <!-- BEGIN PAYMENT ADDRESS -->
              <div id="payment-address" class="panel panel-default">
                <div class="panel-heading">
                  <h2 class="panel-title">
                    <a data-toggle="collapse" data-parent="#checkout-page" href="#payment-address-content" class="accordion-toggle">
                      Step 2: Account &amp; Billing Details
                    </a>
                  </h2>
                </div>
                <div id="payment-address-content" class="panel-collapse collapse">
                  <div class="panel-body row">
                    <div class="col-md-6 col-sm-6">
                      <h3>Your Personal Details</h3>
                      <div class="form-group">
                        <label for="firstname">First Name <span class="require">*</span></label>
                        <input type="text" id="firstname" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="lastname">Last Name <span class="require">*</span></label>
                        <input type="text" id="lastname" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="email">E-Mail <span class="require">*</span></label>
                        <input type="text" id="email" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="telephone">Telephone <span class="require">*</span></label>
                        <input type="text" id="telephone" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="fax">Fax</label>
                        <input type="text" id="fax" class="form-control">
                      </div>

                      <h3>Your Password</h3>
                      <div class="form-group">
                        <label for="password">Password <span class="require">*</span></label>
                        <input type="password" id="password" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="password-confirm">Password Confirm <span class="require">*</span></label>
                        <input type="text" id="password-confirm" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <h3>Your Address</h3>
                      <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" id="company" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="address1">Address 1</label>
                        <input type="text" id="address1" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="address2">Address 2</label>
                        <input type="text" id="address2" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="city">City <span class="require">*</span></label>
                        <input type="text" id="city" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="post-code">Post Code <span class="require">*</span></label>
                        <input type="text" id="post-code" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="country">Country <span class="require">*</span></label>
                        <select class="form-control input-sm" id="country">
                          <option value=""> --- Please Select --- </option>
                          <option value="244">Aaland Islands</option>
                          <option value="1">Afghanistan</option>
                          <option value="2">Albania</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="region-state">Region/State <span class="require">*</span></label>
                        <select class="form-control input-sm" id="region-state">
                          <option value=""> --- Please Select --- </option><option value="3513">Aberdeen</option><option value="3514">Aberdeenshire</option><option value="3515">Anglesey</option>
                        </select>
                      </div>
                    </div>
                    <hr>
                    <div class="col-md-12">                      
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> I wish to subscribe to the OXY newsletter. 
                        </label>
                      </div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" checked="checked"> My delivery and billing addresses are the same.
                        </label>
                      </div>
                      <button class="btn btn-primary  pull-right" type="submit" data-toggle="collapse" data-parent="#checkout-page" data-target="#shipping-address-content" id="button-payment-address">Continue</button>
                      <div class="checkbox pull-right">
                        <label>
                          <input type="checkbox"> I have read and agree to the <a title="Privacy Policy" href="javascript:;">Privacy Policy</a> &nbsp;&nbsp;&nbsp; 
                        </label>
                      </div>                        
                    </div>
                  </div>
                </div>
              </div>
              <!-- END PAYMENT ADDRESS -->

              <!-- BEGIN SHIPPING ADDRESS -->
              <div id="shipping-address" class="panel panel-default">
                <div class="panel-heading">
                  <h2 class="panel-title">
                    <a data-toggle="collapse" data-parent="#checkout-page" href="#shipping-address-content" class="accordion-toggle">
                      Step 3: Delivery Details
                    </a>
                  </h2>
                </div>
                <div id="shipping-address-content" class="panel-collapse collapse">
                  <div class="panel-body row">
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label for="firstname-dd">First Name <span class="require">*</span></label>
                        <input type="text" id="firstname-dd" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="lastname-dd">Last Name <span class="require">*</span></label>
                        <input type="text" id="lastname-dd" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="email-dd">E-Mail <span class="require">*</span></label>
                        <input type="text" id="email-dd" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="telephone-dd">Telephone <span class="require">*</span></label>
                        <input type="text" id="telephone-dd" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="fax-dd">Fax</label>
                        <input type="text" id="fax-dd" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="company-dd">Company</label>
                        <input type="text" id="company-dd" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                      <div class="form-group">
                        <label for="address1-dd">Address 1</label>
                        <input type="text" id="address1-dd" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="address2-dd">Address 2</label>
                        <input type="text" id="address2-dd" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="city-dd">City <span class="require">*</span></label>
                        <input type="text" id="city-dd" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="post-code-dd">Post Code <span class="require">*</span></label>
                        <input type="text" id="post-code-dd" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="country-dd">Country <span class="require">*</span></label>
                        <select class="form-control input-sm" id="country-dd">
                          <option value=""> --- Please Select --- </option>
                          <option value="244">Aaland Islands</option>
                          <option value="1">Afghanistan</option>
                          <option value="2">Albania</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="region-state-dd">Region/State <span class="require">*</span></label>
                        <select class="form-control input-sm" id="region-state-dd">
                          <option value=""> --- Please Select --- </option><option value="3513">Aberdeen</option><option value="3514">Aberdeenshire</option><option value="3515">Anglesey</option><option value="3516">Angus</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <button class="btn btn-primary  pull-right" type="submit" id="button-shipping-address" data-toggle="collapse" data-parent="#checkout-page" data-target="#shipping-method-content">Continue</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END SHIPPING ADDRESS -->

              <!-- BEGIN SHIPPING METHOD -->
              <div id="shipping-method" class="panel panel-default">
                <div class="panel-heading">
                  <h2 class="panel-title">
                    <a data-toggle="collapse" data-parent="#checkout-page" href="#shipping-method-content" class="accordion-toggle">
                      Step 4: Delivery Method
                    </a>
                  </h2>
                </div>
                <div id="shipping-method-content" class="panel-collapse collapse">
                  <div class="panel-body row">
                    <div class="col-md-12">
                      <p>Please select the preferred shipping method to use on this order.</p>
                      <h4>Flat Rate</h4>
                      <div class="radio-list">
                        <label>
                          <input type="radio" name="FlatShippingRate" value="FlatShippingRate"> Flat Shipping Rate
                        </label>
                      </div>
                      <div class="form-group">
                        <label for="delivery-comments">Add Comments About Your Order</label>
                        <textarea id="delivery-comments" rows="8" class="form-control"></textarea>
                      </div>
                      <button class="btn btn-primary  pull-right" type="submit" id="button-shipping-method" data-toggle="collapse" data-parent="#checkout-page" data-target="#payment-method-content">Continue</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END SHIPPING METHOD -->

              <!-- BEGIN PAYMENT METHOD -->
              <div id="payment-method" class="panel panel-default">
                <div class="panel-heading">
                  <h2 class="panel-title">
                    <a data-toggle="collapse" data-parent="#checkout-page" href="#payment-method-content" class="accordion-toggle">
                      Step 5: Payment Method
                    </a>
                  </h2>
                </div>
                <div id="payment-method-content" class="panel-collapse collapse">
                  <div class="panel-body row">
                    <div class="col-md-12">
                      <p>Please select the preferred payment method to use on this order.</p>
                      <div class="radio-list">
                        <label>
                          <input type="radio" name="CashOnDelivery" value="CashOnDelivery"> Cash On Delivery
                        </label>
                      </div>
                      <div class="form-group">
                        <label for="delivery-payment-method">Add Comments About Your Order</label>
                        <textarea id="delivery-payment-method" rows="8" class="form-control"></textarea>
                      </div>
                      <button class="btn btn-primary  pull-right" type="submit" id="button-payment-method" data-toggle="collapse" data-parent="#checkout-page" data-target="#confirm-content">Continue</button>
                      <div class="checkbox pull-right">
                        <label>
                          <input type="checkbox"> I have read and agree to the <a title="Terms & Conditions" href="javascript:;">Terms & Conditions </a> &nbsp;&nbsp;&nbsp; 
                        </label>
                      </div>  
                    </div>
                  </div>
                </div>
              </div>
              <!-- END PAYMENT METHOD -->

              <!-- BEGIN CONFIRM -->
              <div id="confirm" class="panel panel-default">
                <div class="panel-heading">
                  <h2 class="panel-title">
                    <a data-toggle="collapse" data-parent="#checkout-page" href="#confirm-content" class="accordion-toggle">
                      Step 6: Confirm Order
                    </a>
                  </h2>
                </div>
                <div id="confirm-content" class="panel-collapse collapse">
                  <div class="panel-body row">
                    <div class="col-md-12 clearfix">
                      <div class="table-wrapper-responsive">
                      <table>
                        <tr>
                          <th class="checkout-image">Image</th>
                          <th class="checkout-description">Description</th>
                          <th class="checkout-model">Model</th>
                          <th class="checkout-quantity">Quantity</th>
                          <th class="checkout-price">Price</th>
                          <th class="checkout-total">Total</th>
                        </tr>
                        <tr>
                          <td class="checkout-image">
                            <a href="javascript:;"><img src="assets/pages/img/products/model3.jpg" alt="Berry Lace Dress"></a>
                          </td>
                          <td class="checkout-description">
                            <h3><a href="javascript:;">Cool green dress with red bell</a></h3>
                            <p><strong>Item 1</strong> - Color: Green; Size: S</p>
                            <em>More info is here</em>
                          </td>
                          <td class="checkout-model">RES.193</td>
                          <td class="checkout-quantity">1</td>
                          <td class="checkout-price"><strong><span>$</span>47.00</strong></td>
                          <td class="checkout-total"><strong><span>$</span>47.00</strong></td>
                        </tr>
                        <tr>
                          <td class="checkout-image">
                            <a href="javascript:;"><img src="assets/pages/img/products/model4.jpg" alt="Berry Lace Dress"></a>
                          </td>
                          <td class="checkout-description">
                            <h3><a href="javascript:;">Cool green dress with red bell</a></h3>
                            <p><strong>Item 1</strong> - Color: Green; Size: S</p>
                            <em>More info is here</em>
                          </td>
                          <td class="checkout-model">RES.193</td>
                          <td class="checkout-quantity">1</td>
                          <td class="checkout-price"><strong><span>$</span>47.00</strong></td>
                          <td class="checkout-total"><strong><span>$</span>47.00</strong></td>
                        </tr>
                      </table>
                      </div>
                      <div class="checkout-total-block">
                        <ul>
                          <li>
                            <em>Sub total</em>
                            <strong class="price"><span>$</span>47.00</strong>
                          </li>
                          <li>
                            <em>Shipping cost</em>
                            <strong class="price"><span>$</span>3.00</strong>
                          </li>
                          <li>
                            <em>Eco Tax (-2.00)</em>
                            <strong class="price"><span>$</span>3.00</strong>
                          </li>
                          <li>
                            <em>VAT (17.5%)</em>
                            <strong class="price"><span>$</span>3.00</strong>
                          </li>
                          <li class="checkout-total-price">
                            <em>Total</em>
                            <strong class="price"><span>$</span>56.00</strong>
                          </li>
                        </ul>
                      </div>
                      <div class="clearfix"></div>
                      <button class="btn btn-primary pull-right" type="submit" id="button-confirm">Confirm Order</button>
                      <button type="button" class="btn btn-default pull-right margin-right-20">Cancel</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- END CONFIRM -->
            </div>
            <!-- END CHECKOUT PAGE -->
          </div>
          <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
      </div>
    </div>

    <!-- BEGIN STEPS -->
    <div class="steps-block steps-block-red">
      <div class="container">
        <div class="row">
          <div class="col-md-4 steps-block-col">
            <i class="fa fa-truck"></i>
            <div>
              <h2>Free shipping</h2>
              <em>Express delivery withing 3 days</em>
            </div>
            <span>&nbsp;</span>
          </div>
          <div class="col-md-4 steps-block-col">
            <i class="fa fa-gift"></i>
            <div>
              <h2>Daily Gifts</h2>
              <em>3 Gifts daily for lucky customers</em>
            </div>
            <span>&nbsp;</span>
          </div>
          <div class="col-md-4 steps-block-col">
            <i class="fa fa-phone"></i>
            <div>
              <h2>477 505 8877</h2>
              <em>24/7 customer care available</em>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END STEPS -->

    <!-- BEGIN PRE-FOOTER -->
    <div class="pre-footer">
      <div class="container">
        <div class="row">
          <!-- BEGIN BOTTOM ABOUT BLOCK -->
          <div class="col-md-3 col-sm-6 pre-footer-col">
            <h2>About us</h2>
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam sit nonummy nibh euismod tincidunt ut laoreet dolore magna aliquarm erat sit volutpat. Nostrud exerci tation ullamcorper suscipit lobortis nisl aliquip  commodo consequat. </p>
            <p>Duis autem vel eum iriure dolor vulputate velit esse molestie at dolore.</p>
          </div>
          <!-- END BOTTOM ABOUT BLOCK -->
          <!-- BEGIN BOTTOM INFO BLOCK -->
          <div class="col-md-3 col-sm-6 pre-footer-col">
            <h2>Information</h2>
            <ul class="list-unstyled">
              <li><i class="fa fa-angle-right"></i> <a href="javascript:;">Delivery Information</a></li>
              <li><i class="fa fa-angle-right"></i> <a href="javascript:;">Customer Service</a></li>
              <li><i class="fa fa-angle-right"></i> <a href="javascript:;">Order Tracking</a></li>
              <li><i class="fa fa-angle-right"></i> <a href="javascript:;">Shipping &amp; Returns</a></li>
              <li><i class="fa fa-angle-right"></i> <a href="contacts.html">Contact Us</a></li>
              <li><i class="fa fa-angle-right"></i> <a href="javascript:;">Careers</a></li>
              <li><i class="fa fa-angle-right"></i> <a href="javascript:;">Payment Methods</a></li>
            </ul>
          </div>
          <!-- END INFO BLOCK -->

          <!-- BEGIN TWITTER BLOCK --> 
          <div class="col-md-3 col-sm-6 pre-footer-col">
            <h2 class="margin-bottom-0">Latest Tweets</h2>
            <a class="twitter-timeline" href="https://twitter.com/twitterapi" data-tweet-limit="2" data-theme="dark" data-link-color="#57C8EB" data-widget-id="455411516829736961" data-chrome="noheader nofooter noscrollbar noborders transparent">Loading tweets by @keenthemes...</a>      
          </div>
          <!-- END TWITTER BLOCK -->
          
          <!-- BEGIN BOTTOM CONTACTS -->
          <div class="col-md-3 col-sm-6 pre-footer-col">
            <h2>Our Contacts</h2>
            <address class="margin-bottom-40">
              35, Lorem Lis Street, Park Ave<br>
              California, US<br>
              Phone: 300 323 3456<br>
              Fax: 300 323 1456<br>
              Email: <a href="mailto:info@metronic.com">info@metronic.com</a><br>
              Skype: <a href="skype:metronic">metronic</a>
            </address>
          </div>
          <!-- END BOTTOM CONTACTS -->
        </div>
        <hr>
        <div class="row">
          <!-- BEGIN SOCIAL ICONS -->
          <div class="col-md-6 col-sm-6">
            <ul class="social-icons">
              <li><a class="rss" data-original-title="rss" href="javascript:;"></a></li>
              <li><a class="facebook" data-original-title="facebook" href="javascript:;"></a></li>
              <li><a class="twitter" data-original-title="twitter" href="javascript:;"></a></li>
              <li><a class="googleplus" data-original-title="googleplus" href="javascript:;"></a></li>
              <li><a class="linkedin" data-original-title="linkedin" href="javascript:;"></a></li>
              <li><a class="youtube" data-original-title="youtube" href="javascript:;"></a></li>
              <li><a class="vimeo" data-original-title="vimeo" href="javascript:;"></a></li>
              <li><a class="skype" data-original-title="skype" href="javascript:;"></a></li>
            </ul>
          </div>
          <!-- END SOCIAL ICONS -->
          <!-- BEGIN NEWLETTER -->
          <div class="col-md-6 col-sm-6">
            <div class="pre-footer-subscribe-box pull-right">
              <h2>Newsletter</h2>
              <form action="#">
                <div class="input-group">
                  <input type="text" placeholder="youremail@mail.com" class="form-control">
                  <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">Subscribe</button>
                  </span>
                </div>
              </form>
            </div> 
          </div>
          <!-- END NEWLETTER -->
        </div>
      </div>
    </div>
    <!-- END PRE-FOOTER -->

    <!-- BEGIN FOOTER -->
    <div class="footer">
      <div class="container">
        <div class="row">
          <!-- BEGIN COPYRIGHT -->
          <div class="col-md-4 col-sm-4 padding-top-10">
            2015 © Keenthemes. ALL Rights Reserved. 
          </div>
          <!-- END COPYRIGHT -->
          <!-- BEGIN PAYMENTS -->
          <div class="col-md-4 col-sm-4">
            <ul class="list-unstyled list-inline pull-right">
              <li><img src="assets/corporate/img/payments/western-union.jpg" alt="We accept Western Union" title="We accept Western Union"></li>
              <li><img src="assets/corporate/img/payments/american-express.jpg" alt="We accept American Express" title="We accept American Express"></li>
              <li><img src="assets/corporate/img/payments/MasterCard.jpg" alt="We accept MasterCard" title="We accept MasterCard"></li>
              <li><img src="assets/corporate/img/payments/PayPal.jpg" alt="We accept PayPal" title="We accept PayPal"></li>
              <li><img src="assets/corporate/img/payments/visa.jpg" alt="We accept Visa" title="We accept Visa"></li>
            </ul>
          </div>
          <!-- END PAYMENTS -->
          <!-- BEGIN POWERED -->
          <div class="col-md-4 col-sm-4 text-right">
            <p class="powered">Powered by: <a href="http://www.keenthemes.com/">KeenThemes.com</a></p>
          </div>
          <!-- END POWERED -->
        </div>
      </div>
    </div>
    <!-- END FOOTER -->

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

    <script src="assets/corporate/scripts/layout.js" type="text/javascript"></script>
    <script src="assets/pages/scripts/checkout.js" type="text/javascript"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            Layout.init();    
            Layout.initOWL();
            Layout.initTwitter();
            Layout.initImageZoom();
            Layout.initTouchspin();
            Layout.initUniform();
            Checkout.init();
        });
    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>