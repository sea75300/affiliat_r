<?php
    /**
     * Tools
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    final class tools {
        
        /**
         * Erzeugt Passwort Hash via Crypt und sha256
         * @param string $password
         * @param string $salt
         * @return string
         */
        public static function createPasswordHash($password, $salt) {
            for ($i=0; $i<5; $i++) $password = crypt($password, $salt);            
            return hash('sha256', crypt($password, $salt));
            
        }
        
        /**
         * entfernt String uploads/ in Pfaden
         * @param string $path
         * @return string
         */
        public static function removeUploadPath($path) {
            $path = str_replace(\base_config::$rootPath.'/'.basename(\base_config::$uploadDir).'/', '', $path);            
            return $path;
        }
        
    }
?>