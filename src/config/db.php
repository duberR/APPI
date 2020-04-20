<?php
    class db{
        private $dbHost ='localhost';
        private $dbUser ='root';
        private $dbPass ='';
        private $dbName ='appi';

        //conexion

        public function conecctiondb(){
            $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
            $dbConencion = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
            $dbConencion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $dbConencion;
    }
}