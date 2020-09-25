<?php
/**
 * Cookie - token
 * remmeberme or forgot password
 * forgot me or remmeber me se token banaa hai
 * databse =>
 * class member ->
 */
class Tokenhandler
{
    protected static $REMEMBER_EXPIRY_TIME = "6 hours";
    const REMEMBER_ME_EXPIRY_TIME_IN_SECONDS = 21600;
    protected static $WITHOUT_REMEMBER_EXPIRY_TIME = "15 minutes";
    const WITHOUT_REMEMBER_ME_EXPIRY_TIME_IN_SECONDS = 900;
    protected static $FORGOT_PWD_EXPIRY_TIME ="15 minutes";
    CONST FORGOT_PWD_EXPIRY_TIME_IN_SECONDS = 900;

    protected $table = "tokens";
    protected $database;
    protected $hash;

    public function __construct(DependencyInjector $di)
    {
            $this->database = $di->get('database');
            $this->hash = $di->get('hash');
    }
    public function build(){
        $CREATE_QUERY = "CREATE TABLE IF NOT EXISTS {$this->table} (id INT PRIMARY KEY AUTO_INCREMENT, user_id INT, token VARCHAR(255) UNIQUE, expires_at DATETIME NOT NULL, is_remember TINYINT DEFAULT 0)";
        $this->database->query($CREATE_QUERY);
    }
    public static function getCurrentTimeInMilliSec()
    {
        return round(microtime(true) * 1000);
    }
    public function createRememberMeToken(int $user_id)
    {
        return $this->createToken($user_id,1);
    }
    public function createWithoutRememberMeToken(int $user_id)
    {
        return $this->createTempToken($user_id,2);
    }
    
    public function createForgotPasswordToken(int $user_id)
    {
        return $this->createToken($user_id,0);
    }
    public function isValid(string $token, int $isRemember)
    {
        /**
         * user id
         * agar token valid hai toh hi entry hona chahiye
         * agar cookie expire hona hai toh
         */
        $query = "SELECT * FROM {$this->table} WHERE token = '{$token}' AND expires_at >= NOW() AND is_remember = {$isRemember}";
        return !empty($this->database->raw($query));
    }
    public function getUserFromValidToken($token)
    {
        $token = $this->database->table($this->table)->where('token','=',$token)->first();
        return $this->database->table('users')->where('id','=',$token->user_id)->first();
    }
    public function getValidExistingToken(int $user_id,int $isRemember)
    {
        $query = "SELECT * FROM {$this->table} WHERE user_id = '{$user_id}' AND expires_at > NOW() AND is_remember = {$isRemember}";
        $retVal = $this->database->raw($query);
        return $retVal[0]->token ?? null;

    }

    public function deleteToken(string $token)
    {
        $sql = "DELETE FROM {$this->table} WHERE token = '{$token}'";
        // Util::dd("hello");
        return $this->database->query($sql);
    }
    private function createToken(int $user_id, int $isRemember)
    {
        
        $validToken = $this->getValidExistingToken($user_id,$isRemember);
        if($validToken)
        {
            return $validToken;
        }
        
        $currentTime = date("Y-m-d H:i:s");
        $timeToBeAdded = $isRemember ? TokenHandler::$REMEMBER_EXPIRY_TIME : TokenHandler::$FORGOT_PWD_EXPIRY_TIME;

        $data =[
            'user_id'=>$user_id,
            'token'=>$this->hash->generateRandomToken($user_id),
            'is_remember'=>$isRemember,
            'expires_at'=>date('Y-m-d H:i:s', strtotime($currentTime. "+".$timeToBeAdded))
        ];
        return $this->database->table($this->table)->insert($this->table,$data) ? $data['token'] : null;
    }
    private function createTempToken(int $user_id, int $isRemember)
    {
        $validToken = $this->getValidExistingToken($user_id,$isRemember);
        if($validToken)
        {
            return $validToken;
        }
        
        $currentTime = date("Y-m-d H:i:s");
        $timeToBeAdded =  TokenHandler::$WITHOUT_REMEMBER_EXPIRY_TIME;

        $data =[
            'user_id'=>$user_id,
            'token'=>$this->hash->generateRandomToken($user_id),
            'is_remember'=>$isRemember,
            'expires_at'=>date('Y-m-d H:i:s', strtotime($currentTime. "+".$timeToBeAdded))
        ];
        return $this->database->table($this->table)->insert($this->table,$data) ? $data['token'] : null;
    }


}