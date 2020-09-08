$(function(){
    $('#edit-post').validate({
        rules:{
            'name':{
                required:true,
                minlength : 3,
                maxlength : 80,
            },
            'content':{
                required:true,
                minlength : 10
            },
            'post_image':{
                required:true
            },
            'category_id':{
                required:true
            }
        },
        
        submitHandler: function(form){
            form.submit();
        }
    })
});

$(".file-field").change(function(){
    var file_input = $(this).children().children('input[type=file]');
    console.log(file_input[0].files[0]);

    if(file_input && file_input[0].files[0]){
        var reader = new FileReader();
        reader.readAsDataURL(file_input[0].files[0]);
        reader.onload = imageIsLoaded;
    }
});



function imageIsLoaded(e){
    $("#temp_pic").attr('src',e.target.result);
}