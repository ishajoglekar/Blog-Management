<?php require_once _DIR_."/../../../helper/init.php";
$navSection = "dashboard";
$page_title ="BLOG | DASHBOARD";

$activeToken = $di->get('user')->getActiveToken();
    if($activeToken != NULL)
    {
      $user = $di->get('tokenHandler')->getUserFromValidToken($activeToken[0]['token']);
      $di->get('auth')->setAuthSession($user->id);
    }
  else{
  Util::redirect("dashboard/login.php");
}

?>
<?php require_once _DIR_."../../../includes/head-section.php";?>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once _DIR_."../../../includes/sidebar.php";?>

    <!-- End of Sidebar -->

    <?php require_once _DIR_."../../../includes/navbar.php";?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once _DIR_."../../../includes/topbar-dashboard.php";?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <?php require_once _DIR_."../../../includes/main-content-dashboard.php";?>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once _DIR_."../../../includes/footer.php";?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <?php require_once _DIR_."../../../includes/logout.php";?>
  <?php require_once _DIR_."../../../includes/core-scripts.php";?>
  <?php require_once _DIR_."../../../includes/page-level/index-scripts.php";?>


</body>

</html>