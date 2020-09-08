var TableDatatables = function(){
    var manageUsersTable = function(){
        // alert(("hey"));
        var manageUsers = $("#manage-users");
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        manageUsers.dataTable({
            "processing":true,
            "serverSide":true,
            "ajax":{
                url:baseURL+filePath,
                type:"POST",
                data:{
                    "page": "manage-all-users"
                }
            },
            "lengthMenu": [
                [5,15,25,-1],
                [5,15,25,"All"]
            ],
            "order": [
                [1,"desc"]
            ],
            "columnDefs": [
                {
                    'orderable': false,
                    'targets': [0,-1]
                }
            ]
        });
        manageUsers.on('click','.edit', function(e){
                                        
            var id = $(this).data('id');
            // console.log($(this).data('id'));
            $("#edit_post_id").val(id);
            //Fetching all other values from the database `using AJAX ombimand loading them onto thier respective fields in the modal.
            $.ajax({
                url:baseURL+filePath,
                method:"POST",
                data:{
                    "user_id":id,
                    "fetch":"user"
                },
                dataType:"json",
                success:function(data)
                {
                    console.log(data);
                }  ,
                error:function(errorThrown)
                {
                    console.error(errorThrown);
                }         
            })
        });
        manageUsers.on('click','.delete',function(e){
            // alert("hey");
            var id = $(this).data('id');
            console.log(id);
            $("#delete_user_id").val(id);
        }); 
    
        
         
    }

    
   
    return{
        //main function to handle all the datatables

        init: function(){
            // alert(("hey"));
            manageUsersTable();
            // alert(("hey"));
        }
    }
}();

jQuery(document).ready(function(){
    // alert(("hey"));
    TableDatatables.init();
    
});

