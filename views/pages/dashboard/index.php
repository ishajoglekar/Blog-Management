<?php require_once __DIR__ . "/../../../helper/init.php";
$navSection = "dashboard";
$page_title = "BLOG | DASHBOARD";

$activeToken = $di->get('user')->getActiveToken();
if ($activeToken != NULL) {
  $user = $di->get('tokenHandler')->getUserFromValidToken($activeToken[0]['token']);
  $di->get('auth')->setAuthSession($user->id);
} else {
  Util::redirect("dashboard/login.php");
}


?>
<?php require_once __DIR__ . "../../../includes/head-section.php"; ?>

<body id="page-top">

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

        <!-- Begin Page Content -->
        <?php require_once __DIR__ . "../../../includes/main-content-dashboard.php"; ?>
        <!-- /.container-fluid -->
        <div class="m-5 card p-3">
          <h3>Hey <?= $_COOKIE['user'] ?>! Welcome Back!</h3>
          <?php
          if (!isset($_COOKIE['user'])) {
            echo "Cookie named '" . $_COOKIE['user'] . "' is not set!";
          } else {
            echo "Cookie '" . $_COOKIE['user'] . "' is set!<br>";
            echo "Value is: " . $_COOKIE['user'];
          }
          ?>

          <form action="<?= BASEURL ?>helper/routing.php" method="POST">
            <br>
            <input type="submit" value="Delete and Signout" name="delete" class="btn btn-primary">
          </form>
          <form action=<?= $_SERVER['PHP_SELF'] ?> method="POST">
            <br>
            <input type="submit" value="Display Cookies Status" name="enable" class="btn btn-secondary">
          </form>
          <?php

          if (isset($_POST['enable'])) {

            if (count($_COOKIE) > 0) {
              echo "Cookies are enabled.";
            } else {
              echo "Cookies are disabled.";
            }
          }

          ?>


          <form action=<?= $_SERVER['PHP_SELF'] ?> method="POST">
            <br>
            <input type="submit" value="Display Session Variables" name="session" class="btn btn-warning">
          </form>


          <?php


          if (isset($_POST['session'])) {

            echo "session variable 1 (username) " . $_SESSION["name"] . ".<br>";
            echo "session variable 2 (remember me) " . $_SESSION["is_remember"] . ".";

          ?>

            <form action=<?= $_SERVER['PHP_SELF'] ?> method="POST">
              <br>
              <input type="submit" value="Destroy Session" name="des_session" class="btn btn-secondary">
            </form>

          <?php
          }

          if (isset($_POST['des_session'])) {
            session_unset();

            // destroy the session

            session_destroy();
            echo "session is destroyed";
            echo "session variable 1 " . $_SESSION["name"] . ".<br>";
            echo "session variable 2 " . $_SESSION["is_remember"] . ".";
          }
          ?>

        </div>
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <?php require_once __DIR__ . "../../../includes/footer.php"; ?>
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
  <?php require_once __DIR__ . "../../../includes/logout.php"; ?>
  <?php require_once __DIR__ . "../../../includes/core-scripts.php"; ?>
  <?php require_once __DIR__ . "../../../includes/page-level/index-scripts.php"; ?>


</body>

</html>