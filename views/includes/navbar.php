<style>.bg-blue {
  background-color: #4E73DF;
 
}.logo i{
color :#fff;
margin-left:-25px;
font-size: 1.2rem;
} 
.white{
color:#fff;
}
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-blue fixed-top">
    <div class="container-fluid">

      <!-- Sidebar - Brand -->
      
        <div class="logo  rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="white mx-2">Pen it!</div>
      

    <hr class="sidebar-divider my-0">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item <?= $navSection=='home' ? 'active' : '';?>">
            <a class="nav-link" href="<?=BASEPAGES?>posts/blog-home.php">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>

      
          
          
          <?php if($di->get('auth')->check()):?>

            <li class="nav-item <?= $navSection=='likedposts' ? 'active' : '';?>">
            <a class="nav-link" href="<?=BASEPAGES?>posts/blog-home.php">Liked Posts
              <span class="sr-only">(current)</span>
            </a>
          </li>
        
          <li class="nav-item <?= $navSection=='dashboard' ? 'active' : '';?>">
            <a class="nav-link" href="<?=BASEPAGES?>dashboard/index.php">Dashboard
              <span class="sr-only">(current)</span>
            </a>
          </li>         
          <li class="nav-item">
            <form action="<?=BASEASSETS?>../helper/routing.php" method="POST">
            <input type="submit" class="nav-link logout" name="loggedout" style="background:transparent;border:none;" value = "Log out">
          </form>
            
          </li>
         <?php endif;?>
         <?php if(!$di->get('auth')->check()):?>
            
            <li class="nav-item ">
              <a class="nav-link" href="<?=BASEPAGES?>dashboard/login.php">Log In</a>
            </li>
            <?php endif;?>

          

        </ul>
      </div>
    </div>
</nav>