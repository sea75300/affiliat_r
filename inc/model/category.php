<?php
    /**
     * Category object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;

    class category implements \interfaces\base {
        
        private $dbconnection;
        
        private $id;

        private $name;
        
        private $iconPath;
        
        private $isPrivate;

        private $fields    = array('id', 'name', 'iconPath', 'isPrivate');
        
        private $tabName   = 'categories';                

        /**
         * 
         * @param \database $dbconnection DB-Verbindung
         * @param int $id Kategorie-ID
         */
        public function __construct(\database $dbconnection, $id = null) {
            $this->dbconnection = $dbconnection;
            if(!is_null($id)) {
                $this->id = $id;
                $this->loadData();                
            }
        }

        /**
         * 
         * @return int
         */
        public function getId() {
            return $this->id;
        }

        /**
         * 
         * @return string
         */
        public function getName() {
            return $this->name;
        }

        /**
         * 
         * @return string
         */
        public function getIconPath() {
            if(empty($this->iconPath)) return '';
            
            $iconPath = (strpos($this->iconPath, 'http') !== false) ? $this->iconPath : \base_config::$rootPath.'/'.basename(\base_config::$uploadDir).'/'.$this->iconPath;            
            return $iconPath;            
        }

        /**
         * 
         * @param int $id
         */
        public function setId($id) {
            $this->id = $id;
        }

        /**
         * 
         * @param string $name
         */
        public function setName($name) {
            $this->name = $name;
        }

        /**
         * 
         * @param string $iconPath
         */
        public function setIconPath($iconPath) {
            $this->iconPath = $iconPath;
        }       

        /**
         * 
         * @return bool
         */
        public function isPrivate() {
            return $this->isPrivate;
        }

        /**
         * 
         * @param bool $isPrivate
         */
        public function setIsPrivate($isPrivate) {
            $this->isPrivate = $isPrivate;
        }        
        
        /**
         * Ließt Daten ein
         * @return void
         */
        private function loadData() {
            $data = $this->dbconnection->select($this->tabName, implode(',', $this->fields), "id = {$this->id}");
            if($data === false) return;
            $data = $data[0];
            foreach ($data as $key => $value) { $this->$key = $value; }            
        }
        
        /**
         * Speichert
         * @return boolean
         */
        public function save() {
            if(empty($this->name)) return false;
            
            $values = array('?', '?', '?', '?');            
            $params = array(NULL,
                            $this->getName(),
                            \tools::removeUploadPath($this->getIconPath()),
                            $this->isPrivate());
            $this->id = $this->dbconnection->insert($this->tabName, implode(', ', $this->fields), implode(', ', $values), $params);            
            $this->loadData();
            if($this->id > 0) return true;            
            return false;
        }
        
        /**
         * Löscht
         * @return bool
         */
        public function delete() {
            return $this->dbconnection->delete($this->tabName, "id = {$this->id}");
        }
        
        /**
         * Aktualisiert
         * @return bool
         */
        public function update() {
            $values = array('?', '?', '?');
            $params = array($this->getName(),
                            \tools::removeUploadPath($this->getIconPath()),
                            $this->isPrivate());
            $where  = "id = {$this->id}";
            return $this->dbconnection->update($this->tabName, $this->fields, $values, $params, $where);
        }        


    }
?>