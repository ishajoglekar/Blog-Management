<?php require_once __DIR__ . "/../../../helper/init.php";
$page_title = "BLOG | REGISTER";
?>
<?php require_once __DIR__ . "../../../includes/head-section.php"; ?>

<?php

$sidebarSection = 'user';
$sidebarSubSection = 'add';
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
?>


<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
          <div class="col-lg-7">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
              </div>

              <form class="user" action="<?= BASEASSETS ?>../helper/routing.php" method="POST" id="register">



                <div class="form-group row">

                  <input type="hidden" name="csrf_token" value="<?= Session::getSession('csrf_token'); ?>">

                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user <?= $errors != '' ? ($errors->has('first_name') ? 'error is-invalid' : '') : ''; ?>" id="first_name" placeholder="First Name" value="<?= $old != '' ? $old['first_name'] : ''; ?>" name="first_name">
                    <?php
                    if ($errors != "" && $errors->has('first_name')) :
                      echo "<span class='error'> {$errors->first('first_name')}</span>";
                    endif;
                    ?>
                  </div>

                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user <?= $errors != '' ? ($errors->has('last_name') ? 'error is-invalid' : '') : ''; ?>" id="last_name" placeholder="Last Name" value="<?= $old != '' ? $old['last_name'] : ''; ?>" name="last_name">
                    <?php
                    if ($errors != "" && $errors->has('last_name')) :
                      echo "<span class='error'> {$errors->first('last_name')}</span>";
                    endif;
                    ?>
                  </div>


                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user <?= $errors != '' ? ($errors->has('username') ? 'error is-invalid' : '') : ''; ?>" id="username" placeholder="UserName" value="<?= $old != '' ? $old['username'] : ''; ?>" name="username">
                  <?php
                  if ($errors != "" && $errors->has('username')) :
                    echo "<span class='error'> {$errors->first('username')}</span>";
                  endif;
                  ?>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user <?= $errors != '' ? ($errors->has('email') ? 'error is-invalid' : '') : ''; ?>" id="email" placeholder="Email Address" value="<?= $old != '' ? $old['email'] : ''; ?>" name="email">
                    <?php
                    if ($errors != "" && $errors->has('email')) :
                      echo "<span class='error'> {$errors->first('email')}</span>";
                    endif;
                    ?>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user <?= $errors != '' ? ($errors->has('password') ? 'error is-invalid' : '') : ''; ?>" id="password" placeholder="Password" name="password">
                    <?php
                    if ($errors != "" && $errors->has('password')) :
                      echo "<span class='error'> {$errors->first('password')}</span>";
                    endif;
                    ?>
                  </div>

                  <div class="col-md-12 mt-3">
                    <input type="submit" class="btn btn-user btn-block btn-primary" name="add_user" value="Sign Up">
                    <!-- <input type="submit" class="btn  btn-primary  " value="LOGIN" name="add_user" id="add_user"> -->
                  </div>
                </div>

                <hr>

              </form>

              <div class="row">
                <a class=" col-md-6" href="<?= BASEPAGES ?>dashboard/forgot-password.php">Forgot Password?</a>

                <a class="col-md-6 text-right" href="<?= BASEPAGES ?>dashboard/login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>


  <?php require_once __DIR__ . "../../../includes/core-scripts.php"; ?>
  <?php require_once __DIR__ . "../../../includes/page-level/login-scripts.php"; ?>
  <script src="<?= BASEASSETS ?>js/pages/User/register.js"></script>
</body>

</html>