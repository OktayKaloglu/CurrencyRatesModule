
<?php
class DataBase{

    static $db;
    private $path="configDB.json";
    public function getInstance(){
        if ($this->db==null){

            $js=json_decode(file_get_contents($this->path),true);
            $this->db = new PDO("mysql:host=$js[servername];dbname=$js[dbName]", $js['username'], $js['password']);

        }
        return $this->db;
    }

}

$db=new DataBase;
var_dump($db);
