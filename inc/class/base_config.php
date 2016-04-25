<?php
    /**
     * Base config class
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    final class base_config {
        
        public static $baseDir;
        
        public static $uploadDir;
        
        public static $bannerDir;
        
        public static $logfiles;
        
        public static $updateServer;
        
        public static $updateFolder;
        
        public static $rootPath;
        
        public static $updateCache;
        
        public static $cacheFolder;

        /**
         * Initiiert Grundsystem
         */
        public static function init() {
             self::$baseDir         = dirname(dirname(__DIR__));
             self::$logfiles        = array(                 
                 'errors' => self::$baseDir.'/logs/error.txt',
                 'system' => self::$baseDir.'/logs/system.txt'
             );         
             self::$uploadDir       = self::$baseDir.'/uploads/';
             self::$bannerDir       = self::$baseDir.'/uploads/banners/';
             self::$updateServer    = 'http://nobody-knows.org/updatepools/affiliatr/';
             self::$updateFolder    = self::$baseDir.'/upgrade/';
             self::$cacheFolder     = self::$baseDir.'/cache/';
             self::$updateCache     = self::$cacheFolder.'/update.cache';

             $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
             self::$rootPath         = $http.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
             if(strpos(self::$rootPath, 'affiliat_r') === false) self::$rootPath .= '/'.basename(self::$baseDir);
        }

        /**
         * Lädt config.php
         * @return array
         */
        public static function getConfigFile() {
            include self::$baseDir.'/inc/config/config.php';
            return $config;            
        }
               
        
        public static function canConnect() {
            if (ini_get('allow_url_fopen') == 1) { return true; } else { return false; }
        }
    }
?>