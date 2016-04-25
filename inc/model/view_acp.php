<?php
    /**
     * ACP view
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;
    
    final class view_acp extends view {

        /**
         * @see view
         */
        public function __construct($viewName = '', $viewPath = '') {
            $viewPath = 'acp/'.$viewPath;            
            parent::__construct($viewName, $viewPath);
        }
        
        /**
         * Lädt Datei, fügt View-Element, Header & Footer zusammen und erstellt Variablen für View
         * @see view
         * @return void
         */
        public function render() {            
            if(parent::render()) {
                
                $this->setDefaultCssFiles();
                $this->setDefaultJsFiles();
                
                $systemVersion = static::$version;

                $relroot = '';                
                include_once \base_config::$baseDir.'/style/header.php';

                foreach ($this->getViewVars() as $key => $value) { $$key = $value; }
                include_once $this->getViewFile();                
                
                include_once \base_config::$baseDir.'/style/footer.php';                
            }
        }
    }
?>