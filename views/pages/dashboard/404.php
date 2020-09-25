<?php require_once __DIR__."/../../../helper/init.php"; 
$page_title ="BLOG | ERROR";?>
<?php require_once __DIR__."../../../includes/head-section.php";?>

<body id="page-top">
<style>
.error{
  color: #5a5c69;
    font-size: 7rem;
    position: relative;
    line-height: 1;
    width: 12.5rem;
}
</style>
  <!-- Page Wrapper -->
  <div id="wrapper">

    
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php require_once __DIR__."../../../includes/navbar.php";?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- 404 Error Text -->
          <div class="text-center">
            <div class="error mx-auto" data-text="404">404</div>
            <p class="lead text-gray-800 mb-5">Page Not Found</p>
            <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
            <a href="index.html">&larr; Back to Dashboard</a>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
    
    </div>
    <!-- End of Content Wrapper -->
   
  </div>
  <!-- End of Page Wrapper -->
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


  <?php require_once __DIR__."../../../includes/core-scripts.php";?>
</body>

</html>
