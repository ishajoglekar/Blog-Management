<?php
class Category{
    private $table = "category";
    

    public static $login = false;
    private $columns = ['id', 'category_name'];
    protected $di;
    // protected $mail;
    private $database;
    private $validator;
    public function __construct(DependencyInjector $di)
    {
        $this->di = $di;
        $this->auth = $this->di->get('auth');
        $this->database = $this->di->get('database');
    }
    public function getValidator(){
        return $this->validator;
    }



    public function validateData($data)
    {
        $this->validator = $this->di->get('validator');
        $this->validator = $this->validator->check($data,[
            'category_name'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>25,
                'unique'=>$this->table
            ]
        ]);
        
    }

    
    public function validateEditData($data,$id)
    {
        // Util::dd(s$data);
        $this->validator = $this->di->get('validator');
        $this->validator = $this->validator->check($data,[
            'category_name'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>25,
                'uniqueEdit'=>$this->table.".".$id
            ]
        ]);
        
    }

           

    public function addCategory($data)
    {
        
        //VALIDATE DATA
        $this->validateData($data);

        //INSERT DATA IN DATABASE
        if(!$this->validator->fails())
        {
            
            
            try{
                $this->database->beginTransaction();
                $data_to_be_inserted['category_name'] = $data['category_name'];
                // Util::dd($data_to_be_inserted);
                $user_id = $this->auth->create($this->table,$data_to_be_inserted);
                
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

    

    
 
    public function getJSONDataForDataTable($draw,$search_parameter,$order_by,$start,$length){
        

    //    $query = "SELECT users.id,concat(users.first_name,\"  \",users.last_name) as name,users.username,users.email,users.authority from users where deleted=0";
    
        $query = "SELECT * from category where deleted=0";

        $totalRowCountQuery = "SELECT COUNT(*) as total_count FROM {$this->table}";
        $filteredRowCountQuery = "SELECT COUNT(*) as total_count FROM {$this->table}";

        if($search_parameter != null)
        {
            $condition = " AND users.first_name LIKE '%{$search_parameter}%' OR users.last_name LIKE '%{$search_parameter}%' OR users.email LIKE '%{$search_parameter}%'"; 

            $query .= "$condition";
            $filteredRowCountQuery .= "$condition";
        }

    //Util::dd($this->columns[$order_by[0]['column']]);

    if($order_by != null)
    {
        $query .= " ORDER BY {$this->columns[$order_by[0]['column']]} {$order_by[0]['dir']}";

        $filteredRowCountQuery .= " ORDER BY {$this->columns[$order_by[0]['column']]} {$order_by[0]['dir']}";


    }
    else{
        $query .= " ORDER BY {$this->columns[0]} ASC";
        $filteredRowCountQuery .= "ORDER BY {$this->columns[0]} ASC";
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
    // Util::dd($fetchedData[0]->id);
        $subArray[] =  <<<BUTTONS
        <form  action="{$baseassets}../helper/routing.php" method="POST" style="display:inline">
        <input type="hidden" name="category_id" value="{$fetchedData[$i]->id}">
        <button class='btn btn-outline-primary btn-sm edit' name="edit_category_data" data-id='{$fetchedData[$i]->id}'><i class="fas fa-pencil-alt"></i></button>
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
   
   
    public function update($data,$id)
    {
        $data_to_be_updated['category_name'] = $data['category_name'];


        $this->ValidateEditData($data_to_be_updated,$id);
        // Util::dd("isha");
        if(!$this->validator->fails())
        {
           
            try{
                $this->database->beginTransaction();
               
                $this->database->update($this->table,$data_to_be_updated,"id = {$id}");
                
                
                $this->database->commit();
                
                return UPDATE_SUCCESS;
            }catch(Exception $e){
                $this->database->rollBack();
                return UPDATE_ERROR;
            }
        }
        else{
            return VALIDATION_ERROR;
        }
        
    }

    public function delete($id)
    {
        try{
            $this->database->beginTransaction();
            $this->database->delete($this->table,"id={$id}");
            
            $this->database->commit();
            return DELETE_SUCCESS;
        }catch(Exception $e){
            $this->database->rollBack();
            return DELETE_ERROR;
        }
    }

    public function getCategoryByID($id, $fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = {$id} AND deleted = 0";
        $result = $this->database->raw($query,$fetchMode);
        // Util::dd($result);
        return $result;
    }

    public function getCategories($fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT category_name FROM {$this->table} where deleted = 0";
        $result = $this->database->raw($query,$fetchMode);
        // Util:dd($result);
        return $result;
    }

    public function getLikedCategories($id,$fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT category_name FROM {$this->table} where category.id in(select users_category.category_id from users_category where user_id =$id) and deleted = 0";
        $result = $this->database->raw($query,$fetchMode);
        // Util:dd($result);
        return $result;
    }

    public function getCategoryIDByName($i,$fetchMode=PDO::FETCH_ASSOC) {
        $query = "SELECT id FROM category where category_name = '$i' and deleted = 0";
        $result = $this->database->raw($query,$fetchMode);
        // Util::dd($result);
        return $result;
    }
}


