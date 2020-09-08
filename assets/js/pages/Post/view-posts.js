var TableDatatables = function(){
    var viewPostTable = function(){
        // alert(("hey"));
        var viewPosts = $("#view-posts");
        var baseURL = window.location.origin;
        var filePath = "/helper/routing.php";
        viewPosts.dataTable({
            "processing":true,
            "serverSide":true,
            "ajax":{
                url:baseURL+filePath,
                type:"POST",
                data:{
                    "page": "view-all-posts"
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
        
         
    }

    

   
    return{
        //main function to handle all the datatables

        init: function(){
            // alert(("hey"));
            viewPostTable();
            // alert(("hey"));
        }
    }
}();

jQuery(document).ready(function(){
    // alert(("hey"));
    TableDatatables.init();
    
});

