<?php require_once __DIR__ . "/../../../helper/init.php";

$page_title = "BLOG | EDIT USER";
$navSection = "dashboard";
$sidebarSection = 'user';
$sidebarSubSection = 'edit';


$activeToken = $di->get('user')->getActiveToken();
if ($activeToken != NULL) {
  $user = $di->get('tokenHandler')->getUserFromValidToken($activeToken[0]['token']);
  //Util::dd($activeToken[0]['token']);
  $di->get('auth')->setAuthSession($user->id);
} else {
  Util::redirect("dashboard/login.php");
}
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

$category_id = $_GET['id'];

$user_details = $di->get('category')->getCategoryByID($category_id,PDO::FETCH_ASSOC);
?>

<?php require_once __DIR__ . "../../../includes/head-section.php"; ?>

<body id="page-top">
  <style>
    .m-10 {
      margin: 10px 0;
    }
  </style>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once __DIR__ . "../../../includes/sidebar.php"; ?>

    <!-- End of Sidebar -->

    <?php require_once __DIR__ . "../../../includes/navbar.php"; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once __DIR__ . "../../../includes/topbar-dashboard.php"; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content-->

        <!-- Page Heading -->
        <div class="container-fluid">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
          </div>
        </div>
        <!-- /.container-fluid -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card show mb-4">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fa fa-plus"></i>Edit Category
                  </h6>
                </div>
                <!--END OF CARD HEADER-->

                <!--CARD BODY-->
                <div class="card-body">
                  <form id="edit-category" action="<?= BASEURL ?>helper/routing.php" method="POST">
                    <input type="hidden" name="edit_category_id" value="<?= $_GET['id']; ?>">
                    <input type="hidden" name="csrf_token" value="<?= Session::getSession('csrf_token'); ?>">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <div class="row">
                            <div class="col-md-6 m-10">
                              <label for="name">Catgeory Name</label>
            
                              
                              <input type="text" class="form-control <?= $errors != '' ? ($errors->has('category_name') ? 'error is-invalid' : '') : ''; ?>" name="category_name" id="category_name" placeholder="Enter First Name" value="<?= $old != '' ? $old['category_name'] : $user_details[0]['category_name']; ?>">
                              <?php
                              if ($errors != "" && $errors->has('category_name')) :
                                echo "<span class='error'> {$errors->first('category_name')}</span>";
                              endif;
                              ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <input type="submit" class="btn btn-primary" name="editCategory" value="Submit">

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
      <?php require_once __DIR__ . "../../../includes/footer.php"; ?>
      <!-- End of Footer -->


    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->


  <?php require_once __DIR__ . "../../../includes/core-scripts.php"; ?>
  <script src="<?= BASEASSETS ?>js/plugins/jquery-validation/jquery.validate.min.js"></script>

  <script src="<?= BASEASSETS ?>js/pages/Post/add-post.js"></script>
  <script src="<?= BASEASSETS ?>js/plugins/toastr/toastr.min.js"></script>
  <script src="<?= BASEASSETS ?>vendor/datatables/datatables.min.js"></script>




</body>

</html>