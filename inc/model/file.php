<?php
    /**
     * File object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;

    class file {
        
        private $name;
        
        private $path;
        
        private $url;

        private $resolution;
        
        private $createdTime;
        
        private $changedTime;
        
        private $fileMeta;


        /**
         * 
         * @param string $name Dateiname im uploads-Ordner
         * @return void
         */
        public function __construct($name = null, $folder = false) {
            if(is_null($name)) return;
            
            $folder             = ($folder && is_dir($folder)) ? $folder : \base_config::$uploadDir;            
            $this->path         = $folder.$name;
            
            $this->fileMeta     = getimagesize($this->path);            
            $this->resolution   = \language::returnLanguageConstant('FILES_IMGRESOLUTION', array("%res_x%" => $this->fileMeta[0],"%res_y%" => $this->fileMeta[1]));            
            $this->name         = $name;
            $this->createdTime  = filemtime($this->path);
            $this->changedTime  = filectime($this->path);
            $this->url          = basename($folder).'/'.$this->name;
        }

        /**
         * 
         * @return string
         */
        public function getName() {
            return $this->name;
        }

        /**
         * 
         * @return string
         */
        public function getPath() {
            return $this->path;
        }

        /**
         * 
         * @return string
         */
        public function getUrl() {
            return $this->url;
        }

        /**
         * 
         * @return string
         */
        public function getResolution() {
            return $this->resolution;
        }

        /**
         * 
         * @return int
         */
        public function getCreatedTime() {
            return $this->createdTime;
        }

        /**
         * 
         * @return int
         */
        public function getChangedTime() {
            return $this->changedTime;
        }
        
        /**
         * 
         * @param int $index
         * @return string
         */
        function getFileMeta($index) {
            return isset($this->fileMeta[$index]) ? $this->fileMeta[$index] : null;
        }        

        /**
         * 
         * @return bool
         */        
        public function delete() {
            if(file_exists($this->path)) return unlink ($this->path);
        }

        /**
         * 
         * @return null|string Dateiname
         */
        public function uploadFile($folder = false) {
            
            $folder = $folder ? $folder : \base_config::$uploadDir;
            
            $files = $_FILES['pageButtonFile'];
 
            $currentFileData["tmp_name"] = $files["tmp_name"];
            $currentFileData["type"]     = $files["type"];
            $currentFileData["name"]     = $this->escapeFileName($files["name"]);
            $currentFileData["error"]    = $files["error"];
            $currentFileData["size"]     = $files["size"];

            if (is_uploaded_file($currentFileData['tmp_name']) && $currentFileData["error"] == 0) {
                $allowedFileTypes = array("image/jpeg" , "image/jpg", "image/gif", "image/png");
                if(in_array($currentFileData['type'], $allowedFileTypes)) {
                    if(move_uploaded_file($currentFileData['tmp_name'], $folder.$currentFileData['name'])) return $currentFileData['name'];
                }
            }

            return null;
        }        
        
        /**
         * Filtert problematische Zeichen aus Dateinamen
         * @param string $filename Dateiname
         * @return string gefilterter Dateiname
         */
        private function escapeFileName($filename) {
            $filename = strtolower($filename);  
            $filename = htmlentities ($filename, ENT_COMPAT | ENT_HTML401, 'utf-8');
            $textReplaces = array("&szlig;" => "ss", "&auml;" => "a", "&ouml;" => "o", "&uuml;" => "u");                        
            $filename = str_replace(array_keys($textReplaces), array_values($textReplaces), $filename);
            $filename = preg_replace('/[^A-Za-z0-9_.\-]/', '', $filename);
            return filter_var($filename, FILTER_SANITIZE_URL);
        }   
        
        /**
         * Löscht Verzeichnis reskusiv
         * @param string $path Pfad, der gelöscht werden soll
         * @return int
         */
        public function deleteRecursive ($path, $keepbase = false) {
            if (!is_dir ($path)) { return -1; }
            $dir = @opendir ($path);
            if (!$dir) { return -2; }

            while (($entry = @readdir($dir)) !== false) {
                    if ($entry == '.' || $entry == '..') { continue; }

                    if (is_dir ($path.'/'.$entry)) {
                            $res = $this->deleteRecursive ($path.'/'.$entry);
                            if ($res == -1) {
                                    @closedir ($dir);
                                    return -2;
                            } else if ($res == -2) {
                                    @closedir ($dir);
                                    return -2;
                            } else if ($res == -3) {
                                    @closedir ($dir);
                                    return -3;
                            } else if ($res != 0) {
                                    @closedir ($dir);
                                    return -2;
                            }
                    } else if (is_file ($path.'/'.$entry) || is_link ($path.'/'.$entry)) {
                            $res = @unlink ($path.'/'.$entry);
                            if (!$res) {
                                    @closedir ($dir);
                                    return -2;
                            }
                    } else {
                            @closedir ($dir);
                            return -3;
                    }
            }

            @closedir ($dir);
            
            if($keepbase) return 1;
            
            $res = @rmdir ($path);

            if (!$res) { return -2; }

            return 0;
        } 
        
        /**
         * Kopiert Verzeichnis reskusiv
         * @param string $source
         * @param string $destination
         */
        function copyRecursive($source, $destination) {
            $dir = opendir($source);

            if(!file_exists($destination)) @mkdir($destination, 0777);
            while(false !== ( $file = readdir($dir)) ) {
                if (( $file != '.' ) && ( $file != '..' )) {
                    if ( is_dir($source . '/' . $file) ) {
                        $this->copyRecursive($source . '/' . $file,$destination . '/' . $file);
                    } else {
                        if(!empty($destination) && !empty($file) && !is_writable($destination . '/' . $file)) @chmod($destination . '/' . $file, 0777);
                        @copy($source . '/' . $file,$destination . '/' . $file);
                    }
                }
            }
            closedir($dir);
        }
        
        /**
         * Lädt Datei von Server
         * @param string $updateFolder Ordner zum Download
         * @param string $updateFileNameRemote Dateiname, welche runterladen werden soll
         * @param string $updateFileRemote URL zu Datei auf Server
         */
        public function downloadPackage($remoteFileName) {
            $localFileName  = \base_config::$updateFolder.basename($remoteFileName);
            $remoteFileName = \base_config::$updateServer.$remoteFileName;
            
            $remoteFile     = @fopen($remoteFileName,"rb");	            
            if($remoteFile) {
                \messages::logSystem('Dowload update file '.$remoteFileName);
                
                $localFile = @fopen($localFileName,"wb");
                while(!feof($remoteFile)) {
                    $fileContent = @fgets($remoteFile);
                    @fwrite($localFile, $fileContent);
                }

                fclose($remoteFile);
                fclose($localFile);  

                if(sha1_file($remoteFileName) == sha1_file($localFileName))  {
                    \messages::registerMessage(\language::returnLanguageConstant('DOWNLOAD_PCK_SUCCESS'), false);
                    \messages::logSystem('Dowload update file '.$remoteFileName.' >> OK!');
                    return $localFileName;
                }
            }
            
            \messages::registerError(\language::returnLanguageConstant('DOWNLOAD_PCK_FAILED'), false);
            \messages::logSystem('Dowload update file '.$remoteFileName.' >> FAILED!');
            
            return false;
        }      
        
        public function unzipPackage($fileName, &$fileList = array()) {
            $fileName = \base_config::$updateFolder.$fileName;
            
            $zip = new \ZipArchive();
            $res = $zip->open($fileName);
            if($res !== TRUE) {
                \messages::logSystem($res);
                \messages::registerError(\language::returnLanguageConstant('UNPACK_PCK_FAILED'), false);
                return false;
            }
            
            for($i=0;$i<$zip->numFiles;$i++) {
                $zipFileName = \base_config::$baseDir.$zip->getNameIndex($i);
                
                if(file_exists($zipFileName) && !is_writable($zipFileName)) {
                    chmod($zipFileName, 0777);
                }
                
                $fileCheck = $zip->getNameIndex($i);
                if(file_exists($zipFileName)) {
                    $fileCheck = is_writable($zipFileName) ? true : false;
                } else {
                    $fileCheck = true;
                }
                $fileList[$zipFileName] = $fileCheck;
            }            
            
            if($zip->extractTo(\base_config::$updateFolder)) {
                \messages::logSystem('Extract package file '.$fileName.' >> OK!');
                \messages::registerMessage(\language::returnLanguageConstant('UNPACK_PCK_SUCCESS'), false);
            }
            
            $zip->close();

            return true;
        }
        
    }
?>