
<?php
class DataBase{

    private static $db;
    private static $dbName;
    private $path="configDB.json";
    private $tables;

    function __destruct() {
        try{
            $this->getInstance()->query('KILL CONNECTION_ID()');#force the database to close conn
            $this::$db=null;
            echo "Database connection is closed.";
        }catch (PDOException $e){

            echo $e->getMessage()."\n";
        }
    }
    #Trying to use only one connection to the database
    public function getInstance(){
        if ($this::$db==null){

            $js=json_decode(file_get_contents($this->path),true);
            try{
                $this::$db = new PDO("mysql:host=$js[servername];dbname=$js[dbName]", $js['username'], $js['password']);
                $this->dbName=$js["dbName"];
            }catch (PDOException $e){
                echo 'Error Message:'.$e->getMessage() ;
                # Any kind of connection error causes to the db become null
                # Die ?
            }
        }
        return $this::$db;
    }

    #
    public function query($target,$sel){

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

    #Purpose is to connect a db and insert into given table
    public function insertion($target,$vals){

        try{
            $table=$this->getTable();
            $keys=array_keys($table);

            if(in_array($target,$keys)){}
            $sql="INSERT INTO $target$table[$target]
                Values$vals
            ";
            $this->getInstance()->exec($sql);
            echo "insertion is succsesful \n";
        }catch (PDOException $e){
            echo $e->getMessage()."\n";
        }
    }

    private function getTablesInfo(){
        try{
            $sql1="select TABLE_NAME
            from information_schema.tables where TABLE_SCHEMA='exchange_list'
        
            ";
            $querry1=$this->getInstance()->query($sql1)->fetchAll();
            $tables=array();
            foreach ($querry1 as $table) {
                $tableName=$table[0];
                $sql2="select COLUMN_NAME
                from information_schema.columns where TABLE_SCHEMA='$this->dbName' and TABLE_NAME='$tableName';
                ";
                $querry2= $this->getInstance()->query($sql2)->fetchAll();
                $columns="(";
                for ($i=0;$i<sizeof($querry2)-1;$i++){
                    $name=$querry2[$i][0];
                    $columns="$columns$name,";
                }
                $name=$querry2[sizeof($querry2)-1][0];
                $columns="$columns$name)";
                $tables[$tableName]=$columns;
            }

            $this->tables=$tables;
        }catch (PDOException $e){
            echo $e->getMessage()."\n";
        }
    }

    #Returns the connected database's tables and columns
    public function getTable(){
        if($this->tables==null){
            $this->getTablesInfo();
        }
        return $this->tables;
    }
}

/*
$target="dummy(dasdasdasd,asd)";
$val1="EUR/USD";
$val2="asdsfdg";
$vals="('$val1','$val2')";
$asd= new DataBase();
$asd->insertion("parity",$vals);


$sel="*";
$tar="parity";
$asd->query($tar,$sel  );


$as=new DataBase();
print_r($as->getTable());
*/