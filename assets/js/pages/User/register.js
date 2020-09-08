$(function(){
    $('#register').validate({
        rules:{
            'first_name':{
                required:true,
                minlength : 3,
                maxlength : 25,
            },
            'last_name':{
                required:true,
                minlength : 3,
                maxlength : 25,
            },
            'username':{
                required:true,
                minlength : 3,
                maxlength : 40,
            },
            
            'email':{
                required:true,
                minlength : 3,
                maxlength : 40,
            },
            'password':{
                required:true,
                minlength : 3,
                maxlength : 25,
            }
        },
        
        submitHandler: function(form){
            form.submit();
        }
    })
});