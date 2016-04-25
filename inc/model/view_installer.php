<?php
    /**
     * Installer view
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    namespace model;
    
    final class view_installer extends view {

        /**
         * @see view
         */
        public function __construct($viewName = '', $viewPath = '') {
            $viewPath = 'installer/'.$viewPath;            
            parent::__construct($viewName, $viewPath);
        }
        
        /**
         * Lädt Datei, fügt View-Element, Header & Footer zusammen und erstellt Variablen für View
         * @see view
         * @return void
         */
        public function render() {            
            $this->setViewFile($this->getViewPath().$this->getViewName());
            
            $this->setDefaultCssFiles();
            $this->setDefaultJsFiles();
            
            if(!file_exists($this->getViewFile())) {
                $notFoundMessage = str_replace('{{viewname}}', $this->viewName, \language::returnLanguageConstant('VIEW_NOT_FOUND'));
                \messages::logError($notFoundMessage);
                die($notFoundMessage);
                return;
            }            
            
            include \base_config::$baseDir.'/version.php';
            
            $systemVersion = $afltrVersion;

            $relroot = (defined('INSTALL_MODE')) ? str_replace('install', '', \base_config::$rootPath) : '';
            $title   = (defined('INSTALL_MODE')) ? \language::returnLanguageConstant('INSTALLER') : \language::returnLanguageConstant('UPDATER');
            include_once \base_config::$baseDir.'/style/header.php';

            foreach ($this->getViewVars() as $key => $value) { $$key = $value; }
            include_once $this->getViewFile();                

            include_once \base_config::$baseDir.'/style/footer.php';                
        }
        
        /**
         * Lädt Affiliat*r-Interne CSS-Dateien
         */
        protected function setDefaultCssFiles() {
            $this->setViewCssFiles(array(
                'style/style.css',
                'inc/lib/jquery-ui/jquery-ui.min.css'
            ));
        }
  
        /**
         * Lädt Affiliat*r-Interne JavaScript-Dateien
         */        
        protected function setDefaultJsFiles() {
            $this->setViewJsFiles(array(
                'inc/lib/jquery/jquery.min.js',
                'inc/lib/jquery-ui/jquery-ui.min.js',
                'inc/lib/imagelightbox/imagelightbox.min.js',
                'js/common.js'
            ));
        }          
    }
?>