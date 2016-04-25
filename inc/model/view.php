<?php
    /**
     * View
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;
    
    class view {
        
        public static $version;
        
        private $viewPath;
        
        private $viewName;
        
        private $viewFile;

        private $viewVars = array();
        
        private $viewJsFiles = array();
        
        private $viewCssFiles = array();

        private $returnRender;
        
        /**
         * 
         * @param string $viewName Name der View, ohne Endung .php
         * @param string $viewPath Unterpfad in /view/acp bzw. /view/public-Ordner
         */
        function __construct($viewName = '', $viewPath = '') {
            $this->viewPath = \base_config::$baseDir.'/views/'.$viewPath;
            if(!empty($viewName)) $this->viewName = $viewName.'.php';
        }

        /**
         * 
         * @return string
         */
        public function getViewPath() {
            return $this->viewPath;
        }

        /**
         * 
         * @return string
         */
        public function getViewName() {
            return $this->viewName;
        }

        /**
         * 
         * @param string $viewPath
         */
        public function setViewPath($viewPath) {
            $this->viewPath = \base_config::$baseDir.'/views/'.$viewPath;
        }

        /**
         * 
         * @param string $viewName
         */
        public function setViewName($viewName) {
            $this->viewName = $viewName.'php';
        }

        /**
         * 
         * @return string
         */
        public function getViewFile() {
            return $this->viewFile;
        }

        /**
         * 
         * @return string
         */
        public function getViewVars() {
            return $this->viewVars;
        }

       /**
        * 
        * @param string $viewFile
        */
        public function setViewFile($viewFile) {
            $this->viewFile = $viewFile;
        }

        /**
         * 
         * @param array $viewVars
         */
        public function setViewVars(array $viewVars) {
            $this->viewVars = $viewVars;
        }

        /**
         * 
         * @return bool
         */
        public function getReturnRender() {
            return $this->returnRender;
        }
        
        /**
         * 
         * @param bool $returnRender
         */
        public function setReturnRender($returnRender) {
            $this->returnRender = $returnRender;
        }                        
        
        /**
         * 
         * @return array
         */
        public function getViewJsFiles() {
            return $this->viewJsFiles;
        }

        /**
         * 
         * @param string $viewJsFiles
         */
        public function setViewJsFiles(array $viewJsFiles) {
            $this->viewJsFiles = array_merge($this->viewJsFiles, $viewJsFiles);
        }        
 
        /**
         * 
         * @return array
         */        
        public function getViewCssFiles() {
            return $this->viewCssFiles;
        }

        /**
         * 
         * @param string $viewCssFiles
         */
        public function setViewCssFiles(array $viewCssFiles) {
            $this->viewCssFiles = array_merge($this->viewCssFiles, $viewCssFiles);
        }        
        
        /**
         * Weißt Variable in View Wert zu
         * @return void
         */        
        public function assign($varName, $varValue) {
            $this->viewVars[$varName] = $varValue;
        }
        
        /**
         * Prüft, ob View-Datei vorhanden ist und lädt diese
         * @return bool
         */        
        public function render() {
            if(!defined('VIEW')) define('VIEW', '1');
            $this->viewFile = $this->viewPath.$this->viewName;
            
            if(!file_exists($this->viewFile)) {
                $notFoundMessage = str_replace('{{viewname}}', $this->viewName, \language::returnLanguageConstant('VIEW_NOT_FOUND'));
                \messages::registerError($notFoundMessage);
                \messages::logError($notFoundMessage);                
                return false;
            }
            
            return true;
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