<?php
    /**
     * Affiliate object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;

    class affiliate implements \interfaces\base {

        private $dbconnection;

        private $id;

        private $pageName;

        private $pageUrl;

        private $pageAdminName;

        private $pageAdminEmail;

        private $pageButton;

        private $affiliateCategory;

        private $affiliateAddedTime;

        private $affiliateEditedTime;

        private $affiliateIsMarked;

        private $affiliateIsAccpted;
        
        private $linkTarget = '';

        private $fields = array('id', 'pageName', 'pageUrl', 'pageAdminName', 'pageAdminEmail', 'pageButton',
                                'affiliateCategory', 'affiliateAddedTime', 'affiliateEditedTime', 'affiliateIsMarked', 'affiliateIsAccpted');

        private $tabName = 'affiliates';

        /**
         *
         * @param \database $dbconnection DB-Verbindung
         * @param int $id Affiliate-ID
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
        public function getPageName() {
            return $this->pageName;
        }

        /**
         *
         * @return string
         */
        public function getPageUrl() {
            if((strpos($this->pageUrl, 'http') === false)) return 'http://'.$this->pageUrl;            
            
            return $this->pageUrl;
        }

        /**
         *
         * @return string
         */
        public function getPageAdminName() {
            return $this->pageAdminName;
        }

        /**
         *
         * @return string
         */
        public function getPageAdminEmail() {
            return $this->pageAdminEmail;
        }

        /**
         *
         * @return string
         */
        public function getPageButton() {
            if(empty($this->pageButton)) return '';

            $pageButton = (strpos($this->pageButton, 'http') !== false) ? $this->pageButton : \base_config::$rootPath.'/'.basename(\base_config::$uploadDir).'/'.$this->pageButton;
            return $pageButton;
        }

        /**
         *
         * @return string
         */
        public function getAffiliateCategory() {
            return $this->affiliateCategory;
        }

        /**
         *
         * @return int
         */
        public function getAffiliateAddedTime() {
            return $this->affiliateAddedTime;
        }

        /**
         *
         * @return int
         */
        public function getAffiliateEditedTime() {
            if($this->affiliateEditedTime == 0) return $this->affiliateAddedTime;
            return $this->affiliateEditedTime;
        }

        /**
         *
         * @return bool
         */
        public function affiliateIsMarked() {
            return $this->affiliateIsMarked;
        }

        /**
         *
         * @return bool
         */
        public function affiliateIsAccpted() {
            return $this->affiliateIsAccpted;
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
         * @param string $pageName
         */
        public function setPageName($pageName) {
            $this->pageName = $pageName;
        }

        /**
         * 
         * @param string $pageUrl
         */
        public function setPageUrl($pageUrl) {
            $this->pageUrl = $pageUrl;
        }

        /**
         * 
         * @param string $pageAdminName
         */
        public function setPageAdminName($pageAdminName) {
            $this->pageAdminName = $pageAdminName;
        }

        /**
         * 
         * @param string $pageAdminEmail#
         */
        public function setPageAdminEmail($pageAdminEmail) {
            $this->pageAdminEmail = $pageAdminEmail;
        }

        /**
         * 
         * @param string $pageButton
         */
        public function setPageButton($pageButton) {
            $this->pageButton = $pageButton;
        }

        /**
         * 
         * @param string $affiliateCategory#
         */
        public function setAffiliateCategory($affiliateCategory) {
            $this->affiliateCategory = $affiliateCategory;
        }

        /**
         * 
         * @param int $affiliateAddedTime
         */
        public function setAffiliateAddedTime($affiliateAddedTime) {
            $this->affiliateAddedTime = $affiliateAddedTime;
        }

        /**
         * 
         * @param string  $affiliateEditedTime
         */
        public function setAffiliateEditedTime($affiliateEditedTime) {
            $this->affiliateEditedTime = $affiliateEditedTime;
        }

        /**
         * 
         * @param string  $affiliateIsMarked
         */
        public function setAffiliateIsMarked($affiliateIsMarked) {
            $this->affiliateIsMarked = $affiliateIsMarked;
        }

        /**
         * 
         * @param string $affiliateIsAccpted
         */
        public function setAffiliateIsAccpted($affiliateIsAccpted) {
            $this->affiliateIsAccpted = $affiliateIsAccpted;
        }

        /**
         * 
         * @param string $linkTarget
         */
        public function setLinkTarget($linkTarget) {
            $this->linkTarget = $linkTarget;
        }
                
        /**
         * Ließt Daten ein
         * @return void
         */
        private function loadData() {
            $affiliate = $this->dbconnection->select($this->tabName, implode(',', $this->fields), "id = {$this->id}");
            if($affiliate === false) return;
            $affiliate = $affiliate[0];
            foreach ($affiliate as $key => $value) $this->$key = $value;
        }

        /**
         * Speichert
         * @return boolean
         */
        public function save() {
            if(empty($this->pageName) || empty($this->pageUrl) || empty($this->pageAdminName) || empty($this->pageAdminEmail) || empty($this->affiliateCategory)) return false;

            $values = array('?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?');
            $params = array(NULL,
                            $this->getPageName(),
                            $this->getPageUrl(),
                            $this->getPageAdminName(),
                            $this->getPageAdminEmail(),
                            \tools::removeUploadPath($this->getPageButton()),
                            $this->getAffiliateCategory(),
                            $this->getAffiliateAddedTime(),
                            $this->getAffiliateEditedTime(),
                            $this->affiliateIsMarked(),
                            $this->affiliateIsAccpted());
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
            $values = array('?', '?', '?', '?', '?', '?', '?', '?', '?', '?');
            $params = array($this->getPageName(),
                            $this->getPageUrl(),
                            $this->getPageAdminName(),
                            $this->getPageAdminEmail(),
                            \tools::removeUploadPath($this->getPageButton()),
                            $this->getAffiliateCategory(),
                            $this->getAffiliateAddedTime(),
                            $this->getAffiliateEditedTime(),
                            $this->affiliateIsMarked(),
                            $this->affiliateIsAccpted());
            $where  = "id = {$this->id}";
            return $this->dbconnection->update($this->tabName, $this->fields, $values, $params, $where);
        }

        /**
         * Affiliate-Objekt via print/echo ausgeben
         * @return string
         */
        public function __toString() {
            $output  = "";
            $output  .= "<a class=\"afltr-link\" href=\"{$this->getPageUrl()}\" {$this->linkTarget}>";
            if(!empty($this->pageButton)) {
                $output .= "<img src=\"{$this->getPageButton()}\" alt=\"{$this->getPageName()}\" title=\"{$this->getPageName()}\">";
            } else {
                $output .= "{$this->getPageName()}";
            }            
            $output .= "</a>";
            return $output;
        }


    }
?>