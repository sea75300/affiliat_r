<?php
    /**
     * Affiliate list object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;

    class affiliate_list implements \interfaces\base {
        
        private $dbconnection;
        
        private $categoryId;
        
        private $affiliates   = array();
        
        private $acceptedOnly;

        private $textOnly;
        
        private $groupByCategory;

        private $affiliateTab = 'affiliates';
        
        /**
         * Construktur
         * @param \database $dbconnection DB-Verbindung
         * @param int $categoryId Kategorie
         * @param bool $acceptedOnly Nur akzeptierte Affiliates
         * @param int $textOnly Nur Affiliates ohne Button
         */
        public function __construct(\database $dbconnection, $categoryId = null, $acceptedOnly = false, $textOnly = 0) {
            $this->dbconnection    = $dbconnection;            
            $this->categoryId      = $categoryId;
            $this->acceptedOnly    = $acceptedOnly;
            $this->textOnly        = $textOnly;
            $this->groupByCategory = false;
            $this->loadData();
        }

        /**
         * Gibt Array mit Affiliates aus
         * @return array
         */
        public function getAffiliates() {
            return $this->affiliates;
        }
        
        /**
         * Sagt, dass Affiliates gruppiert werden sollen
         * @param bool $grouped
         */
        public function setGroupByCategory($groupByCategory) {
            $this->groupByCategory = $groupByCategory;
            $this->loadData();
        }
        
        /**
         * Liefert IDs von Affiliates mit übergebenen 
         * @param array $emailList
         * @return array
         */
        public function getAffiliateIdsByEmail($emailList) {
            $where  = "pageAdminEmail LIKE ?";
            $params = array();
            
            $itemCount = count($emailList);            
            if($itemCount > 0) {
                for ($i=0;$i<$itemCount; $i++) { $params[] = ''; }
                $where .= implode(" OR pageAdminEmail LIKE ?", $params);                
            }

            return $this->dbconnection->select($this->affiliateTab, 'id', $where, $emailList);
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
            if($this->groupByCategory) {
                $this->affiliates = array();
                
                $categoryList = new category_list($this->dbconnection);
                $categoryList = $categoryList->getCategories();
                
                foreach ($categoryList as $category) {
                    $affiliates = new affiliate_list($this->dbconnection, $category->getId());
                    $this->affiliates[$category->getName()] = $affiliates->getAffiliates();
                }
            } else {
                $where = (!is_null($this->categoryId)) ? "affiliateCategory = {$this->categoryId} ORDER BY id ASC" : null;
                $affiliateIds = $this->dbconnection->select($this->affiliateTab, 'id', $where);            
                if($affiliateIds === false) return;
                foreach ($affiliateIds as $affiliateId) {                
                    $affiliateId = $affiliateId['id'];

                    $affiliate = new \model\affiliate($this->dbconnection, $affiliateId);
                    $category = new \model\category($this->dbconnection, $affiliate->getAffiliateCategory());
                    $affiliate->setAffiliateCategory($category->getName());

                    if($this->exclude($affiliate)) continue;

                    $this->affiliates[$affiliateId] = $affiliate;
                }                
            }           
        }

        /**
         * Prüft Ausschlusskriterium von Affiliates
         * @param affiliate $affiliate
         * @return boolean
         */
        private function exclude($affiliate) {
            
            $pageButton = $affiliate->getPageButton();
            
            if($this->acceptedOnly && !$affiliate->affiliateIsAccpted())     return true;
            if($this->textOnly == 1 && empty($pageButton))   return true;
            if($this->textOnly == 2 && !empty($pageButton))  return true;

            return false;
        }
        
    }
?>