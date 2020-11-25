<?php
class POST{
    private $table = "posts";
    private $users_posts = "users_posts";
    private $category_table ="category";

    protected $di;
    // protected $mail;
    private $database;
    private $validator;
    public function __construct(DependencyInjector $di)
    {
        $this->di = $di;
        $this->auth = $this->di->get('auth');
        $this->database = $this->di->get('database');
        // $this->mail = $this->di->get('mail');
    }
    
    public function getValidator(){
        return $this->validator;
    }
    public function validateData($data)
    {
        $this->validator = $this->di->get('validator');
        $this->validator = $this->validator->check($data,[
            'name'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>80,
                'unique'=>$this->table
                

            ],'author'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>50

            ],'category_id'=>[
                'required'=>true,
       

            ],'content'=>[
                'required'=>true,
                'minlength'=>10
                   

            ],'post_image'=>[
                'required'=>true,
            ]
        ]);
        
    }

    public function validateEditData($data,$id)
    {
        // Util::dd($id);
        $this->validator = $this->di->get('validator');
        $this->validator = $this->validator->check($data,[
            'name'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>80,
                'uniqueEdit'=>$this->table.".".$id
                

            ],'author'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>50

            ],'category_id'=>[
                'required'=>true,
       

            ],'content'=>[
                'required'=>true,
                'minlength'=>10
                   

            ],'post_image'=>[
                'required'=>true,
            ]
        ]);
        // Util::Dd($this->validator);
        
    }

    

    public function addPost($data)
    {
       
        $this->validateData($data);
        
        //INSERT DATA IN DATABASE
        if(!$this->validator->fails())
        {
            
            try{
                $this->database->beginTransaction();
                $getIDQuery = "SELECT max(id) as id FROM {$this->table}";
                
                $getOldID = $this->database->raw($getIDQuery,PDO::FETCH_ASSOC);
                
                $getID = ((int)$getOldID[0]['id'] +1);
                $user = $this->di->get('auth')->user();
                $username = $user[0]['username'];
                $image_name = $getID;
      
                if(isset($_FILES['post_image']))
                {
                    $file_name = $_FILES['post_image']['name'];
                    $file_tmp = $_FILES['post_image']['tmp_name'];
            
                    $temp = explode(".",$file_name);
                    $file_extension = strtolower(end($temp));
            
                    $image_name .= "." . "jpg";
                    move_uploaded_file($file_tmp,"../assets/images/posts/$image_name");
                    //Util::dd("hmm");
                }

                $data_to_be_inserted['name'] = $data['name'];
                $data_to_be_inserted['category_id'] = $data['category_id'];
                $data_to_be_inserted['content'] =  $data['content'];
                $data_to_be_inserted['author'] = $username;
                $data_to_be_inserted['post_image'] =$image_name;
                 
                $data_in_users_posts['post_id']= $getID;
                $data_in_users_posts['user_id']=$user[0]['id'];

                // Util::dd($data_to_be_inserted);

                $post_id = $this->database->insert($this->table,$data_to_be_inserted);
                $category_id = $this->database->insert($this->users_posts,$data_in_users_posts);
                
                $this->database->commit();
                return ADD_SUCCESS;
            }
            catch(Exception $e)
            {
                $this->database->rollBack();
                return ADD_ERROR;
            }


        }
        
        return VALIDATION_ERROR;
    }



    public function getCategoryByID($id, $fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT category_name FROM {$this->category_table} WHERE id = {$id} ";
        $result = $this->database->raw($query,$fetchMode);
        return $result;
    }
    public function checkEditPost($userID, $postID, $fetchMode = PDO::FETCH_ASSOC)
    {
        $query = "SELECT user_id FROM users_posts WHERE user_id = {$userID} and post_id = {$postID}";
        $result = $this->database->raw($query,$fetchMode);
        return $result;
    }


    public function getPostByID($id, $fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = {$id} AND posts.deleted = 0";
        $result = $this->database->raw($query,$fetchMode);
        // Util:dd($result);
        return $result;
    }
    public function getPosts($fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT posts.id as post_id,posts.name, posts.content, posts.author,posts.post_image, posts.created_at, category.category_name FROM {$this->table} INNER JOIN {$this->category_table} ON posts.category_id = category.id and posts.deleted = 0;";

        $result = $this->database->raw($query,$fetchMode);
        return $result;
    }

    public function getLikedPosts($id,$fetchMode = PDO::FETCH_ASSOC)
    {
        $query = "SELECT posts.id,posts.name, posts.content, posts.author,posts.post_image, posts.created_at, category.category_name FROM(((posts INNER JOIN users_posts on posts.id = users_posts.post_id) INNER JOIN users on users_posts.user_id = users.id) INNER JOIN users_category on users.id = users_category.user_id and users.id = ".$id.")INNER JOIN category on users_category.category_id = category.id group by(posts.name)";

        // Util::dd($query);
        $result = $this->database->raw($query,$fetchMode);
        // Util::Dd("hi");
        // Util::Dd(count($result));
        return $result;
    }
    public function getPostsByLimit($start, $recordNo, $fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT posts.id,posts.name, posts.content, posts.author,posts.post_image, posts.created_at, category.category_name FROM {$this->table} INNER JOIN {$this->category_table} ON posts.category_id = category.id and posts.deleted = 0 LIMIT {$start},{$recordNo};";

        $result = $this->database->raw($query,$fetchMode);
       // Util::dd($result);
        return $result;
    }
    public function getIDByPostName($name, $fetchMode = PDO::FETCH_OBJ)
    {
       $name = $this->database->sanitize_input($name);
        $query = "SELECT id FROM {$this->table} WHERE name = '{$name}' AND posts.deleted = 0";
        // Util::Dd("isha");
        $result = $this->database->raw($query,$fetchMode);
        //Util::dd($result);
        return $result;
    }

    public function update($data,$id)
    {
        // $this->database->beginTransaction();
        
    //    Util::dd($_FILES);
        
        
        $image_name = $id;

        if(isset($_FILES['post_image']))
        {
           $file_name = $_FILES['post_image']['name'];
            $file_tmp = $_FILES['post_image']['tmp_name'];
            // Util
            $temp = explode(".",$file_name);
            $file_extension = strtolower(end($temp));
    
            $image_name .= "." ."jpg";
            move_uploaded_file($file_tmp,"../assets/images/posts/$image_name");
            // Util::dd("hmm");
        }
        // Util::dd($image_name);

        $data_to_be_updated['name'] = $data['name'];
        $data_to_be_updated['category_id'] = $data['category_id'];
        $data_to_be_updated['content'] = $data['content'];
        $data_to_be_updated['post_image'] =$image_name;
         
           
       $this->validateEditData($data_to_be_updated,$id);
        
        if(!$this->validator->fails())
        {
            // Util::dd("hei");
            try{

                
                $this->database->beginTransaction();
                // Util::dd("isha");
                $this->database->update($this->table,$data_to_be_updated,"id = {$id}");
                
                
                $this->database->commit();
                
                return UPDATE_SUCCESS;
            }catch(Exception $e){
                // Util::dd($e);
                $this->database->rollBack();
                return UPDATE_ERROR;
            }
        }
        else{
            return VALIDATION_ERROR;
        }
        
    }



    public function getJSONDataForDataTableById($draw,$search_parameter,$order_by,$start,$length,$id)
    {
        
        
        $columns = ['id', 'name','content','post_image'];
       $query = "SELECT posts.id,posts.name, posts.content,posts.post_image, category.category_name from {$this->table} INNER JOIN {$this->category_table} ON posts.category_id = category.id and posts.deleted = 0 and posts.id in(select users_posts.post_id from users_posts where users_posts.user_id = {$id})";

      
        
       

        $totalRowCountQuery = "SELECT COUNT(*) as total_count FROM {$this->table} INNER JOIN {$this->category_table} ON posts.category_id = category.id and posts.deleted = 0 and posts.id in (select users_posts.post_id from users_posts where users_posts.user_id = {$id})";
        $filteredRowCountQuery = "SELECT COUNT(*) as total_count FROM {$this->table} INNER JOIN {$this->category_table} ON posts.category_id = category.id and posts.deleted = 0 and posts.id in(select users_posts.post_id from users_posts where users_posts.user_id = {$id})";


        if($search_parameter != null)
        {
            $condition = " AND (posts.name LIKE '%{$search_parameter}%' OR posts.content LIKE '%{$search_parameter}%' OR category.category_name LIKE '%{$search_parameter}%')"; 

            $query .= " $condition";
            $filteredRowCountQuery .= " $condition";
        }

        // $query .= " $groupBy";
      //  $filteredRowCountQuery .= " $groupBy";
        //Util::dd($filteredRowCountQuery);
    //Util::dd($this->columns[$order_by[0]['column']]);

    if($order_by != null)
    {
        $query .= " ORDER BY {$columns[$order_by[0]['column']]} {$order_by[0]['dir']}";

        $filteredRowCountQuery .= " ORDER BY {$columns[$order_by[0]['column']]} {$order_by[0]['dir']}";


    }
    else{
        $query .= " ORDER BY {$columns[0]} ASC";
        $filteredRowCountQuery .= "ORDER BY {$columns[0]} ASC";
    }

    if($length!=-1)
    {
        $query .= " LIMIT {$start}, {$length}";
    }

    $totalRowCountResult = $this->database->raw($totalRowCountQuery);

    $numberOfTotalRows = is_array($totalRowCountResult) ? $totalRowCountResult[0]->total_count : 0;

    $filteredRowCountResult = $this->database->raw($filteredRowCountQuery);

    $numberOfFilteredRows = is_array($filteredRowCountResult) ? $filteredRowCountResult[0]->total_count : 0;

    $fetchedData = $this->database->raw($query);//select queries ke liye raw vaparte
   // Util::dd($fetchedData);
    $baseassets=BASEASSETS;
    $data = [];
    $numRows = is_array($fetchedData) ? count($fetchedData) : 0;
    for($i=0;$i<$numRows;$i++){
        $subArray = [];
        $subArray[] = $start+$i+1;
        $subArray[] = $fetchedData[$i]->category_name;
        $subArray[] = $fetchedData[$i]->name;
        $subArray[] = htmlspecialchars($fetchedData[$i]->content,ENT_QUOTES);
        $subArray[] = <<<IMAGES
        <img style="width:100px;" src="{$baseassets}images/posts/{$fetchedData[$i]->post_image}">
IMAGES;
      
    $subArray[] =  <<<BUTTONS
    <form  action="{$baseassets}../helper/routing.php" method="POST" style="display:inline">
    <input type="hidden" name="post_id" value="{$fetchedData[$i]->id}">
    <button class='btn btn-outline-primary btn-sm edit' name="edit_post_data" data-id='{$fetchedData[$i]->id}'><i class="fas fa-pencil-alt"></i></button>
    </form>
    <button class='btn btn-outline-danger btn-sm delete' name="id" data-id='{$fetchedData[$i]->id}' data-toggle='modal' data-target='#deleteModal'><i class="fas fa-trash-alt"></i></button>   

BUTTONS;
        
        $data[] = $subArray;//multidimensional array mai baith jayega {subarray[],subarray[]....}
    }

    $output = array(
        'draw'=>$draw,
        'recordsTotal'=>$numberOfTotalRows,
        'recordsFiltered'=>$numberOfFilteredRows,
        'data'=>$data
    );
    echo json_encode($output);
    }


    public function getJSONDataForDataTable($draw,$search_parameter,$order_by,$start,$length)
    {
        // Util::dd("chalna bc");
        
        $columns = ['id', 'name','content','post_image','author'];
       $query = "SELECT posts.id,posts.name, posts.content, posts.author,posts.post_image, category.category_name FROM {$this->table} INNER JOIN {$this->category_table} ON posts.category_id = category.id and posts.deleted = 0";
        
       

        $totalRowCountQuery = "SELECT COUNT(*) as total_count FROM {$this->table} INNER JOIN {$this->category_table} ON posts.category_id = category.id AND posts.deleted = 0";
        $filteredRowCountQuery = "SELECT COUNT(*) as total_count FROM {$this->table} INNER JOIN {$this->category_table} ON posts.category_id = category.id AND posts.deleted = 0";

        if($search_parameter != null)
        {
            $condition = " AND (posts.name LIKE '%{$search_parameter}%' OR posts.author LIKE '%{$search_parameter}%' OR posts.content LIKE '%{$search_parameter}%' OR category.category_name LIKE '%{$search_parameter}%')"; 

            $query .= " $condition";
            $filteredRowCountQuery .= " $condition";
        }

        // $query .= " $groupBy";
      //  $filteredRowCountQuery .= " $groupBy";
        //Util::dd($filteredRowCountQuery);
    //Util::dd($this->columns[$order_by[0]['column']]);

    if($order_by != null)
    {
        $query .= " ORDER BY {$columns[$order_by[0]['column']]} {$order_by[0]['dir']}";

        $filteredRowCountQuery .= " ORDER BY {$columns[$order_by[0]['column']]} {$order_by[0]['dir']}";


    }
    else{
        $query .= " ORDER BY {$columns[0]} ASC";
        $filteredRowCountQuery .= "ORDER BY {$columns[0]} ASC";
    }

    if($length!=-1)
    {
        $query .= " LIMIT {$start}, {$length}";
    }

    $totalRowCountResult = $this->database->raw($totalRowCountQuery);

    $numberOfTotalRows = is_array($totalRowCountResult) ? $totalRowCountResult[0]->total_count : 0;

    $filteredRowCountResult = $this->database->raw($filteredRowCountQuery);

    $numberOfFilteredRows = is_array($filteredRowCountResult) ? $filteredRowCountResult[0]->total_count : 0;

    $fetchedData = $this->database->raw($query);//select queries ke liye raw vaparte
   // Util::dd($fetchedData);
    $baseassets=BASEASSETS;
    $data = [];
    $numRows = is_array($fetchedData) ? count($fetchedData) : 0;
    for($i=0;$i<$numRows;$i++){
        $subArray = [];
        $subArray[] = $start+$i+1;
        $subArray[] = $fetchedData[$i]->category_name;
        $subArray[] = $fetchedData[$i]->name;
        $subArray[] = htmlspecialchars($fetchedData[$i]->content,ENT_QUOTES);
        $subArray[] = <<<IMAGES
        <img style="width:100px;" src="{$baseassets}images/posts/{$fetchedData[$i]->post_image}">
IMAGES;
        $subArray[] = $fetchedData[$i]->author;
        $user = $this->di->get('auth')->user();
        // Util::dd((int)$user[0]['authority']);
        if((int)$user[0]['authority'])
        {
            // Util::dd("hey");
    $subArray[] =  <<<BUTTONS
    <form  action="{$baseassets}../helper/routing.php" method="POST" style="display:inline">
    <input type="hidden" name="post_id" value="{$fetchedData[$i]->id}">
    <button class='btn btn-outline-primary btn-sm edit' name="edit_post_data" data-id='{$fetchedData[$i]->id}'><i class="fas fa-pencil-alt"></i></button>
    </form>
    <button class='btn btn-outline-danger btn-sm delete' name="id" data-id='{$fetchedData[$i]->id}' data-toggle='modal' data-target='#deleteModal'><i class="fas fa-trash-alt"></i></button>   

BUTTONS;
        }
        $data[] = $subArray;//multidimensional array mai baith jayega {subarray[],subarray[]....}
    }

    $output = array(
        'draw'=>$draw,
        'recordsTotal'=>$numberOfTotalRows,
        'recordsFiltered'=>$numberOfFilteredRows,
        'data'=>$data
    );
    echo json_encode($output);
    }

    public function delete($id)
    {
        try{
            $this->database->beginTransaction();
            $this->database->delete($this->table,"id={$id}");
            // $this->database->delete($this->address,"id={$id}");
            $this->database->deletePermanently($this->users_posts,"post_id={$id}");
            $this->database->commit();
            return DELETE_SUCCESS;
        }catch(Exception $e){
            $this->database->rollBack();
            return DELETE_ERROR;
        }
    }

    public function likeunlike(){
        Util::dd("hii");
    }

    public function syncFavs($favArr,$user){
        try{
            $this->database->beginTransaction();
            $this->database->syncFavs('users_category',$favArr,$user);
            // Util::Dd("Hi")
            // $this->database->delete($this->address,"id={$id}");
            // $this->database->deletePermanently($this->users_posts,"post_id={$id}");
            $this->database->commit();
            return DELETE_SUCCESS;
        }catch(Exception $e){
            $this->database->rollBack();
            return DELETE_ERROR;
        }
    }

}