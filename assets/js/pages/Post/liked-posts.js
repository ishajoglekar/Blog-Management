$("#like").click(function(){
    $.ajax({url: "http://localhost:9999/views/pages/posts/blog-home.php", success: function(result){
      var ele = document.getElementById('like').classList.toggle('red');
    }});
});