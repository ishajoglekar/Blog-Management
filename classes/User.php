<?php
class User{
    private $table = "users";
    
    private $user_post = "user_post";
    public static $login = false;
    private $columns = ['id', 'first_name','last_name','username','password','email','authority'];
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
            'first_name'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>25,
                'stringCheck'=>true
                

            ],'last_name'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>25,
                'stringCheck'=>true

            ],'username'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>40,
                'unique'=>$this->table,
                'validateUsername'=>true

            ],'password'=>[
                'required'=>true,
                'minlength'=>4,
                'maxlength'=>25,             

            ],'email'=>[
                'required'=>true,
                'email'=>true,
                'minlength'=>3,
                'maxlength'=>40,
                'unique'=>$this->table

            ]
        ]);
        
    }

    public function validateSignInData($data)
    {
        $this->validator = $this->di->get('validator');
        $this->validator = $this->validator->check($data,[
            'username'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>40,
                'stringSignIn'=>true
                
                

            ],'password'=>[
                'required'=>true,
                'minlength'=>4,
                'maxlength'=>25,            
                    

            ]
        ]);
        
    }


    public function validateEditData($data,$id)
    {
        // Util::dd(s$data);
        $this->validator = $this->di->get('validator');
        $this->validator = $this->validator->check($data,[
            'first_name'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>20,
                'stringCheck'=>true
                
                

            ],'last_name'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>20,
                'stringCheck'=>true
                

            ],'email'=>[
                'required'=>true,
                'email'=>true,
                'minlength'=>3,
                'maxlength'=>50,
                'uniqueEdit'=>$this->table.".".$id

            ],'username'=>[
                'required'=>true,
                'minlength'=>3,
                'maxlength'=>20,
                'uniqueEdit'=>$this->table.".".$id,
                'validateUsername'=>true
                
                

            ]
        ]);
        
    }

           

    public function addUser($data)
    {
        
        //VALIDATE DATA
        $this->validateData($data);

        //INSERT DATA IN DATABASE
        if(!$this->validator->fails())
        {
            
            
            try{
                $this->database->beginTransaction();
                $data_to_be_inserted['first_name'] = $data['first_name'];
                $data_to_be_inserted['last_name'] = $data['last_name'];
                $data_to_be_inserted['password'] = $data['password'];
                $data_to_be_inserted['username'] = $data['username'];
                $data_to_be_inserted['email'] =$data['email'];
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

    public function addUserByAdmin($data)
    {
        
        //VALIDATE DATA
        $this->validateData($data);

        //INSERT DATA IN DATABASE
        if(!$this->validator->fails())
        {
            
            
            try{
                $this->database->beginTransaction();
                $data_to_be_inserted['first_name'] = $data['first_name'];
                $data_to_be_inserted['last_name'] = $data['last_name'];
                $data_to_be_inserted['password'] = $data['password'];
                $data_to_be_inserted['username'] = $data['username'];
                $data_to_be_inserted['email'] =$data['email'];
                $data_to_be_inserted['authority'] =$data['authority'];
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


    public function signIn($data)
    {
       // $username = $this->database->sanitize_input($data['username']);

        $username = $data['username'];
        $password = $data['password'];
        $is_remember = $data['is_remember'];
       $this->validateSignInData($data);
      
       
       if(!$this->validator->fails())
       {
        //    Util::dd("hey");

            $signin_success = $this->di->get('auth')->signIn([
                'username'=>$username, 
                'password'=>$password
            ],$this->table);
            // Util::Dd($signin_success);

            if($signin_success)
            {
                //User::$login = true;
                    if($is_remember == "on")
                     { 
                         $idForToken = $this->getUserByUsername($username);
                        //  Util::dd("hello");
                        $token = $this->di->get('tokenHandler')->createRememberMeToken((int)$idForToken[0]['id']);
                        setcookie('token',$token,time() + TokenHandler::REMEMBER_ME_EXPIRY_TIME_IN_SECONDS);
                    }
                    else
                     {  
                         $idForToken = $this->getUserByUsername($username);
                        $token = $this->di->get('tokenHandler')->createWithoutRememberMeToken((int)$idForToken[0]['id']);
                        setcookie('token',$token,time() + TokenHandler::WITHOUT_REMEMBER_ME_EXPIRY_TIME_IN_SECONDS);
                    }
                    
                   
                   // Util::dd($this->getLogInStatus());
                    return SIGNIN_SUCCESS;
                    
            }

            return  SIGNIN_ERROR;
        //create a session
        //remember me
       }

       else
       {
              return VALIDATION_ERROR;
              
       }
    }

    public function resetPassword($data)
    {
       
        $email = $data['email'];
        $token = $data['token'];
        $password = $data['password'];

        if($this->di->get('tokenHandler')->isValid($token,0))
        {
            $password_reset_flag = $this->di->get('auth')->resetUserPassword($token,$password);
            $token_delete_flag = $this->di->get('tokenHandler')->deleteToken($token);
            if($password_reset_flag && $token_delete_flag)
            {
                Util::redirect("dashboard/login.php");
            }
            else{
                Util::redirect("dashboard/404.php");
            }
        }
        else{
            Util::redirect("dashboard/blank.php");
        }
    }

  

    public function requestPasswordReset($data,$mail)
    {
        

        $email = $data['email'];
        // Util::dd();
        $user = $this->di->get('auth')->getUserByEmail($email);
        if($user)
        {       
            $token = $this->di->get('tokenHandler')->createForgotPasswordToken($user->id);
            if($token)
            {
                $body = "<p>Use the below link to reset your password<p>";
                $body .= "<p><a href='http://localhost:9999/views/pages/dashboard/reset-password.php?token={$token}&email={$email}'>RESET PASSWORD</a>";

                $mail->addAddress($user->email);
                $mail->Subject = "Reset Password";
                $mail->Body = $body;

                if($mail->send())
                {
                    Session::setSession('EMAIL_SENT',"email_sent");
                    // Util::redirect("dashboard/blank.php");
                }
                else
                {
                    Session::setSession('NETWORk_ERROR',"network_error");
                    // Util::redirect("dashboard/forgot-password.php");
                }
            }
    
        }else{
            Session::setSession('EMAIL_ERROR',"email_error");
            // Util::redirect("dashboard/forgot-password.php");
           
        }
    }
    public function getJSONDataForDataTable($draw,$search_parameter,$order_by,$start,$length){
        

       $query = "SELECT users.id,concat(users.first_name,\"  \",users.last_name) as name,users.username,users.email,users.authority from users where deleted=0";
        

        $totalRowCountQuery = "SELECT COUNT(*) as total_count FROM {$this->table} WHERE deleted = 0";
        $filteredRowCountQuery = "SELECT COUNT(*) as total_count FROM {$this->table} WHERE deleted = 0";

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
        $subArray[] = $fetchedData[$i]->name;
        $subArray[] = $fetchedData[$i]->username;
        $subArray[] = $fetchedData[$i]->email;
        $subArray[] = $fetchedData[$i]->authority=="0" ? "User" : "Admin";
        $subArray[] =  <<<BUTTONS
        <form  action="{$baseassets}../helper/routing.php" method="POST" style="display:inline">
        <input type="hidden" name="user_id" value="{$fetchedData[$i]->id}">
        <button class='btn btn-outline-primary btn-sm edit' name="edit_user_data" data-id='{$fetchedData[$i]->id}'><i class="fas fa-pencil-alt"></i></button>
        </form>
        <button class='btn btn-outline-danger btn-sm delete' data-id='{$fetchedData[$i]->id}' data-toggle='modal' data-target='#deleteModal'><i class="fas fa-trash-alt"></i></button>   
            
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
   
   public function getUserByID($id, $fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = {$id} AND deleted = 0";
        $result = $this->database->raw($query,$fetchMode);
        return $result;
    }

    public function getUsers($fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT * FROM {$this->table} where deleted = 0";
        $result = $this->database->raw($query,$fetchMode);
        return $result;
    }
    public function getUserByUsername($name, $fetchMode = PDO::FETCH_ASSOC)
    {
        $query = "SELECT * FROM {$this->table} WHERE (username = '{$name}' OR email = '{$name}') AND deleted = 0";
        $result = $this->database->raw($query,$fetchMode);
        //Util::dd($result);
        return $result;
    }
    public function getUsernameByID($id, $fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT username FROM {$this->table} WHERE id = {$id} AND deleted = 0";
        $result = $this->database->raw($query,$fetchMode);
        return $result;
    }
    public function getAuthority($username, $fetchMode = PDO::FETCH_OBJ)
    {
        $query = "SELECT authority FROM {$this->table} WHERE username = '{$username}' AND deleted = 0";
        $result = $this->database->raw($query,$fetchMode);
        $authority = (int)$result[0]['authority'];
        return $authority;
    }
    public function getActiveToken($fetchMode = PDO::FETCH_ASSOC)
    {
        $query = "SELECT * FROM tokens WHERE (is_remember = 1) AND  expires_at > CURRENT_TIMESTAMP";
        $result = $this->database->raw($query,$fetchMode);
        //Util::dd($result);
       
        return $result;
       
    }
    public function deleteActiveToken($fetchMode = PDO::FETCH_ASSOC)
    {
        $query = "SELECT * FROM tokens WHERE (is_remember = 1 OR is_remember = 2) AND expires_at < NOW()";
        $result = $this->database->raw($query,$fetchMode);
        for($i=0;$i<count($result);$i++)
        {
            $this->di->get('tokenHandler')->deleteToken($result[$i]['token']);
        }
        
       
    }
   
    public function update($data,$id)
    {
        $data_to_be_updated['first_name'] = $data['first_name'];
        $data_to_be_updated['last_name'] = $data['last_name'];
        $data_to_be_updated['username'] = $data['username'];
        $data_to_be_updated['email'] =$data['email'];
        $data_to_be_updated['authority'] =$data['authority'];

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
}

?>

