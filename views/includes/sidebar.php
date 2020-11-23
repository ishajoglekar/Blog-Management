<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<li class="nav-item <?= $sidebarSection=='category' ? 'active' : '';?>">

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?= $navSection=='dashboard' ? 'active' : '';?>">
        <a class="nav-link" href="<?=BASEPAGES?>dashboard/index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Creations
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      
      <!-- Nav Item - Utilities Collapse Menu -->
      <?php

        $check = $di->get('auth')->user();
        $authority = (int)$check[0]['authority'];

        if($authority):


      ?>

  <li class="nav-item <?=$sidebarSection=='user' ? 'active' : '';?>">
                <a class="nav-link " href="#" 
                data-toggle="collapse" 
                data-target="#collapseUser" 
                aria-expanded="true" 
                aria-controls="collapseUser">
                  <i class="fas fa-fw fa-users"></i>
                  <span>Users</span>
                </a>
          
                <div id="collapseUser" 
                class="collapse  <?= $sidebarSection=='user' ? 'show' : '';?>" 
                aria-labelledby="headingTwo" 
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= $sidebarSubSection=='add' && $sidebarSection=='user' ? 'active' : '';?>" 
                        href="<?= BASEPAGES;?>dashboard/add-user.php">Add User</a>
                    <a class="collapse-item <?= $sidebarSubSection=='manage' && $sidebarSection=='user' ? 'active' : '';?>" 
                        href="<?= BASEPAGES;?>dashboard/manage-users.php">Manage Users</a>
                  </div>
                </div>
        </li>


        <li class="nav-item <?=$sidebarSection=='category' ? 'active' : '';?>">
                <a class="nav-link " href="#" 
                data-toggle="collapse" 
                data-target="#collapseCategory" 
                aria-expanded="true" 
                aria-controls="collapseCategory">
                  <i class="fas fa-fw fa-user"></i>
                  <span>Categories</span>
                </a>
          
                <div id="collapseCategory" 
                class="collapse  <?= $sidebarSection=='category' ? 'show' : '';?>" 
                aria-labelledby="headingTwo" 
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item <?= $sidebarSubSection=='add' && $sidebarSection=='category' ? 'active' : '';?>" 
                        href="<?= BASEPAGES;?>dashboard/add-category.php">Add Category</a>
                    <a class="collapse-item <?= $sidebarSubSection=='manage' && $sidebarSection=='category' ? 'active' : '';?>" 
                        href="<?= BASEPAGES;?>dashboard/manage-categories.php">Manage Categories</a>
                  </div>
                </div>
        </li>

      <!-- <li class="nav-item <?= $sidebarSection=='manage-users' ? 'active' : '';?>">
          <a class="nav-link" href="<?= BASEPAGES;?>dashboard/manage-users.php">
              <i class="fas fa-fw fa-users"></i>
              
              <span>Users</span></a>
      </li> -->
        <?php endif; 

        if($authority): 
          ?>
      <li class="nav-item <?= $sidebarSection=='view-post' ? 'active' : '';?>">
          <a class="nav-link" href="<?= BASEPAGES;?>dashboard/manage-all-posts.php">
              <i class="fas fa-fw fa-sticky-note"></i>
              <span>Posts</span></a>
      </li>
      <?php

        else : 

      ?>

      <li class="nav-item <?= $sidebarSection=='view-post' ? 'active' : '';?>">
          <a class="nav-link" href="<?= BASEPAGES;?>dashboard/view-all-posts.php">
              <i class="fas fa-fw fa-sticky-note"></i>
              <span>Posts</span></a>
      </li>

        <?php endif; ?>
      <li class="nav-item <?=$sidebarSection=='post' ? 'active' : '';?>">
              <a class="nav-link " href="#" 
              data-toggle="collapse" 
              data-target="#collapsePost" 
              aria-expanded="true" 
              aria-controls="collapsePost">
                <i class="fas fa-fw fa-pen"></i>
                <span>My Posts</span>
              </a>
         
              <div id="collapsePost" 
              class="collapse  <?= $sidebarSection=='post' ? 'show' : '';?>" 
              aria-labelledby="headingTwo" 
              data-parent="#accordionSidebar">
              <div class="bg-white py-2 collapse-inner rounded">
                  <a class="collapse-item <?= $sidebarSubSection=='add' && $sidebarSection=='post' ? 'active' : '';?>" 
                      href="<?= BASEPAGES;?>dashboard/add-post.php">Add Post</a>
                  <a class="collapse-item <?= $sidebarSubSection=='manage' && $sidebarSection=='post' ? 'active' : '';?>" 
                      href="<?= BASEPAGES;?>dashboard/manage-post.php">Manage Post</a>
                </div>
              </div>
      </li>

            
    
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>

        
