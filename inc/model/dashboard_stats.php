<?php
    /**
     * Dashboard stats object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;

    class dashboard_stats implements \interfaces\base {
        
        private $dbconnection;
        
        private $affiliateCountTotal = 0;
        
        private $affiliateCountAccpted = 0;
        
        private $affiliateCountNotAccepted = 0;
        
        private $categoryCount = 0;
        
        private $filesCount = 0;
        
        private $uploadSize = 0;

        private $affiliateTab = 'affiliates';
        
        private $categoryTab  = 'categories';

        /**
         * 
         * @param \database $dbconnection DB-Verbindung
         */
        public function __construct(\database $dbconnection) {
            $this->dbconnection = $dbconnection;
            $this->loadData();
        }

        /**
         * 
         * @return int
         */
        public function getAffiliateCountTotal() {
            return $this->affiliateCountTotal;
        }

        /**
         * 
         * @return int
         */
        public function getAffiliateCountAccpted() {
            return $this->affiliateCountAccpted;
        }

        /**
         * 
         * @return int
         */
        public function getAffiliateCountNotAccepted() {
            return $this->affiliateCountNotAccepted;
        }

        /**
         * 
         * @return int
         */
        public function getCategoryCount() {
            return $this->categoryCount;
        }

        /**
         * 
         * @return int
         */
        public function getFilesCount() {
            return $this->filesCount;
        }

        /**
         * 
         * @return int
         */
        public function getUploadSize() {
            return $this->uploadSize;
        }        
                
        /**
         * Lädt Daten
         * @return void
         */
        private function loadData() {
            $this->affiliateCountTotal       = $this->dbconnection->count($this->affiliateTab,'id');
            $this->affiliateCountAccpted     = $this->dbconnection->count($this->affiliateTab,'id', 'affiliateIsAccpted = 1');
            $this->affiliateCountNotAccepted = $this->dbconnection->count($this->affiliateTab,'id', 'affiliateIsAccpted = 0');
            $this->categoryCount             = $this->dbconnection->count($this->categoryTab, 'id');            
            
            $uploadDir = opendir(\base_config::$uploadDir);
            while($uploadFile = @readdir($uploadDir)) {
                if($uploadFile == 'index.html' || $uploadFile == '.' || $uploadFile == '..') { continue; }
                $this->filesCount++;
                $this->uploadSize += filesize(\base_config::$uploadDir.$uploadFile);                
            }            
            
            if($this->uploadSize / 1024 / 1024 / 1024 > 1) {
                $this->uploadSize = round(($this->uploadSize / 1024 / 1024 / 1),2).' GB';
            } elseif($this->uploadSize / 1024 / 1024 > 1) {
                $this->uploadSize = round(($this->uploadSize / 1024 / 1024),2).' MB';
            } else {
                $this->uploadSize = round(($this->uploadSize / 1024),2).' KB';
            }            
        }
        
        /**
         * 
         * @return void
         */
        public function save()   { return; }
        
        /**
         * 
         * @return void
         */        
        public function delete() { return; }
        
        /**
         * 
         * @return void
         */        
        public function update() { return; }

    }
?>