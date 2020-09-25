<?php 
$post = $di->get('post')->getPostByID($_GET['id'],PDO::FETCH_ASSOC);
//Util::dd($post);
$category_name = $di->get('post')->getCategoryByID($post[0]['category_id'],PDO::FETCH_ASSOC);
// Util::dd($post);
?>
<div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4"><?=$post[0]['name'];?> | <?=$category_name[0]['category_name']?> </h1>

        <!-- Author -->
        <p class="lead">
          by
          <a href=""><?= $post[0]['author'];?></a>
        </p>

        <hr>

        <!-- Date/Time -->
        <p>Posted on <?=$post[0]['created_at'];?></p>

        <hr>

        <!-- Preview Image -->
        <img class="card-img-top img-fluid rounded" style="height:24rem;" src="<?=BASEASSETS?>images/posts/<?=$post[0]['post_image']?>" alt="">
        <hr>

      <div><?=$post[0]['content']?></div>
      
        <hr>

        <!-- Comments Form -->
        

        <!-- Single Comment -->
        
        <!-- Comment with nested comments -->
        

      </div>