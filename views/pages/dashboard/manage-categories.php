<?php require_once __DIR__."/../../../helper/init.php";
$page_title ="BLOG | MANAGE CATEGORIES";
$user = $di->get('auth')->user();
if(!$user[0]['authority'])
{ Util::redirect("dashboard/404.php");
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
?>
<?php require_once __DIR__."../../../includes/head-section.php";
$navSection = "dashboard";
$sidebarSection = "category";
$sidebarSubSection = "manage";
?>
  



<body id="page-top">

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


        <!-- Begin Page Content -->
        <!-- Page Heading -->
        <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Manage Categories</h1>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary ">Categories</h6>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-responsive" id="manage-categories">   
                        <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Actions</th>                                  
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
         
      </div>
      <!-- End of Main Content -->


            <!-- Modal -->

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header ">
              <h5 class="modal-title" id="deleteModalLabel">DELETE CATEGORY</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="<?= BASEURL;?>helper/routing.php" method="POST">
              <div class="modal-body">
                <input type="hidden" name="csrf_token" id="csrf_token" value="<?= Session::getSession('csrf_token');?>">

                <input type="hidden" name="id" id="delete_category_id" value="">
              <p class="text-muted">Are you sure you want to delete?</p>
              </div>
           
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger" name="deleteCategory">Delete changes</button>
            </div>
            </form>
          </div>
        </div>
      </div>

<!-- End of delete modal -->
<!-- Footer -->
<?php require_once __DIR__."../../../includes/footer.php";?>
<!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->


<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  
  <?php require_once __DIR__."../../../includes/core-scripts.php";?>
  <?php require_once __DIR__."../../../includes/page-level/manage-categories-scripts.php";?>

  <script src="<?=BASEASSETS?>js/pages/Category/manage-categories.js"></script>
  
</body>

</html>
