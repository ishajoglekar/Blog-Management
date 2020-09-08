// $(window).(function() {
  
//   //use ajax to call another page to session_destroy();
//   $.ajax({
//       url: window.location.origin+"/helper/routing.php",
//       type:"POST",
//     data:{
//         "page": "session-delete"
//     },
//     success:function(data){
//         console.log(data);
//     },
//     error:function(errorThrown){
//         console.log(errorThrown);
//     }
//     });
    
// });
//object.addEventListener("beforeunload", myScript);

window.addEventListener("beforeunload", function (e) {
  //alert("really");
  //var confirmationMessage = "sure";
  //(e || window.event).returnValue = confirmationMessage;
  $.ajax({
          url: window.location.origin+"/helper/routing.php",
          type:"POST",
        data:{
            "page": "session-delete"
        },
        success:function(data){
            console.log(data);
        },
        error:function(errorThrown){
            console.log(errorThrown);
        }
    });
   //Gecko + IE
  //return confirmationMessage;                            //Webkit, Safari, Chrome
});

