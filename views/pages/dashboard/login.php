<?php require_once __DIR__."/../../../helper/init.php"; 
$navSection = "log-in";
$page_title ="BLOG | LOG IN"; 

$activeToken = $di->get('user')->getActiveToken();
// Util::dd($activeToken);
if($activeToken != NULL)
{
  $user = $di->get('tokenHandler')->getUserFromValidToken($activeToken[0]['token']);
  $di->get('auth')->setAuthSession($user->id);  
  User::$login = true;
  Util::redirect("posts/blog-home.php");
}



?>
<?php require_once __DIR__."../../../includes/head-section.php";?>
<?php

$page_title ="Blog Managemnet| ADD User";
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
<style>
  div.toast.toast-error{
  right: 0!important;
  }
</style>
  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                  </div>
                  <form class="user" action="<?=BASEASSETS?>../helper/routing.php" id="signin" name="signin" method="POST">

                  <input type="hidden"
                              name="csrf_token"
                              value="<?= Session::getSession('csrf_token');?>">  

                    <div class="form-group">

                    <input type="text" class="form-control form-control-user <?= $errors!= '' ? ($errors->has('username') ? 'error is-invalid' : '') : '';?>"
                     id="username" placeholder="Username / Email "
                     value = "<?= $old != '' ?$old['username']: '';?>"  name="username">
                     <?php
                    if($errors!="" && $errors->has('username')):
                      echo "<span class='error'> {$errors->first('username')}</span>";endif;
                      ?>


                    </div>

                    <div class="form-group">

                    <input type="password" class="form-control form-control-user <?= $errors!= '' ? ($errors->has('password') ? 'error is-invalid' : '') : '';?>"
                     id="password" placeholder="Password"
                      name="password" >
                     <?php
                    if($errors!="" && $errors->has('password')):
                      echo "<span class='error'> {$errors->first('password')}</span>";endif;
                      ?>
                    </div>


                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="is_remember" name="is_remember" checked="on">
                        <label class="custom-control-label" for="is_remember" >Remember Me</label>
                      </div>
                    </div>
                    <input type="submit" class="btn btn-user btn-block btn-primary mb-3" name="signin" value="Sign in" >
                  
                    <p class="text-center small">OR</p>
                    <input type="submit" class="btn btn-user btn-block btn-secondary" name="guest" value="Sign in as Guest" >
                  
                  <br>
                  <div class="row">
                    <a class="small col-md-6" href="<?=BASEPAGES?>/dashboard/forgot-password.php">Forgot Password?</a>
                    <a class="small col-md-6 text-right" href="<?=BASEPAGES?>/dashboard/register.php">Create an Account!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <?php require_once __DIR__."../../../includes/core-scripts.php";?>
  <?php require_once __DIR__."../../../includes/page-level/login-scripts.php";?>


</body>

</html>
