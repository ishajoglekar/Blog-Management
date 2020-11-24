<?php require_once __DIR__."/../../../helper/init.php"; 

$page_title ="BLOG | ADD POST";
$navSection = "dashboard";
    $sidebarSection = 'user';
    $sidebarSubSection = 'add';
$user = $di->get('auth')->user();
if(!$user[0]['authority'])
{   Util::redirect("dashboard/404.php");
}    

  $activeToken = $di->get('user')->getActiveToken();
      if($activeToken != NULL)
      {
        $user = $di->get('tokenHandler')->getUserFromValidToken($activeToken[0]['token']);
        //Util::dd($activeToken[0]['token']);
        $di->get('auth')->setAuthSession($user->id);  
  
      }
  else{
    Util::redirect("dashboard/login.php");
  }
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


?>

  <?php require_once __DIR__."../../../includes/head-section.php";?>
  
<body id="page-top">
  <style>.m-10{margin:10px 0;}</style>
  <!-- Page Wrapper -->
  <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once __DIR__."../../../includes/sidebar.php";?>
       
        <!-- End of Sidebar -->

        <?php require_once __DIR__."../../../includes/navbar.php";?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

          <!-- Topbar -->
            <?php require_once __DIR__."../../../includes/topbar-dashboard.php";?>
        <!-- End of Topbar -->

        <!-- Begin Page Content-->
        
        <!-- Page Heading -->
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Add User</h1>
            </div>
        </div>
        <!-- /.container-fluid -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card show mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fa fa-plus"></i>Add User
                            </h6>
                        </div>
                        <!--END OF CARD HEADER-->

                        <!--CARD BODY-->
                        <div class="card-body">
                          <form id="add-user" action="<?= BASEURL?>helper/routing.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden"
                              name="csrf_token"
                              value="<?= Session::getSession('csrf_token');?>">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <div class="row">
                                  <div class="col-md-6 m-10">
                                  <label for="name">First Name</label>
                                  <input type="text" 
                                    class="form-control <?= $errors!= '' ? ($errors->has('first_name') ? 'error is-invalid' : '') : '';?>"
                                    name="first_name"
                                    id="first_name"  
                                    placeholder="Enter First Name"
                                    value="<?= $old != '' ?$old['first_name']: '';?>"
                                  >

                                  <?php
                                if($errors!="" && $errors->has('first_name')):
                                  echo "<span class='error'> {$errors->first('first_name')}</span>";endif;
                                  ?>
                                  </div>
<br>

<div class="col-md-6 m-10">
                                  <label for="name">Last Name</label>
                                  <input type="text" 
                                    class="form-control <?= $errors!= '' ? ($errors->has('last_name') ? 'error is-invalid' : '') : '';?>"
                                    name="last_name"
                                    id="last_name"  
                                    placeholder="Enter last Name"
                                    value="<?= $old != '' ?$old['last_name']: '';?>"
                                  >

                                  <?php
                                if($errors!="" && $errors->has('last_name')):
                                  echo "<span class='error'> {$errors->last('last_name')}</span>";endif;
                                  ?>
                                  </div>

                                  <br>
                                  <div class="col-md-6 m-10">
                                  <label for="name">Password</label>
                                  <input type="text" 
                                    class="form-control <?= $errors!= '' ? ($errors->has('password') ? 'error is-invalid' : '') : '';?>"
                                    name="password"
                                    id="password"  
                                    placeholder="Enter password"
                                    value="<?= $old != '' ?$old['password']: '';?>"
                                  >

                                  <?php
                                if($errors!="" && $errors->has('password')):
                                  echo "<span class='error'> {$errors->first('password')}</span>";endif;
                                  ?>
                                  </div>

                                  <br>
                                  <div class="col-md-6 m-10">
                                  <label for="name">Email ID</label>
                                  <input type="text" 
                                    class="form-control <?= $errors!= '' ? ($errors->has('email') ? 'error is-invalid' : '') : '';?>"
                                    name="email"
                                    id="email"  
                                    placeholder="Enter Email ID"
                                    value="<?= $old != '' ?$old['email']: '';?>"
                                  >

                                  <?php
                                if($errors!="" && $errors->has('email')):
                                  echo "<span class='error'> {$errors->first('email')}</span>";endif;
                                  ?>
                                  </div>

                                  <br>

                                  <div class="col-md-6 m-10">
                                  <label for="name">Username</label>
                                  <input type="text" 
                                    class="form-control <?= $errors!= '' ? ($errors->has('username') ? 'error is-invalid' : '') : '';?>"
                                    name="username"
                                    id="username"  
                                    placeholder="Enter username ID"
                                    value="<?= $old != '' ?$old['username']: '';?>"
                                  >

                                  <?php
                                if($errors!="" && $errors->has('username')):
                                  echo "<span class='error'> {$errors->first('username')}</span>";endif;
                                  ?>
                                  </div>

                                  <br>


                                  <div class="col-md-6 m-10">
                                
                                  <label for="name">Authority</label>
                                  <select name="authority" id="authority" class="form-control">
                                   <option value="0">User</option>
                                   <option value="1">Admin</option>
                                  </select>
                                  <?php
                                  if($errors!="" && $errors->has('authority')):
                                    echo "<span class='error'>{$errors->first('authority')}</span>";
                                  endif;
                                  ?>
                                                           
                            </div>

                                  <br>
                                  </div>
                                
                               
                                </div>
                                </div>
                              </div>
                            </div>
                    </div>
                            <input type="submit" class="btn btn-primary" name="add_user_by_admin" value="Submit">
                            
                          </form>
                        </div>
                        <!--END OF CARD BODY-->
                    </div>
                </div>
            </div>
        </div>
      <!-- End of Main Content -->
</div>
  
  <!-- Footer -->
<?php require_once __DIR__."../../../includes/footer.php";?>
<!-- End of Footer -->
      

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  

  <?php require_once __DIR__."../../../includes/core-scripts.php";?>
   <script src="<?=BASEASSETS?>js/plugins/jquery-validation/jquery.validate.min.js"></script>
                                  
   <script src="<?=BASEASSETS?>js/pages/Post/add-post.js"></script>
   <script src ="<?=BASEASSETS?>js/plugins/toastr/toastr.min.js"></script>
    <script src="<?=BASEASSETS?>vendor/datatables/datatables.min.js"></script>

  


</body>

</html>
