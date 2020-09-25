<?php require_once __DIR__."/../../../helper/init.php"; 

$page_title ="BLOG | ADD POST";
$navSection = "dashboard";
    $sidebarSection = 'post';
    $sidebarSubSection = 'add';
    

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
    Util::createCSRFToken();
  $errors="";
  $old="";
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


?>

  <?php require_once __DIR__."../../../includes/head-section.php";?>
  
<body id="page-top">
  <style>.m-10{margin:10px 0;}
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
  <!-- Page Wrapper -->
  <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once __DIR__."../../../includes/sidebar.php";?>
       
        <!-- End of Sidebar -->

        <?php require_once __DIR__."../../../includes/navbar.php";?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

          <!-- Topbar -->
            <?php require_once __DIR__."../../../includes/topbar-dashboard.php";?>
        <!-- End of Topbar -->

        <!-- Begin Page Content-->
        
        <!-- Page Heading -->
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Add Post</h1>
            </div>
        </div>
        <!-- /.container-fluid -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card show mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fa fa-plus"></i>Add Post
                            </h6>
                        </div>
                        <!--END OF CARD HEADER-->

                        <!--CARD BODY-->
                        <div class="card-body">
                          <form id="add-post" action="<?= BASEURL?>helper/routing.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden"
                              name="csrf_token"
                              value="<?= Session::getSession('csrf_token');?>">
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
                                    value="<?= $old != '' ?$old['name']: '';?>"
                                  >

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
                                      foreach($categories as $category){
                                          echo "<option value={$category->id}>{$category->category_name}</option>";
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
                                  ><?= $old != '' ?$old['content']: '';?></textarea>

                                  <?php 
                                    if($errors!="" && $errors->has('content')):
                                        echo "<span class='error'> {$errors->first('content')}</span>";
                                    endif;
                                  ?>
                                </div>
<br>
<div class="row">
                 
                    
                    <div class="file-field input-field col-md-12">
                       
                    <div class="btn">
                            <span style="margin-left:-0.1rem; background:white;border:solid 1px #2C53C6;padding:0.5rem;color:#2C53C6;">Image</span>
                            <input type="file" name="post_image" id="post_image" data-error=".pic_error">
                        </div>
                        
                        <div class="file-path-wrapper" style="margin-top:1.3rem;">
                        
                            <input class="file-path" type="text" placeholder="Upload Your Image" style="border:none;border-bottom: solid 1px #2C53C6; color:#2C53C6;">
                        </div>
                        <div class="pic_error "></div>
                    </div>
                </div>


                                 <br><br>
                                </div>
                                </div>
                              </div>
                            </div>
                            
                            <input type="submit" style="margin: 1rem 0;" class="btn btn-primary" name="add_post" value="Submit">
                            
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
                                  
   <script src="<?=BASEASSETS?>js/pages/Post/add-post.js"></script>
   <script src ="<?=BASEASSETS?>js/plugins/toastr/toastr.min.js"></script>
   
    <script src="<?=BASEASSETS?>vendor/datatables/datatables.min.js"></script>

    
  
  <script src="<?=BASEASSETS?>js/materialize.min.js"></script>


</body>

</html>
