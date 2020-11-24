<?php 
$post = $di->get('post')->getPostByID((int)$_GET['id'],PDO::FETCH_ASSOC);
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

      <div class="row">
          <div class="blog-post-comment-container" style="width:100%">

            <div id="disqus_thread"></div>
            <script>
              /**
               *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
               *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

              var disqus_config = function() {

                this.page.url = "http://localhost:9999/views/pages/posts/blog-post.php?id=<?=(int)$_GET['id'] ?>"// Replace PAGE_URL with your page's canonical URL variable
                // console.log("http://localhost:9999/views/pages/posts/blog-post.php?id=".<?=(int)$_GET['id'] ?>);
                this.page.identifier = "<?=(int)$_GET['id'] ?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
              };

              (function() { // DON'T EDIT BELOW THIS LINE
                var d = document,
                  s = d.createElement('script');
                s.src = 'https://blog-zm6xq5a8pr.disqus.com/embed.js';
                s.setAttribute('data-timestamp', +new Date());
                (d.head || d.body).appendChild(s);
              })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>


          </div>
          <div id="disqus_thread"></div>
          <script>
            /**
             *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
             *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables*/

            var disqus_config = function() {
              this.page.url = "http://localhost:9999/views/pages/posts/blog-post.php?id=<?= (int)(int)$_GET['id'] ?>" // Replace PAGE_URL with your page's canonical URL variable
              this.page.identifier = "<?=(int)$_GET['id'] ?>"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
            };
            (function() { // DON'T EDIT BELOW THIS LINE
              var d = document,
                s = d.createElement('script');
              s.src = 'https://pen-it-3.disqus.com/embed.js';
              s.setAttribute('data-timestamp', +new Date());
              (d.head || d.body).appendChild(s);
            })();
          </script>
          <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

        </div>
      
      
        <hr>

        <!-- Comments Form -->
        

        <!-- Single Comment -->
        
        <!-- Comment with nested comments -->
        

      </div>