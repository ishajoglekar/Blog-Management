var TableDatatables = function(){
    var manageCategoriesTable = function(){
        // alert(("hey"));
        var manageCategories = $("#manage-categories");
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        manageCategories.dataTable({
            "processing":true,
            "serverSide":true,
            "ajax":{
                url:baseURL+filePath,
                type:"POST",
                data:{
                    "page": "manage-categories"
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
        manageCategories.on('click','.edit', function(e){
                                        
            var id = $(this).data('id');
            // console.log($(this).data('id'));
            $("#edit_post_id").val(id);
            //Fetching all other values from the database `using AJAX ombimand loading them onto thier respective fields in the modal.
            $.ajax({
                url:baseURL+filePath,
                method:"POST",
                data:{
                    "user_id":id,
                    "fetch":"category"
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
        manageCategories.on('click','.delete',function(e){
            // alert("hey");
            var id = $(this).data('id');
            console.log(id);
            $("#delete_category_id").val(id);
        }); 
    
        
         
    }

    
   
    return{
        //main function to handle all the datatables

        init: function(){
            // alert(("hey"));
            manageCategoriesTable();
            // alert(("hey"));
        }
    }
}();

jQuery(document).ready(function(){
    // alert(("hey"));
    TableDatatables.init();
    
});

