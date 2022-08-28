
<?php
class DataBase{

    static $db;
    private $path="configDB.json";
    public function getInstance(){
        if ($this::$db==null){

            $js=json_decode(file_get_contents($this->path),true);
            try{
                $this::$db = new PDO("mysql:host=$js[servername];dbname=$js[dbName]", $js['username'], $js['password']);
            }catch (PDOException $e){
                echo 'Error Message:'.$e->getMessage() ;
                # Any kind of connection error causes to the db become null
                # Die ?
            }
        }
        return $this::$db;
    }

    #Purpose is to connect a db and insert into given table
    public function insertion($vals,$target){

        try{
            $sql="INSERT INTO $target
                Values$vals
            ";
            $this->getInstance()->exec($sql);
            echo "insertion is succsesful \n";
        }catch (PDOException $e){
            echo $e->getMessage()."\n";
        }
    }
    public function query($sel,$target){

        try{
            $sql="select $sel
                from $target
            ";
            $querry=$this->getInstance()->query($sql)->fetchAll();
            print_r( $querry)."\n";
        }catch (PDOException $e){
            echo $e->getMessage()."\n";
        }
    }

}

$target="parity(code,name)";
$vals="('asd','as')";
$asd= new DataBase();
$asd->insertion($vals,$target);

$sel="*";
$tar="parity";
$asd->query($sel,$tar);
