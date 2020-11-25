<?php

class Database
{
    private $di;
    private $pdo;
    private $stmt;
    private $stmt1;
    private $debug;
    private $host;
    private $username;
    private $password;
    private $db;
    private $table;
    public function __construct(DependencyInjector $di)
    {
        $this->di = $di;
        $config = $this->di->get('config');

        $this->debug = $config->get('debug');
        $this->host = $config->get('host');
        $this->username = $config->get('username');
        $this->password = $config->get('password');
        $this->db = $config->get('db');
        $this->connectDB();
    }

    public function sanitize_input($value)
    {


        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\", "\\0", "\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($search, $replace, $value);
    }

    private function connectDB()
    {
        try {

            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->username, $this->password);
            // Util::dd($this->pdo);
            if ($this->debug) {
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (PDOException $e) {
            // echo "isha";
            die($this->debug ? $e->getMessage() : "Error Whule connecting to databaase");
        }
    }
    public function query($sql)
    {
        return $this->pdo->query($sql);
    }
    public function raw($sql, $mode = PDO::FETCH_OBJ)
    {
        /**
         * select query hai toh raw mai
         */
        return $this->query($sql)->fetchAll($mode);
        //    Util::dd($this->query($sql)->fetchAll($mode));
    }
    public function insert(string $table, $data)
    {

        $keys = array_keys($data);

        $fields = "`" . implode("`, `", $keys) . "`";
        $placeholder = ":" . implode(", :", $keys);

        $sql = "INSERT INTO `{$table}` ({$fields}) VALUES ({$placeholder})";

        $this->stmt = $this->pdo->prepare($sql);

        $this->stmt->execute($data);
        return $this->pdo->lastInsertId();
    }
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function delete(string $table, $condition)
    {
        $sql = "UPDATE {$table} SET deleted = 1 WHERE {$condition}";
        $this->stmt = $this->pdo->prepare($sql);
        // Util::dd($this->stmt);
        return $this->stmt->execute();
    }

    public function deletePermanently(string $table, $condition)
    {
        $sql = "DELETE FROM {$table} WHERE {$condition}";
        $this->stmt = $this->pdo->prepare($sql);
        // Util::Dd($this->stmt->execute());
        return $this->stmt->execute();
    }

    public function update(string $table, $data, $condition = "1")
    {
        $columnKeyValue = "";
        $i = 0;
        foreach ($data as $key => $value) {
            $columnKeyValue .= "$key = :$key";
            $i++;
            if ($i < count($data)) {
                $columnKeyValue .= ", ";
            }
        }
        $sql = "UPDATE {$table} SET {$columnKeyValue} WHERE {$condition}";
        // 
        $this->stmt = $this->pdo->prepare($sql);
        // Util::dd($this->stmt);
        return $this->stmt->execute($data);
    }

    public function readData($table, $fields = [], $condition = "1", $readMode = PDO::FETCH_OBJ)
    {
        if (count($fields) == 0) {
            $columnNameString = "*";
        } else {
            $columnNameString = implode(", ", $fields);
        }
        $sql = "SELECT {$columnNameString} FROM {$table} WHERE {$condition}";
        //Util::dd($sql);
        $this->stmt = $this->pdo->prepare($sql);

        $this->stmt->execute();

        return $this->stmt->fetchAll($readMode);
    }
    public function exists($table, $data)
    {
        //$data['name'=>'HT'];
        $field = array_keys($data)[0];
        $data = $this->sanitize_input($data[$field]);


        $result = $this->readData($table, [], "{$field} = '{$data[$field]}' and deleted = 0", PDO::FETCH_ASSOC);
        // Util::dd($result);
        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function existsUnique($data, $table, $id)
    {
        //$data['name'=>'HT'];
        $field = array_keys($data)[0];
        $data = $this->sanitize_input($data[$field]);
        //Util::dd($data[$field]);  
        //SELECT * FROM customers WHERE gst_no = "14BAADD5674B2Z6" and id NOT IN (18) and deleted = 0 
        $result = $this->readData($table, [], "{$field} = '{$data[$field]}' and $table.id NOT IN ($id) and  deleted = 0 ", PDO::FETCH_ASSOC);

        if (sizeof($result) > 0) {
            return true;
        } else {

            return false;
        }
    }
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    public function commit()
    {
        return $this->pdo->commit();
    }
    public function rollBack()
    {
        return $this->pdo->rollBack();
    }

    //JUST KEPT TO ENSURE THAT WHEN WE ADD AUTH IT WILL BE COMPATIBLE
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }
    public function where($field, $operator, $value)
    {
        $this->stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$field} {$operator} :value");
        $this->stmt->execute(["value" => $value]);
        return $this;
    }

    public function get()
    {
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function first()
    {

        $result = $this->get();
        return !empty($result) ? $result[0] : null;
    }

    public function count()
    {
        return $this->stmt->rowCount();
    }

    public function insertmany($sql1)
    {
        $this->stmt1 = $this->pdo->prepare($sql1);
        // Util::Dd($this->stmt1->execute());
        return $this->stmt1->execute();
    }
    public function syncFavs(string $table, $favArr, $user)
    {

        // $sql = "DELETE from users_category where user_id = ".(int)$user[0]['id'];
        // $this->stmt = $this->pdo->prepare($sql);
        // return $this->stmt->execute();

        $this->deletePermanently('users_category', "user_id = " . (int)$user[0]['id']);
        $val = "";
        // Util::dd($favArr);
        for ($i = 0; $i < count($favArr); $i++) {

            $sql1 = "INSERT INTO users_category(user_id,category_id)VALUES (" . (int)$user[0]['id'] . ",$favArr[$i])";
            // Util::Dd($sql1);
            $this->insertmany($sql1);
        }
        // Util::dd($this->stmt->execute());

        // Util::Dd($sql1);
    }
}
