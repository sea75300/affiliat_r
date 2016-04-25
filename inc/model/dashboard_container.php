<?php
    /**
     * Dashboard container object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;

    class dashboard_container {
        
        private $boxName;
        
        private $boxHeadline;

        private $boxContent;
        
        private $boxSize;
        
        private $boxHeight;

        /**
         * 
         * @param string $boxName Name des Containers
         * @param string $boxHeadline Überschrift im Container
         * @param string $boxContent Inhalt im Container
         */
        public function __construct($boxName, $boxHeadline = null, $boxContent = null, $boxSize = null, $boxHeight = null) {
            $this->boxName      = $boxName;
            $this->boxHeadline  = $boxHeadline;
            $this->boxContent   = $boxContent;
            $this->boxHeight    = $boxHeight;
            $this->boxSize      = (!is_bool($boxSize)) ? $boxSize : 'big';
        }
        
        /**
         * 
         * @return string
         */
        public function getBoxName() {
            return $this->boxName;
        }

        /**
         * 
         * @return string
         */
        public function getBoxHeadline() {
            return $this->boxHeadline;
        }

        /**
         * 
         * @return string
         */
        public function getBoxContent() {
            return $this->boxContent;
        }

        /**
         * 
         * @param string $boxName
         */
        public function setBoxName($boxName) {
            $this->boxName = $boxName;
        }

        /**
         * 
         * @param string $boxHeadline
         */
        public function setBoxHeadline($boxHeadline) {
            $this->boxHeadline = $boxHeadline;
        }

        /**
         * 
         * @param string $boxContent
         */
        public function setBoxContent($boxContent) {
            $this->boxContent = $boxContent;
        }
        
        /**
         * Conatiner-Objekt via print/echo ausgeben
         * @return string
         */
        public function __toString() {
            $sizeClass  = 'afltr-dashboard-container-outer-'.$this->boxSize;
            $sizeHeight = (!is_null($this->boxHeight)) ? "style=\"height:{$this->boxHeight}\"" : '';
            
            $output = "<div class=\"afltr-dashboard-container-outer $sizeClass\"><div class=\"afltr-dashboard-container small-text ui-widget-content ui-corner-all ui-state-highlight\" id=\"{$this->boxName}\" $sizeHeight>\n";
            $output .= (!is_null($this->boxHeadline)) ? "<h3 class=\"ui-corner-top  ui-corner-all\">{$this->boxHeadline}</h3>\n" : "";
            $output .= (!is_null($this->boxContent)) ? "<div class=\"afltr-dashboard-container-content\">{$this->boxContent}</div>\n" : "";
            $output .= "</div>\n</div>\n\n";
            
            return $output;
        }
        
    }
?>