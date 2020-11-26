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
  <div class="container-fluid">

    <div class="row">

      <!-- Blog Entries Column -->
      <?php require_once __DIR__ . "../../../includes/blog-entries.php"; ?>


      <!-- Sidebar Widgets Column -->
      


    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->


  <!-- Button trigger modal -->
  <button type="button" id="btn" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" style="opacity: 0;z-index:-999">
    Launch demo modal
  </button>

  <!-- Modal -->
  <form action="<?= BASEURL ?>helper/routing.php" method="POST">
  
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Check your Interests:</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="form-group">
            <input type="hidden"
                              name="csrf_token"
                              value="<?= Session::getSession('csrf_token');?>">
              <?php
              foreach ($categories as $c) {
              ?>


                <input type="checkbox" <?php if (in_array($c['category_name'], $favCategories) == 1) {
                                          echo ('checked');
                                        } else {
                                          echo ('');
                                        } ?> name="<?= $c['category_name'] ?>">
                <?= $c['category_name']; ?><br>
              <?php
              }
              ?>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
            <input type="submit" class="btn btn-primary" name="favs" value="Save changes">
          </div>
        </div>
      </div>
    </div>
  </form>

  <script>
    window.onload = function() {
      document.getElementById('btn').click();
      
    }

    $('#close').click(function(){
      $('#exampleModalCenter').fadeOut(); 
    })
  </script>

  <!-- Footer -->
  <?php require_once __DIR__ . "../../../includes/footer.php"; ?>


  <!-- Bootstrap core JavaScript -->
  <?php require_once __DIR__ . "../../../includes/core-scripts.php"; ?>


</body>

</html>