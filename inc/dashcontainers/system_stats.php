<?php
    /**
     * Dashboard conatiner System Stats
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    class system_stats implements \interfaces\dashcontainer {
        
        private $dbconnection;
        
        public function __construct($controller) {
            $this->dbconnection = $controller->getDbconnection();
        }

        public function getBoxContent() {
            $stats = new \model\dashboard_stats($this->dbconnection);
            
            $boxContent  = "<ul>";
            $boxContent .= "<li><span class=\"afltr-dashboard-label\">".\language::returnLanguageConstant('HL_DASHBOARD_STATS_AFFILIATESCOUNT').'</span>: <span class="afltr-dashboard-value-text">'.$stats->getAffiliateCountTotal()."</span></li>";
            $boxContent .= "<li><span class=\"afltr-dashboard-label\">".\language::returnLanguageConstant('HL_DASHBOARD_STATS_AFFILIATESACCEPTED').'</span>: <span class="afltr-dashboard-value-text">'.$stats->getAffiliateCountAccpted()."</span></li>";
            $boxContent .= "<li><span class=\"afltr-dashboard-label\">".\language::returnLanguageConstant('HL_DASHBOARD_STATS_AFFILIATESNOTACCEPTED').'</span>: <span class="afltr-dashboard-value-text">'.$stats->getAffiliateCountNotAccepted()."</span></li>";
            $boxContent .= "<li><span class=\"afltr-dashboard-label\">".\language::returnLanguageConstant('HL_DASHBOARD_STATS_CATEGORYCOUNT').'</span>: <span class="afltr-dashboard-value-text">'.$stats->getCategoryCount()."</span></li>";            
            $boxContent .= "<li><span class=\"afltr-dashboard-label\">".\language::returnLanguageConstant('HL_DASHBOARD_STATS_FILESUPLOADCOUNT').'</span>: <span class="afltr-dashboard-value-text">'.$stats->getFilesCount()."</span></li>";
            $boxContent .= "<li><span class=\"afltr-dashboard-label\">".\language::returnLanguageConstant('HL_DASHBOARD_STATS_FILESUPLOADSIZE').'</span>: <span class="afltr-dashboard-value-text">'.$stats->getUploadSize()."</span></li>";
            $boxContent .= "</ul>";
            
            return $boxContent;            
        }
        
        public function getBoxHeadline() {
            return \language::returnLanguageConstant('HL_DASHBOARD_STATS');
        }        
        
        public function getBoxName() {
            return get_class($this);
        }
        
        public function getPosition() {
            return 1;
        }        
        
        public function getSize() {
            return 'small';
        } 
        
        public function getHeight() {
            return null;
        }        
        
    }
