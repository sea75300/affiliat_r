<?php
    /**
     * Public view
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;
    
    final class view_public extends view {

        public function __construct($viewName = '', $viewPath = '') {
            $viewPath = 'public/'.$viewPath;
            parent::__construct($viewName, $viewPath);            
        }        
        
        /**
         * Erstellt Variablen für View und lädt Datei
         * @see view
         * @return void
         */        
        public function render($isNotUtf8 = false) {
            if(parent::render()) {
                foreach ($this->getViewVars() as $key => $value) { $$key = $value; }
                
                if($this->getReturnRender()) { ob_start(); }
                
                include $this->getViewFile();      
                
                if($this->getReturnRender()) { 
                    $data = ob_get_contents();
                    ob_end_clean();
                    return $data;
                }
            }
        }
    }
?>