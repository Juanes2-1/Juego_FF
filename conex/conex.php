<?php
    class database {
        private $hostname = "localhost";
        private $username = "root";
        private $password = "";
        private $database = "juegoff";
        private $charset =  "utf8mb4";

        function conectar()         
        {
            try{
                $conex = "mysql:host=" . $this->hostname . "; dbname=". $this->database . "; charset=" . $this->charset;
                $op = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                    PDO::ATTR_EMULATE_PREPARES => false, 
                ];

                $PDO = new PDO($conex, $this->username, $this->password, $op);
                return $PDO;
            }

            catch(PDOException $e) {
                echo "Error de conxion: " . $e->getMessage();
                exit;
            }
        }
    }
?>