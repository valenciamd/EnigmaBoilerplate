<?php
/*******************************************************************************
 * DATABASE CLASS
 ******************************************************************************/

class Database{
    private $dsn        = DB_DSN;                                               // PDO Connection String
    private $host       = DB_HOST;                                              // PDO Connection Host
    private $user       = DB_USER;                                              // PDO Connection Username
    private $pass       = DB_PASS;                                              // PDO Connection Password
    private $name       = DB_NAME;                                              // PDO Connection Database Name
    private $options    = array(                                                // PDO Connection Options
        PDO::ATTR_PERSISTENT => TRUE,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );                                         
    
    private $dbh;                                                               // Database Handler
    private $error;                                                             // Error Handler
    
    private $stmt;                                                              // Query String
    
    private $dataCache = array();
    public $queryCache = array();
    
    public function __construct() {
        $this->connect();
    }
    
    public function connect(){
        try{
            $this->dbh = new PDO($this->dsn, $this->user, $this->pass, $this->options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
        }            
    }
    
    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }
    
    public function cacheQuery(){
        if(!$result = $this->resultset()):
            $this->error = new Error('Database Query', 'No Results');
            return false;
        else:
            $this->queryCache[] = $result;
            return count($this->queryCache)-1;
        endif;
    }
    
    public function numRowsFromCache($cacheId){
        return count($this->queryCache[$cacheId]);
    }
    
    public function resultsFromCache($cacheId){
        if($this->queryCache[$cacheId]):
            return $this->queryCache[$cacheId];
        else:
            return false;
        endif;
    }
    
    public function cacheData($data){
        $this->dataCache[] = $data;
        return count($this->dataCache)-1;
    }
    
    public function dataFromCache($cacheId){
        return $this->dataCache[$cacheId];
    }
    
    public function bind($param, $value, $type = null){
        if(is_null($type)):
            switch(TRUE):
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                    
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                
                default:
                    $type = PDO::PARAM_STR;
            endswitch;
        endif;
        
        $this->stmt->bindValue($param, $value, $type);
    }
    
    public function execute(){
        return $this->stmt->execute();
    }
    
    public function resultset(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function result(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function count(){
        return $this->stmt->rowCount();
    }
    
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }
    
    public function beginTransaction(){
        return $this->dbh->beginTransaction();
    }
    
    public function endTransaction(){
        return $this->dbh->commit();
    }
    
    public function cancelTransaction(){
        return $this->dbh->rollBack();
    }
    
    public function debug_DumpParams(){
        return $this->stmt->debugDumpParams();
    }
}
?>
