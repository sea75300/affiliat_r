<?php
    /**
     * Language class
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    final class language {
        
        private static $languageData  = array();
        
        private static $languagePath;
        
        private static $languageFiles = array(
            'common.php',
            'messages.php',
            'forms.php'
        );

        /**
         * Lädt Sprachdateien
         * @param string $language
         */
        public static function init($language) {
            self::$languagePath = base_config::$baseDir.'/inc/lang/';
            
            foreach (self::$languageFiles as $file) {
                if(!file_exists(self::$languagePath."$language/$file")) {
                    messages::logSystem("language file $file not found!");
                    continue;
                }
                include self::$languagePath."$language/$file";
                self::$languageData = array_merge(self::$languageData, $lang);
            }
            
            if(count(self::$languageData) == 0) self::init('de');
        }
        
        /**
         * Ersetzt Platzhalter in Language-String
         * @param string $constName
         * @param array $replaceArray
         * @return string
         */
        public static function replaceLanguageConstant($constName, $replaceArray) {
            foreach($replaceArray as $placeholder => $placeholderValue) {
                $constName = str_replace($placeholder, $placeholderValue, $constName);
            } 
            
            return $constName;
        }

        /**
         * Schreibt Inhalt von Language-String
         * @param string $constName
         * @param array $replaceArray
         */
        public static function printLanguageConstant($constName, $replaceArray = null, $isNotUtf8 = false) {
            if(!isset(self::$languageData[$constName])) {
                self::$languageData[$constName] = "$constName NOTFOUND!";
                messages::logSystem("language const $constName not found!");
            }
            
            $constText = self::$languageData[$constName];
            
            if(!is_null($replaceArray)) $constText = self::replaceLanguageConstant($constText, $replaceArray);
            
            if($isNotUtf8) $constText = utf8_decode($constText);
            
            print $constText;
        }
        
        /**
         * Gibt Inhalt von Language-String zurück
         * @param string $constName
         * @param array $replaceArray
         * @return string
         */
        public static function returnLanguageConstant($constName, $replaceArray = null, $isNotUtf8 = false) {
            if(!isset(self::$languageData[$constName])) {
                self::$languageData[$constName] = "$constName NOTFOUND!";
                messages::logSystem("language const $constName not found!");
            }
            $constText = self::$languageData[$constName];
            
            if(!is_null($replaceArray)) $constText = self::replaceLanguageConstant($constText, $replaceArray);
            
            if($isNotUtf8) $constText = utf8_decode($constText);
            
            return $constText;
        }     
        
        /**
         * Gibt Liste aller installierten Sprachen aus
         * @return array
         */
        public static function getLanguages() {
            $handle = opendir (self::$languagePath);
            while ($datei = readdir ($handle)) {
                $dateiinfo = pathinfo($datei);							 
                if($datei != "." && $datei != ".." && $datei != "index.html") {                    
                    $languagesArray[file_get_contents(self::$languagePath.$dateiinfo['filename']."/lang.cfg")] = $dateiinfo['filename'];
                }
            }
            closedir($handle);	
            
            return $languagesArray;
        }
    }
?>