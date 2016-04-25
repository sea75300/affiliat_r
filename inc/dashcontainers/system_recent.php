<?php
    /**
     * Dashboard conatiner Recent Affiliates
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    class system_recent implements \interfaces\dashcontainer {
        
        private $dbconnection;
        
        private $systemConfig;
        
        public function __construct($controller) {
            $this->dbconnection = $controller->getDbconnection();
            $this->systemConfig = $controller->getSysconfig();
        }

        public function getBoxContent() {
            $affiliates  = $this->dbconnection->select('affiliates', 'id, pageName, pageUrl, affiliateAddedTime', 'id > 0 ORDER BY affiliateAddedTime DESC LIMIT 0,5'); 

            $boxContent  = "<ul>\n";
            foreach ($affiliates as $affiliateData) {                
                $boxContent .= "<li><a title=\"".\language::returnLanguageConstant('AFFILIATE_AFFILIATEADDEDTIME').": ".date($this->systemConfig->getDateTimeMask(), $affiliateData['affiliateAddedTime'])."\" class=\"afltr-dashboard-label\" href=\"{$affiliateData['pageUrl']}\">{$affiliateData['pageName']}</a>  <a href=\"index.php?module=affiliate/edit&affiliateid={$affiliateData['id']}\">".\language::returnLanguageConstant('EDIT_BTN')."</a></li>\n";
            }
            $boxContent .= "</ul>\n";
            
            return $boxContent;          
        }
        
        public function getBoxHeadline() {
            return \language::returnLanguageConstant('HL_DASHBOARD_RECENT');
        }        
        
        public function getBoxName() {
            return get_class($this);
        }
        
        public function getPosition() {
            return 3;
        }        
        
        public function getSize() {
            return 'small';
        }        
        
        public function getHeight() {
            return 'auto';
        }        
        
    }
