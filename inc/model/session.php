<?php
    /**
     * Session object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;

    class session implements \interfaces\base {
        
        private $dbconnection;
        
        private $id;

        private $sessionId;

        private $login;
        
        private $logout;
        
        private $ip;
        
        private $sessionExists = false;
        
        private $fields = array('id', 'sessionId', 'login', 'logout', 'ip');
        
        private $tabName = 'logins';
                
        /**
         * 
         * @param \database $dbconnection DB-Verbindung
         * @param string $sessionId Session-ID aus Session-Cookie
         */
        function __construct(\database $dbconnection, $sessionId = null) {
            $this->dbconnection = $dbconnection;            
            if(!is_null($sessionId)) {                
                $this->sessionId = $sessionId;            
                $this->loadData();                
            }
        }              
        
        /**
         * 
         * @return string
         */
        public function getSessionId() {
            return $this->sessionId;
        }

        /**
         * 
         * @return int
         */
        public function getLogin() {
            return $this->login;
        }

        /**
         * 
         * @return int
         */
        public function getLogout() {
            return $this->logout;
        }

        /**
         * 
         * @return string
         */
        public function getIp() {
            return $this->ip;
        }

        /**
         * 
         * @param string $sessionId
         */
        public function setSessionId($sessionId) {
            $this->sessionId = $sessionId;
        }

        /**
         * 
         * @param int $login
         */
        public function setLogin($login) {
            $this->login = $login;
        }

        /**
         * 
         * @param int $login
         */
        public function setLogout($logout) {
            $this->logout = $logout;
        }

        /**
         * 
         * @param string $ip
         */
        public function setIp($ip) {
            $this->ip = $ip;
        }
        
        /**
         * 
         * @return bool
         */
        public function exists() {
            return $this->sessionExists;
        }        
        
        /**
         * Speichert
         * @return void
         */
        public function save() {
            $values = array('?', '?', '?', '?', '?');            
            $params = array (NULL, $this->getSessionId(), $this->getLogin(), $this->getLogout(), $this->getIp());
            $this->dbconnection->insert($this->tabName, implode(',', $this->fields), implode(',', $values), $params);
            
            $this->loadData();            
        }
        
        /**
         * Aktualisiert
         * @return void
         */
        public function update() {
            $values = array('?', '?', '?', '?');            
            $params = array ($this->getSessionId(), $this->getLogin(), $this->getLogout(), $this->getIp());
            $where  = "sessionId LIKE '{$this->sessionId}'";
            $this->dbconnection->update($this->tabName, $this->fields, $values, $params, $where);
        }

        /**
         * 
         * @return void
         */
        public function delete() {
            return;
        }
        
        /**
         * Lädt Daten
         * @return void
         */
        private function loadData() {               
            $count = $this->dbconnection->count($this->tabName, 'id', "sessionId LIKE '{$this->sessionId}'");
            if($count == 0) return;   
            
            $logins = $this->dbconnection->select($this->tabName, implode(',', $this->fields), "sessionId LIKE '{$this->sessionId}'");
            if($logins === false) return;
            $logins = $logins[0];
            foreach ($logins as $key => $value) { $this->$key = $value; }
            $this->sessionExists = true;                
                     
        }
        
    }
?>