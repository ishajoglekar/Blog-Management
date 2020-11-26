<?php require_once __DIR__ . "/../../../helper/init.php";
$navSection = "liked-posts";
$page_title = "BLOG | BLOG HOME";
$activeToken = $di->get('user')->getActiveToken();
$user = $di->get('auth')->user();
// Util::Dd($user[0]['id']);
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
  <div class="container-fluid">

    <div class="row">

      <!-- Blog Entries Column -->
      <?php require_once __DIR__ . "../../../includes/liked-blog-entries.php"; ?>


    


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