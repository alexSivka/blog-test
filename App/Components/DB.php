<?php

namespace App\Components;
use PDO;

/**
 * singleton database class
 * Class DB
 * @package App\Components
 */
class DB
{
    private static $_instance = null;
    private $dbn = null;

    private function __construct() {}

    /**
     * @return DB class instance
     */
    public static function getInstance() :DB
    {
        if(!self::$_instance) {
            self::$_instance = new self();
            self::$_instance->connect();
        }
        return self::$_instance;
    }

    /**
     * @param string $sql query to execute
     * @return array
     */
    public function query(string $sql) :array
    {
        $stm = $this->dbn->query($sql);
        return $stm->fetchAll();
    }

    /**
     * @return PDO
     */
    public function getPDO() :PDO
    {
        return $this->dbn;
    }

    /**
     * connect to database
     */
    private function connect() :void
    {
        /**
         * @var $config array
         */
        require_once ROOT . '/config.php';

        $dsn = 'mysql:host=' . $config['dbHost'] . ';dbname=' . $config['dbBasename'];

        try {
            $this->dbn = new PDO($dsn, $config['dbUser'], $config['dbPassword']);
        } catch (\PDOException $e) {
            die('db connect error');
        }
    }
}
