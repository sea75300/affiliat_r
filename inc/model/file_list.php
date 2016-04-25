<?php
    /**
     * File list object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;

    class file_list {
        
        private $fileList = array();
        
        private $excludedFiles = array('index.html', 'banners', '.', '..');


        /**
         * 
         * @return void
         */
        public function __construct($folder = false) {
            $uploadDir = opendir( ($folder && is_dir($folder))  ? $folder : \base_config::$uploadDir );
            
            while($uploadFile = @readdir($uploadDir)) {                
                if(in_array($uploadFile, $this->excludedFiles)) continue;
                $this->fileList[$uploadFile] = new file($uploadFile, $folder);
            }  
        }

        /**
         * Gibt array mit Dateien in uploads-Ordner aus
         * @return array
         */
        public function getFileList() {
            return $this->fileList;
        }

        /**
         * 
         * @param string $fileName
         * @return file gibt Objjekt vom Typ file zurück
         */
        public function getFile($fileName) {
            return $this->fileList[$fileName];
        }

        /**
         * FileList-Objekt via print/echo ausgeben
         * @return string
         */
        public function __toString() {            
            $files = array_keys($this->getFileList());            
            return json_encode($files);            
        }

        
    }
?>