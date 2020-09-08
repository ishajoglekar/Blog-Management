$(function(){
    $('#add-post').validate({
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