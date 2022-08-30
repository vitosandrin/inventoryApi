<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database
{
    /**
     * Host de conexão com o banco de dados
     * @var string
     */
    private static $host;

    /**
     * Nome do banco de dados
     * @var string
     */
    private static $name;

    /**
     * Usuário do banco
     * @var string
     */
    private static $user;

    /**
     * Senha de acesso ao banco de dados
     * @var string
     */
    private static $pass;

    /**
     * Porta de acesso ao banco
     * @var integer
     */
    private static $port;

    /**
     * Driver do SQLServer
     * @var integer
     */
    private static $driver;

    /**
     * Instancia de conexão com o banco de dados
     * @var PDO
     */
    private $connection;
    
    /**
     * Nome da tabela a ser manipulada  
     * @var string
     */
    private $table;

    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsável por configurar a classe
     * @param  string  $host
     * @param  string  $name
     * @param  string  $user
     * @param  string  $pass
     * @param  string  $driver
     * @param  integer $port
     */
    public static function config($host, $name, $user, $pass, $port, $driver)
    {
        self::$host = $host;
        self::$name = $name;
        self::$user = $user;
        self::$pass = $pass;
        self::$port = $port;
        self::$driver = $driver;
    }

    private function setConnection()
    {
        $pdoConfig = self::$driver . ":" . "Server=" . self::$host . ";";
        $pdoConfig .= "Database=" . self::$name . ";";

        try {
            if (!isset($conn)) {
                $this->connection = new PDO($pdoConfig, self::$user, self::$pass);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        } catch (PDOException $e) {
            die("ERROR: ".$e->getMessage());
        }
    }

    /**
     * Método responsável por executar queries dentro do banco de dados
     * @param string $query
     * @param array $params
     * @return PDOStatement
     */
    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }
    /**
     * Método responsável por executar uma consulta no BD
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        //DADOS DA QUERY
        $where = strlen($where)? 'WHERE '.$where : ' ';
        $where = strlen($order)? 'ORDER BY '.$order : ' ';
        $where = strlen($limit)? 'WHERE '.$limit : ' ';
        //MONTA A QUERY
        $query = 'SELECT'.$fields.'FROM '. $this->table.' '.$where.' '.$order.' '.$limit;
        //EXECUTA A QUERY
        return $this->execute($query);
    }
}
