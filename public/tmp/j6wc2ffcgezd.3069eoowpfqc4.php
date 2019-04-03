
<?php echo $this->render('layouts/header.html',NULL,get_defined_vars(),0); ?>
<?= ($db)."
" ?>
<body class="animsition page-login-v3 layout-full">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<!-- Page -->
<div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">>
  <div class="page-content vertical-align-middle animation-slide-top animation-duration-1">
    <div class="panel">
      <div class="panel-body">
        <div class="brand">
          <img class="brand-img" src="assets//images/logo-colored.png" alt="...">
          <h2 class="brand-text font-size-18">Remark</h2>
        </div>
        <form method="post" action="#">
          <div class="form-group form-material floating" data-plugin="formMaterial">
            <input type="email" class="form-control" name="email" />
            <label class="floating-label">Email</label>
          </div>
          <div class="form-group form-material floating" data-plugin="formMaterial">
            <input type="password" class="form-control" name="password" />
            <label class="floating-label">Password</label>
          </div>
          <div class="form-group clearfix">
            <div class="checkbox-custom checkbox-inline checkbox-primary checkbox-lg float-left">
              <input type="checkbox" id="inputCheckbox" name="remember">
              <label for="inputCheckbox">Remember me</label>
            </div>
            <a class="float-right" href="forgot-password.html">Forgot password?</a>
          </div>
          <button type="submit" class="btn btn-primary btn-block btn-lg mt-40">Sign in</button>
        </form>
        <p>Still no account? Please go to <a href="register-v3.html">Sign up</a></p>
      </div>
    </div>

    <footer class="page-copyright page-copyright-inverse">
      <p>WEBSITE BY Creation Studio</p>
      <p>© 2018. All RIGHT RESERVED.</p>
      <div class="social">
        <a class="btn btn-icon btn-pure" href="javascript:void(0)">
          <i class="icon bd-twitter" aria-hidden="true"></i>
        </a>
        <a class="btn btn-icon btn-pure" href="javascript:void(0)">
          <i class="icon bd-facebook" aria-hidden="true"></i>
        </a>
        <a class="btn btn-icon btn-pure" href="javascript:void(0)">
          <i class="icon bd-google-plus" aria-hidden="true"></i>
        </a>
      </div>
    </footer>
  </div>
</div>
<!-- End Page -->


<!-- Core  -->
<script src="global/vendor/babel-external-helpers/babel-external-helpers.js"></script>
<script src="global/vendor/jquery/jquery.js"></script>
<script src="global/vendor/popper-js/umd/popper.min.js"></script>
<script src="global/vendor/bootstrap/bootstrap.js"></script>
<script src="global/vendor/animsition/animsition.js"></script>
<script src="global/vendor/mousewheel/jquery.mousewheel.js"></script>
<script src="global/vendor/asscrollbar/jquery-asScrollbar.js"></script>
<script src="global/vendor/asscrollable/jquery-asScrollable.js"></script>
<script src="global/vendor/ashoverscroll/jquery-asHoverScroll.js"></script>

<!-- Plugins -->
<script src="global/vendor/switchery/switchery.js"></script>
<script src="global/vendor/intro-js/intro.js"></script>
<script src="global/vendor/screenfull/screenfull.js"></script>
<script src="global/vendor/slidepanel/jquery-slidePanel.js"></script>
<script src="global/vendor/jquery-placeholder/jquery.placeholder.js"></script>

<!-- Scripts -->
<script src="global/js/Component.js"></script>
<script src="global/js/Plugin.js"></script>
<script src="global/js/Base.js"></script>
<script src="global/js/Config.js"></script>

<script src="assets/js/Section/Menubar.js"></script>
<script src="assets/js/Section/GridMenu.js"></script>
<script src="assets/js/Section/Sidebar.js"></script>
<script src="assets/js/Section/PageAside.js"></script>
<script src="assets/js/Plugin/menu.js"></script>

<script src="global/js/config/colors.js"></script>
<script src="assets/js/config/tour.js"></script>
<script>Config.set('assets', 'assets');</script>

<!-- Page -->
<script src="assets/js/Site.js"></script>
<script src="global/js/Plugin/asscrollable.js"></script>
<script src="global/js/Plugin/slidepanel.js"></script>
<script src="global/js/Plugin/switchery.js"></script>
<script src="global/js/Plugin/jquery-placeholder.js"></script>
<script src="global/js/Plugin/material.js"></script>

<script>
  (function(document, window, $){
    'use strict';

    var Site = window.Site;
    $(document).ready(function(){
      Site.run();
    });
  })(document, window, jQuery);
</script>
</body>
</html>
