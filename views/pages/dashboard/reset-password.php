<?php require_once __DIR__."/../../../helper/init.php";
$page_title ="BLOG | RESET PASSWORD"; ?>
<?php require_once __DIR__."../../../includes/head-section.php";?>
<?php

    $sidebarSection = 'user';
    $sidebarSubSection = 'login';
    Util::createCSRFToken();
  $errors="";
  $old="";
  if(Session::hasSession('old'))
  {
    $old = Session::getSession('old');
    Session::unsetSession('old');
  }
  if(Session::hasSession('errors'))
  {
    $errors = unserialize(Session::getSession('errors'));
    Session::unsetSession('errors');
  }

  // Util::Dd($di->get('auth')->check());



  ?>
<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Reset Your Password!</h1>
                    <p class="mb-4">We get it, stuff happens. Just enter a memorable password this time and we will reset your password!</p>
                  </div>
                  <form class="user" action="<?=BASEASSETS?>../helper/routing.php" method="GET">
                    <div class="form-group">
                    <input type="hidden"
                              name="csrf_token"
                              value="<?= Session::getSession('csrf_token');?>"> 
                    <input type="hidden"
                    name="email"
                    value="<?=$_GET['email']?>"> 

                    <input type="hidden"
                    name="token"
                    value="<?=$_GET['token']?>"> 
                              
                      <input type="password" class="form-control form-control-user" id="password" aria-describedby="emailHelp" placeholder="Enter Password" name="password">
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Reset Password" name="resetPassword">
                      
                  </form>
               
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
