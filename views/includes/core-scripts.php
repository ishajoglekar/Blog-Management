<?php
  function likeunlike(){
    Util::dd("hii");
  }
?>
<script src="<?=BASEASSETS?>vendor/jquery/jquery.min.js"></script>  
  <script src="<?=BASEASSETS?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
 

  <!-- Core plugin JavaScript-->
  <script src="<?=BASEASSETS?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="<?=BASEASSETS?>js/pages/Post/liked-posts.js"></script>

  <!-- Custom scripts for all pages-->

  <script src="<?=BASEASSETS?>js/sb-admin-2.min.js"></script>

  <script>

  $("#like").click(function(){
      $.ajax({
          
          url: "http://localhost:9999/views/pages/posts/blog-home.php", 
          success: function(result){
              var ele = document.getElementById('like').classList.toggle('red');
              var pid = $('#p_id').value;
              var uid = $('#u_id').value;
              <?php likeunlike();?>
          }
      });
  });
  </script>

  
