<?php
error_reporting(E_ERROR | E_PARSE);
 
// Util::dd($posts);
if ($di->get('auth')->check()) {
  $user = $di->get('auth')->user();
  $userID = (int)$user[0]['id'];
}

$posts = $di->get('post')->getLikedPosts($userID,PDO::FETCH_ASSOC);
$totalPosts = count($posts);

?>
<div class="col-md-1"></div>
<div class="col-md-7">
  <style>
    .waves-effect {
      position: relative;
      cursor: pointer;
      display: inline-block;
      overflow: hidden;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      -webkit-tap-highlight-color: transparent;
      vertical-align: middle;
      z-index: 1;
      -webkit-transition: .3s ease-out;
      transition: .3s ease-out
    }

    .pagination li.disabled a {
      cursor: default;
      color: #999
    }

    .pagination li.disabledp a {
      cursor: default;
      color: black
    }

    .red {
      color: red !important;
    }
  </style>

  <h1 class="my-4" style="color:steelblue;">THE BEST...IS NEXT
  </h1>
  <?php
  //HANDLING PAGINATION
  $page = 1;
  if (isset($_GET['page'])) {
    $page = $_GET['page'];
  }
  $no_of_records_per_page = 3;
  $start = ($page - 1) * $no_of_records_per_page;


  if (!$totalPosts) {
    Util::redirect("dashboard/404.php");
  }

  $total_pages = ceil($totalPosts / $no_of_records_per_page);

  if ($page > $total_pages) {
    //LOAD 404 page
    Util::redirect("dashboard/404.php");
  }

  $totalPosts = ($di->get('post')->getPostsByLimit($start, $no_of_records_per_page, PDO::FETCH_ASSOC));
  // Util::dd($totalPosts);
  //$totalFinalPosts = count($totalPosts);
  if (!$totalPosts) {
    Util::redirect("dashboard/404.php");
  }

  foreach ($posts as $post) :
    // Util::Dd(in_array(85,$likedPostsArr));
  ?>
    <!-- Blog Post -->
    <div class="card mb-4">
      <img class="card-img-top" src="<?= BASEASSETS ?>images/posts/<?= $post['post_image'] ?>" alt="Card image cap">
      <div class="card-body">
        <h2 class="card-title" style="color:#000;"><?= $post['name']; ?> | <?= $post['category_name'] ?></h2>
        <div class="card-text" style="font-size: 1.2rem;color:#666;"><?= substr($post['content'], 0, 100) . "  ..." ?></div>
        <a href="<?= BASEPAGES ?>posts/blog-post.php?id=<?= $post['id'] ?>" class="btn btn-primary">Read More &rarr;</a>
        <?php
        if ($di->get('auth')->check()) :
          $postID = (int)$post['id'];
          $query = "SELECT COUNT(*) as count from users_posts where users_posts.user_id  = {$userID} and users_posts.post_id = {$postID}";
          //Util::dd($userID." ".$postID);
          $result = $di->get('database')->raw($query, PDO::FETCH_ASSOC);
          //print_r($result[0]['count']);
          if ($result[0]['count'] > 0) :
        ?>
            <a href="<?= BASEPAGES ?>dashboard/edit-post.php?id=<?= $post['id'] ?>" class="btn btn-secondary">EDIT POST &rarr;</a>
        <?php endif;
        endif; ?>
      </div>
      <div class="card-footer text-muted">
        <input type="hidden" name="p_id" id="p_id" value=<?= (int)$post['id'] ?>>
        <input type="hidden" name="u_id" name="u_id" value=<?= $userID ?>>
        <i class="<?php if (in_array((int)$post['id'], $likedPostsArr)) {
                    echo ('red');
                  } else {
                    echo ('');
                  } ?> fa fa-heart" style="font-size:1.3rem;margin-right:1rem" id="like"></i>
        Posted on <?= $post['created_at'] ?> by
        <a href=""><?= $post['author']; ?></a>
       
      </div>
    </div>
  <?php endforeach; ?>

  <!-- Pagination -->
  <ul class="pagination justify-content-center mb-4">
    <li class="<?= $page == 1 ? 'disabled' : 'waves-effect'; ?>">
      <a href="<?= $page > 1 ? '?page=' . ($page - 1) : '/'; ?>">
        <i class="fas fa-fw fa-2x fa-chevron-left"></i>
      </a>
    </li>

    <?php
    for ($i = 1; $i <= $total_pages; $i++) :
    ?>

      <!-- <li class="active"><a href="#!">1</a></li> -->


      <li style="margin:2px 10px;" class="waves-effect <?= $page == $i ? 'active' : 'disabledp'; ?>">
        <a href="?page=<?= $i; ?>"> <?= $i; ?> </a>
      </li>
    <?php
    endfor;
    ?>

    <li class="<?= $page == $total_pages ? 'disabled' : 'waves-effect'; ?>">
      <a href="<?= $page < $total_pages ? '?page=' . ($page + 1) : '#'; ?>"><i class="fas fa-fw fa-2x  fa-chevron-right"></i></a></li>
  </ul>




</div>

<div class="col-md-3 mt-5 p2 border">
    <h5 class="my-4 text-center text-primary">All Bloggers</h5>
    <p class="my-4 text-center text-success">Get in touch with your fellow bloggers!</p>

    <?php
      $users = $di->get('user')->getUsers(PDO::FETCH_ASSOC);
      // Util::Dd($users);
    ?>
    <ul class="p-0">
      <?php
        foreach($users as $user){
      ?>

          <li style="margin:1rem"><a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?=$user['email']?>" target="_blank"><?=$user['username']?></a></li>
          <div class="border"></div>
      <?php
        }
      ?>
    </ul>
</div>

<div class="col-md-1"></div>