<?php
require_once __DIR__."/../../../helper/init.php";
$page_title ="BLOG | EDIT BLOG";
    $navSection = "dashboard";
    Util::createCSRFToken();
  $errors="";
  $old="";
 
    $activeToken = $di->get('user')->getActiveToken();
        if($activeToken != NULL)
        {
          $user = $di->get('tokenHandler')->getUserFromValidToken($activeToken[0]['token']);
          //Util::dd($activeToken[0]['token']);
          $di->get('auth')->setAuthSession($user->id);  
    
        }
    else{
      Util::redirect("dashboard/login.php");
    }
  if(Session::hasSession('old'))
  {
    $old = Session::getSession('old');
    Session::unsetSession('old');
  }
  if(Session::hasSession('errors'))
  {
    $errors = unserialize(Session::getSession('errors'));
    Session::unsetSession('errors');
  }
  
  $post_id = $_GET['id'];
  $user = $di->get('auth')->user();
  $userID = $user[0]['id'];
  if($user[0]['authority']){
    $post_details = $di->get('post')->getPostById($post_id,PDO::FETCH_ASSOC);
    $category_name = $di->get('post')->getCategoryByID($post_details[0]['category_id'],PDO::FETCH_ASSOC)[0];
  }
  elseif($di->get('post')->checkEditPost($userID,$post_id))
    {
      $post_details = $di->get('post')->getPostById($post_id,PDO::FETCH_ASSOC);
      $category_name = $di->get('post')->getCategoryByID($post_details[0]['category_id'],PDO::FETCH_ASSOC)[0];
      // Util::dd($category['category_name']);
    
    }

  else{
      Util::redirect("dashboard/404.php");
    }
  

?>

  <?php
    require_once __DIR__."../../../includes/head-section.php";
  ?>
  
  

<style>
.choose-image input{
  background: steelblue;
  border: none;
  color:#fff;
}



.file-field {
    position: relative
}

.file-field .file-path-wrapper {
    overflow: hidden;
    padding-left: 10px
}

.file-field input.file-path {
    width: 100%
}

.file-field .btn,
.file-field .btn-large,
.file-field .btn-small {
    float: left;
    height: 3rem;
    line-height: 3rem
}

.file-field span {
    cursor: pointer
}

.file-field input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    width: 100%;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0)
}

.file-field input[type=file]::-webkit-file-upload-button {
    display: none
}

.file-field .file-path-wrapper {
    overflow: hidden;
    padding-left: 10px
}



</style>
<body id="page-top">
  <style>.m-10{margin:10px 0;}</style>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <?php require_once __DIR__."../../../includes/sidebar.php"; ?>

    <!-- End of Sidebar -->

    <?php require_once __DIR__."../../../includes/navbar.php";?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      <?php require_once __DIR__."../../../includes/topbar-dashboard.php";?>
        <!-- Topbar -->

        <!-- End of Topbar -->

        <!-- Begin Page Content-->
        
        <!-- Page Heading -->
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Edit POST</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-list-ul fa-sm text-white"></i>Manage Customer</a>
            </div>
        </div>
        <!-- /.container-fluid -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card show mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fa fa-plus"></i>Edit Post
                            </h6>
                        </div>
                        <!--END OF CARD HEADER-->

                        <!--CARD BODY-->
                        <div class="card-body">
                        <form id="add-post" action="<?= BASEURL?>helper/routing.php" method="POST" enctype="multipart/form-data" id="edit-post">
                            <input type="hidden"
                              name="csrf_token"
                              
                              value="<?= Session::getSession('csrf_token');?>">

                              <input type="hidden"
                              name="post_id"
                              
                              value="<?= $_GET['id'];?>">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <div class="row">
                                  <div class="col-md-6 m-10">
                                  <label for="name">Post Name</label>
                                  <input type="text" 
                                    class="form-control <?= $errors!= '' ? ($errors->has('name') ? 'error is-invalid' : '') : '';?>"
                                    name="name"
                                    id="name"  
                                    placeholder="Enter Post Name"
                                    value="<?= $old != '' ?$old['name']: $post_details[0]['name'];?>"
                                   ?>

                                  <?php
                                if($errors!="" && $errors->has('name')):
                                  echo "<span class='error'> {$errors->first('name')}</span>";endif;
                                  ?>
                                  </div>
<br>
                                <div class="col-md-6">
                                <div class="form-group">
                                  <label for="name">Category</label>
                                  <select name ="category_id" id="category_id" class="form-control">
                                      <?php
                                      $categories = $di->get('database')->readData('category',['id','category_name']);
                                      // Util::dd($categories)
                                      foreach($categories as $category){
                                          echo "<option value={$category->id}";
                                          if($category_name['category_name']==$category->category_name)
                                          {
                                            // Util::dd("isha");
                                            echo " selected";
                                          }
                                          echo ">{$category->category_name}</option>";
                                      }
                                      ?>
                                      
                                  </select>
                                
                                </div>
                              </div>
<br>
                                
                                <div class="col-md-12 m-10">
                                  <label for="content">Content</label>
                                  <textarea type="text" 
                                    class="form-control <?= $errors!= '' ? ($errors->has('content') ? 'error is-invalid' : '') : '';?>"
                                    name="content"
                                    id="content"  
                                    placeholder="Enter Content"
                                    rows = "10"
                                  ><?= $old != '' ?$old['content']: $post_details[0]['content'];?></textarea>

                                  <?php 
                                    if($errors!="" && $errors->has('content')):
                                        echo "<span class='error'> {$errors->first('content')}</span>";
                                    endif;
                                  ?>
                                </div>
<br>
                <div class="row">
                    <div class="col-md-6">
                        <img class="card-img-top" style="height:24rem;" src="<?=BASEASSETS?>images/posts/<?=$post_details[0]['post_image'];?>" id="temp_pic">
                    </div>
                    
                    <div class="file-field input-field col-md-8">
                       
                    <div class="btn">
                            <span style="margin:-1rem 1rem 1rem; background:white;border:solid 1px #2C53C6;padding:0.5rem;color:#2C53C6;">Image</span>
                            <input type="file" name="post_image" id="post_image" data-error=".pic_error">
                        </div>
                        
                        <div class="file-path-wrapper" style="margin-top:1.3rem;">
                        
                            <input class="file-path" type="text" placeholder="Upload Your Image" style="border:none;border-bottom: solid 1px #2C53C6; color:#2C53C6;" value="<?=$post_details[0]['post_image'];?>">
                        </div>
                        <div class="pic_error "></div>
                    </div>
                </div>

                                 <br><br><br><br>
                                </div>
                                </div>
                              </div>
                            </div>
                            <br>
                            <input type="submit" class="btn btn-primary" name="editPost" value="Submit">
                            
                          </form>
                        </div>
                        <!--END OF CARD BODY-->
                    </div>
                </div>
            </div>
        </div>
      <!-- End of Main Content -->
</div>
      <!-- Footer -->
      <?php require_once __DIR__."../../../includes/footer.php";?>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  
  
  <?php require_once __DIR__."../../../includes/core-scripts.php";?>

  
  <script src="<?=BASEASSETS?>js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="<?=BASEASSETS?>js/pages/Post/edit-post.js"></script>
  <script src="<?=BASEASSETS?>js/materialize.min.js"></script>

  


</body>

</html>
