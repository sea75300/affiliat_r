<?php
    /**
     * Category list object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;

    class category_list implements \interfaces\base {
        
        private $dbconnection;
        
        private $showPrivate = true;

        private $categories  = array();

        private $categoryTab = 'categories';
        
        /**
         * 
         * @param \database $dbconnection DB-Verbindung
         */
        public function __construct(\database $dbconnection, $showPrivate = true) {
            $this->dbconnection = $dbconnection;     
            $this->showPrivate  = $showPrivate;
            $this->loadData();
        }

        /**
         * Gibt Kategorien zurück
         * @return array
         */
        public function getCategories() {
            return $this->categories;
        }    
        
        /**
         * 
         * @return void
         */
        public function save() {
            return;
        }
        
        /**
         * 
         * @return void
         */
        public function delete() {
            return;
        }
        
        /**
         * 
         * @return void
         */
        public function update() {
            return;
        }
        
        /**
         * Ließt Daten ein
         * @return void
         */
        private function loadData() {            
            $where = ($this->showPrivate) ? 'isPrivate = 0 OR isPrivate = 1' : 'isPrivate = 0';            
            $categories = $this->dbconnection->select($this->categoryTab, 'id, name, iconPath, isPrivate', $where);
            
            if($categories === false) return;
            foreach ($categories as $categoryData) {                
                $category = new \model\category($this->dbconnection);
                $category->setId($categoryData['id']);
                $category->setName($categoryData['name']);
                $category->setIconPath($categoryData['iconPath']);
                $category->setIsPrivate($categoryData['isPrivate']);
                
                $this->categories[$categoryData['id']] = $category;
            }
        }        
    }
?>