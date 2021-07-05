<?php

/**
 * Class that represents database connection
 */
class Database{
    /**
     * PDO object
     *
     * @var PDO
     */
    private $db_handler;
    /**
     * Contains error message if error occurs
     *
     * @var string
     */
    private $error;
    /**
     * Query converted to PDO object
     *
     * @var PDOStatement
     */
    private $statement;

    /**
     * Construct method that establishes connection to database
     */
    public function __construct(){
        $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']}";

        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try{
            $this->db_handler = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $options);
        } catch (PDOException $e){
            $this->error = $e->getMessage();
        }
    }

    /**
     * Prepares query to get executed
     *
     * @param string $query
     */
    public function query($query){
        $this->statement = $this->db_handler->prepare($query);
    }

    /**
     * Binds value to a parameter in prepared SQL-query
     *
     * @param string $param
     * @param mixed $value
     * @param int|null $type
     */
    public function bind($param, $value, $type=null){
        if (is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->statement->bindValue($param, $value, $type);
    }

    /**
     * Executes statement
     */
    public function execute(){
        return $this->statement->execute();
    }

    /**
     * Fetches results as a php objects
     */
    public function results(){
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Fetches result as a php object
     */
    public function result(){
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }
}