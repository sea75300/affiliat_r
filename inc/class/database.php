<?php
    /**
     * Database class
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    class database {
        
        private $connection;
        
        private $dbprefix;
                
        function __construct() {            
            $dbconfig = base_config::getConfigFile();
            $dns = $dbconfig['DBTYPE'].':dbname='.$dbconfig['DBNAME'].';host='.$dbconfig['DBHOST'];
            try {
                $this->connection = new PDO($dns, $dbconfig['DBUSER'], $dbconfig['DBPASS']);
            } catch(PDOException $e) {
                messages::logError($e->getMessage());
                die('Connection to database failed!');
            }
            
            $this->dbprefix = $dbconfig['DBPREF'];
        }

        /**
         * Gibt PHP PDO Objekt zurück
         * @return PDO
         */
        public function getConnection() {
            return $this->connection;
        }       

        /**
         * Gibt DB Prefix zurück
         * @return string
         */
        public function getDbprefix() {
            return $this->dbprefix;
        }        
        
        /**
         * Gibt ID des zuletzt in DB eingefüten Elementes zurück
         * @return int
         */
        public function getLastInsertId() {
            return $this->connection->lastInsertId();
        }

        /**
         * Führt SELECT-Befehl auf DB aus
         * @param string $table
         * @param string $item
         * @param string $where
         * @param array $params
         * @return mixed
         */
        public function select($table, $item = '*', $where = null, $params = null) {            
            $sql = "SELECT $item FROM {$this->dbprefix}_$table";
            if(!is_null($where)) $sql .= " WHERE $where";
            return $this->query($sql, $params);            
        }
        
        /**
         * Führt INSERT-Befehl auf DB aus
         * @param string $table
         * @param string $fields
         * @param string $values
         * @param array $params
         * @return bool|int
         */
        public function insert($table, $fields, $values, $params = null) {
            $sql = "INSERT INTO {$this->dbprefix}_$table ($fields) VALUES ($values);";
            $this->exec($sql, $params);
            return $this->getLastInsertId();
        }
        
        /**
         * Führt UPDATE-Befehl auf DB aus
         * @param string $table
         * @param array $fields
         * @param array $values
         * @param array $params
         * @param string $where
         * @return bool
         */
        public function update($table, $fields, $values, $params = null, $where = null) {
            $sql = "UPDATE {$this->dbprefix}_$table SET ";            
            $fieldsCount = count($fields);
            foreach ($fields as $field) {
                if($field == 'id') continue;
                $sql .= "$field = ?";
                $fieldsCount--;
                if($fieldsCount > 1) $sql .= ", ";
            }            
            if(!is_null($where)) $sql .= " WHERE $where";
            return $this->exec($sql, $params);            
        }
        
        /**
         * Führt SELECT COUNT-Befehl auf DB aus
         * @param string $table
         * @param string $item
         * @param string $where
         * @param array $params
         * @return int
         */
        public function count($table, $item = '', $where = null, $params = null) {
            $sql = "SELECT count($item) AS counted FROM {$this->dbprefix}_$table";
            if(!is_null($where)) $sql .= " WHERE $where";

            $result = $this->query($sql, $params);	
            $result = $result[0];

            if(isset($result['counted']))
                return $result['counted'];            
            else
                return 0;            
        }
        
        /**
         * Führt DELETE-Befehl auf DB aus
         * @param string $table
         * @param string $where
         * @param array $params
         * @return bool
         */
        public function delete($table, $where = null, $params = null) {
            $sql    = "DELETE FROM {$this->dbprefix}_$table";
            if(!is_null($where)) $sql .= " WHERE $where";           
            return $this->exec($sql, $params);
        }
        
        /**
         * Ändert Tabellenstruktur
         * @param string $table
         * @param string $methode
         * @param string $field
         * @param string $condition
         */
        public function alter($table, $methode, $field, $condition = "") {                       
            $sql = "ALTER TABLE {$this->dbprefix}_$table $methode $field $condition";
            return $this->exec($sql);
        }        
        
        /**
         * Führt SQL Befehl auf DB aus
         * @param string $query
         * @param array $params
         * @return boolean
         */
        public function exec($query, $params = null) {
            if(defined('SQL_DEBUG')) messages::logSystem ($query);
            
            $statement = $this->prepare($query);
            $ret = $statement->execute($params);
            if(!$ret) {
                $this->logError();
                return false;
            }
            return true;
        }
        
        /**
         * Führt SQL-Query Befehl auf DB aus
         * @param string $query
         * @param array $params
         * @return boolean
         */
        public function query($query, $params = null) {
            if(defined('SQL_DEBUG')) messages::logSystem ($query);
            
            $statement = $this->prepare($query);
            if(!$statement->execute($params)) {
                $this->logError();
                return false;
            }
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        
        /**
         * Erzeugt Prepared Statement
         * @param string $query
         * @return PDOStatement
         */
        private function prepare($query) {
            return $this->connection->prepare($query);
        }

        /**
         * Schreibt fehlermeldungen von DB in fehler
         * @return void
         */
        private function logError() {   
            if($this->connection->errorInfo()) return;
            $errorArray = $this->connection->errorInfo();
            messages::logError("FPDB: ".$errorArray[2]);            
        }   

    }
?>