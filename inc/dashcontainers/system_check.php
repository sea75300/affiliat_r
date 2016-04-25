<?php
    /**
     * Dashboard conatiner System Check
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    class system_check implements \interfaces\dashcontainer {

        public function getBoxContent() {
            $boxContent  = "<ul>";
            
            $boxContent  .= "<li><span class=\"afltr-dashboard-label\">".\language::returnLanguageConstant('HL_DASHBOARD_STATUS_ISWRITABLE_UPLOAD').'</span>: <span class="afltr-dashboard-value-text">'.$this->boolToText(is_writable(\base_config::$uploadDir))."</span></li>";
            $boxContent  .= "<li><span class=\"afltr-dashboard-label\">".\language::returnLanguageConstant('HL_DASHBOARD_STATUS_ISWRITABLE_LOGFILE').'</span>: <span class="afltr-dashboard-value-text">'.$this->boolToText(is_writable(\base_config::$baseDir.'/logs/'))."</span></li>";
            $boxContent  .= "<li><span class=\"afltr-dashboard-label\">".\language::returnLanguageConstant('HL_DASHBOARD_STATUS_ISWRITABLE_UPGRADE').'</span>: <span class="afltr-dashboard-value-text">'.$this->boolToText(is_writable(\base_config::$updateFolder))."</span></li>";
            $boxContent  .= "<li><span class=\"afltr-dashboard-label\">".\language::returnLanguageConstant('HL_DASHBOARD_STATUS_ISWRITABLE_CACHE').'</span>: <span class="afltr-dashboard-value-text">'.$this->boolToText(is_writable(\base_config::$cacheFolder))."</span></li>";
            
            return $boxContent;          
        }
        
        public function getBoxHeadline() {
            return \language::returnLanguageConstant('HL_DASHBOARD_STATUS');
        }        
        
        public function getBoxName() {
            return get_class($this);
        }
        
        public function getPosition() {
            return 2;
        }
        
        public function getSize() {
            return 'small';
        }
        
        public function getHeight() {
            return null;
        }

        private function boolToText($value) {
            $output = ($value == 1 || $value == true) ? '<span class="afltr-bool-to-text-icon ui-icon ui-icon-check" title="'.language::returnLanguageConstant('YES_VALUE', null).'"></span>' : '<span class="afltr-bool-to-text-icon ui-icon ui-icon-closethick" title="'.language::returnLanguageConstant('NO_VALUE', null).'"></span>';
            return $output;
        }        
        
    }
