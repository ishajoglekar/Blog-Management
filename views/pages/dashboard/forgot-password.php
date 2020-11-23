<?php require_once __DIR__ . "/../../../helper/init.php";
$page_title = "BLOG | FORGOT PASSWORD"; ?>
<?php require_once __DIR__ . "../../../includes/head-section.php"; ?>
<?php

$sidebarSection = 'user';
$sidebarSubSection = 'login';
Util::createCSRFToken();
$errors = "";
$old = "";
if (Session::hasSession('old')) {
  $old = Session::getSession('old');
  Session::unsetSession('old');
}
if (Session::hasSession('errors')) {
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
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                  </div>
                  <form class="user" action="<?= BASEASSETS ?>../helper/routing.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= Session::getSession('csrf_token'); ?>">
                    <div class="form-group">
                      <input type="text" class="form-control form-control-user <?= $errors != '' ? ($errors->has('email') ? 'error is-invalid' : '') : ''; ?>" id="email" placeholder="Email ID" value="<?= $old != '' ? $old['email'] : ''; ?>" name="email">
                      <?php
                      if ($errors != "" && $errors->has('email')) :
                        echo "<span class='error'> {$errors->first('email')}</span>";
                      endif;
                      ?>
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" value="Reset Password" name="resetRequest">


                  </form>
                  <hr>
                  <div class="row">
                    <a class="small col-md-5" href="<?= BASEPAGES ?>dashboard/register.php">Create an Account!</a>
                    <a class="small col-md-7 " href="<?= BASEPAGES ?>dashboard/login.php">Already have an account? Login!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->


  <?php require_once __DIR__ . "../../../includes/core-scripts.php"; ?>
  <?php require_once __DIR__ . "../../../includes/page-level/forgot-password-scripts.php"; ?>

</body>

</html>