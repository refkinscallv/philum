<?php

    namespace Philum\Database;

    use Exception;
    use PDO;
    use PDOException;
    use mysqli;

    class Database {

        /**
         * @var string $status
         */
        private string $status;

        /**
         * @var string $host
         */
        private string $host;

        /**
         * @var string $user
         */
        private string $user;

        /**
         * @var string $pass
         */
        private string $pass;

        /**
         * @var string $name
         */
        private string $name;
        
        /**
         * @var string $driver
         */
        private string $driver;

        /**
         * @var int $port
         */
        private int $port;

        public function __construct() {
            $this->status = $_SERVER["DB_STATUS"];
            $this->host = $_SERVER["DB_HOST"];
            $this->user = $_SERVER["DB_USER"];
            $this->pass = $_SERVER["DB_PASS"];
            $this->name = $_SERVER["DB_NAME"];
            $this->driver = $_SERVER["DB_DRIVER"];
            $this->port = $_SERVER["DB_PORT"];
        }

        /**
         * Establishes a database connection based on the driver specified.
         *
         * @return mixed A connection object (mysqli for MySQLi, PDO for PostgreSQL)
         * @throws Exception If the database driver is invalid
         */
        public function connection() {
            if($this->status){
                switch($this->driver) {
                    case "MySQLi": 
                        return $this->mysqliConnection();
                    case "Postgre": 
                        return $this->postgreConnection();
                    default: 
                        throw new Exception("Invalid database driver");
                }
            }
        }

        /**
         * Establishes a MySQLi database connection.
         *
         * @return mysqli MySQLi connection object
         * @throws Exception If the connection fails
         */
        private function mysqliConnection() {
            try {
                $mysqli = new mysqli($this->host, $this->user, $this->pass, $this->name);

                if ($mysqli->connect_error) {
                    throw new Exception("MySQLi connection failed: " . $mysqli->connect_error);
                }
                
                return $mysqli;
            } catch (Exception $e) {
                echo $e->getMessage();
                throw $e;
            }
        }
        
        /**
         * Establishes a PostgreSQL database connection using PDO.
         *
         * @return PDO PostgreSQL connection object
         * @throws PDOException If the connection fails
         */
        // private function postgreConnection() {
        //     try {
        //         $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->name};user={$this->user};password={$this->pass}";
        //         $pdo = new PDO($dsn);

        //         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //         return $pdo;
        //     } catch (PDOException $e) {
        //         echo "PostgreSQL connection failed: " . $e->getMessage();
        //         throw $e;
        //     }
        // }

    }