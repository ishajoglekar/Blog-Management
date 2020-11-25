<?php require_once __DIR__ . "/../../../helper/init.php";
$navSection = "home";
$page_title = "BLOG | BLOG HOME";

$activeToken = $di->get('user')->getActiveToken();
if ($activeToken != NULL) {
  $user = $di->get('tokenHandler')->getUserFromValidToken($activeToken[0]['token']);
  $di->get('auth')->setAuthSession($user->id);
}
$categories = $di->get('category')->getCategories(PDO::FETCH_ASSOC);
$favCat = $di->get('category')->getLikedCategories($user->id, PDO::FETCH_ASSOC);
$favCategories = array();
foreach ($favCat as $f) {
  array_push($favCategories, $f['category_name']);
}

// Util::Dd($favCategories);
// Util::dd(User::$login);
?>
<?php require_once __DIR__ . "../../../includes/head-section.php"; ?>

<body>

  <!-- Navigation -->
  <?php require_once __DIR__ . "../../../includes/navbar.php"; ?>


  <!-- Page Content -->
  <div class="container">

    <div class="row">

      <!-- Blog Entries Column -->
      <?php require_once __DIR__ . "../../../includes/liked-blog-entries.php"; ?>


      <!-- Sidebar Widgets Column -->
      <?php require_once __DIR__ . "../../../includes/sidebar-widget.php"; ?>


    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->


  <!-- Footer -->
  <?php require_once __DIR__ . "../../../includes/footer.php"; ?>


  <!-- Bootstrap core JavaScript -->
  <?php require_once __DIR__ . "../../../includes/core-scripts.php"; ?>


</body>

</html>