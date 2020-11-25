<?php
class Auth
{
    protected $database;
    protected $hash;
    protected $di;
    protected $table= "users";
    protected $authSession ="user" ;
    /**
     * Auth constructor
     * @param $database
     */
    public function __construct( DependencyInjector $di)
    {
        $this->database = $di->get('database');
        $this->hash= $di->get('hash');
        $this->di = $di;
    }
    public function build()
    {
    $query = "CREATE TABLE IF NOT EXISTS {$this->table} (id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT, email VARCHAR(255) NOT NULL UNIQUE, username VARCHAR(255) NOT NULL UNIQUE,password VARCHAR(255) NOT NULL)";
    return $this->database->query($query);
    }

    public function create($table,$data){

        if(isset($data['password']))
        {
            $data['password'] = $this->hash->make($data['password']);
        }
        return $this->database->insert($table,$data);

    }
    public function signin($data,$table): bool
    {
       // $this->database->table($table)->where('username', '=', $data['username']);
    $query = "SELECT *  FROM {$table} where users.username = '{$data['username']}' OR users.email = '{$data['username']}' ";
        $result = $this->database->raw($query,PDO::FETCH_ASSOC);
       // Util::dd($result[0]['id']);
        if((int)$result[0]['id'] > 0)
        {
            
            if($this->hash->verify($data['password'], $result[0]['password']))
            {
                $this->setAuthSession((int)$result[0]['id']);
                return true;
            }
        }
        return false;
    }

    public function setAuthSession($id)
    {
        $_SESSION[$this->authSession] = $id;
    }
    public function unsetAuthSession()
    {
        unset($_SESSION[$this->authSession]);
        
    }
    public function check()
    {
        return isset($_SESSION[$this->authSession]);
    }
    public function checkWithToken()
    {
        return isset($_SESSION[$this->authSession]) && (isset($_COOKIE['token']) && $this->di->get('tokenHandler')->isValid($_COOKIE['token'],1));
    }
    public function user()
    {
        if(!$this->check())
        { 
            return false;
        }
        $query = "SELECT * FROM {$this->table} WHERE id = {$_SESSION[$this->authSession]}";
        $user = $this->database->raw($query,PDO::FETCH_ASSOC);
       // $user = $this->database->table($this->table)->where('id', '=', $_SESSION[$this->authSession])->first();
        return $user;
    }


    public function getUserByEmail(string $email)
    {
        return $this->database->table($this->table)->where("email","=" ,$email)->first();
    }
    public function getUserByUserName(string $username)
    {
        return $this->database->table($this->table)->where("username", "=", $username)->first();
    }

    public function resetUserPassword(string $token,string $password)
    {
        $password = $this->hash->make($password);
        $sql = "UPDATE users,tokens SET users.password = '{$password}' WHERE users.id = tokens.user_id AND tokens.token = '{$token}'";
        return $this->database->query(($sql));
    }
    public function signout()
    {
        setcookie('token','',time()-5000);
        $user_id = $_SESSION[$this->authSession];
        $sql = "DELETE FROM tokens where user_id = {$user_id} AND (is_remember=1 OR is_remember=2)";
        $this->database->query($sql);
        $this->unsetAuthSession();

    }
}