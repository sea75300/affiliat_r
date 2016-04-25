<?php
    /**
     * Base controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace contrl;

    class base_contrl implements controller {

        protected $sysconfig;
        
        protected $dbconnection;

        protected $request;
       
        protected $uploadDir;
        
        protected $session;

        public function __construct() {
            if(!file_exists(\base_config::$baseDir.'/inc/config/config.php')) die('You have to install Affiliat*r before you can use it! <a href="install/">Start Install</a>');
            
            $this->dbconnection = new \database();
            $this->sysconfig    = new \model\system_config($this->dbconnection);
            $this->uploadDir    = \base_config::$uploadDir;
            \language::init($this->sysconfig->getSysLanguage());
            
            \model\view::$version = $this->sysconfig->getSysVersion();
            
            date_default_timezone_set($this->sysconfig->getTimeZone());
            
            $this->request = array_merge($_REQUEST, $_COOKIE);
        }

        /**
         * System Config zurückgeben
         * @return \model\system_config
         */
        public function getSysconfig() {
            return $this->sysconfig;
        }
        
        /**
         * Datenbank Verbindung zurückgeben
         * @return \database
         */
        public function getDbconnection() {
            return $this->dbconnection;
        }
        
        /**
         * Upload Folder zurückgeben
         * @return string
         */
        public function getUploadDir() {
            return $this->uploadDir;
        }
        
        /**
         * Gibt Wert in $_GET, $_POST, $_FILE zurück
         * @param string $varname
         * @param array $filter
         * @return mixed
         */
        public function getRequestVar($varname = null, array $filter = array()) {
            if(is_null($varname)) return $this->request;
            $returnVal = (isset($this->request[$varname])) ? $this->filterRequest($this->request[$varname], $filter) : null;
            return $returnVal;
        }
        
        /**
         * gibt Inhalt von Session cookie zurück
         * @return null|string
         */
        public function getSessionCookieValue() {
            if (isset($_COOKIE["afltrsid"])) {
                return $this->filterRequest($_COOKIE["afltrsid"], array(1,4,7));
            } else {
                return null;
            }
        }        

        /**
         * Session zurückgeben
         * @return \model\session
         */        
        public function getSession() {
            return $this->session;
        }        
        
        /**
         * Filter
         * @param string $filterString
         * @param array $filters
         * @return string
         */
        public static function filterRequest($filterString, array $filters) {
            if(is_array($filterString)) {                
                foreach ($filterString as $value) {
                    static::filterRequest($value, $filters);
                }
                return $filterString;
            }
            
            $allowedTags  = (isset($filters['allowedtags'])) ? $filters['allowedtags'] : '';
            foreach ($filters as $filter) {                
                switch ($filter) {
                    case '1' :
                        $filterString = strip_tags($filterString, $allowedTags);
                    break;
                    case '2' :
                        $filterString = htmlspecialchars($filterString);
                    break;
                    case '3' :
                        $filterString = htmlentities($filterString);
                    break;
                    case '4' :
                        $filterString = stripslashes($filterString);
                    break;
                    case '5' :
                        $filterString = htmlspecialchars_decode($filterString);
                    break;
                    case '6' :
                        $filterString = html_entity_decode($filterString);
                    break;
                    case '7' :
                        $filterString = trim($filterString);
                    break;
                }                
            }
            
            return $filterString;            
        }
        
        /**
         * Redirect wenn nicht eingeloggt
         * @param string $subDir
         */
        protected function redirectNoSession($subDir = false) {
            $subDir = ($subDir) ? '../' : '';
            header("Location: ".$subDir."index.php?nologin");
        }

        /**
         * Controller Redirect
         * @param string $controller
         * @param array $params
         */
        protected function redirect($controller = '', array $params = array()) {
            $redirectString = empty($controller) ? "Location: index.php" : "Location: index.php?module=$controller";
            if(!empty($params)) {
                $redirectString .= empty($controller) ? '?' : '&';
                $redirectString .= implode ('&', $params);
            }
            header($redirectString);
        }

        /*
         * Controller ausführen
         * @retrun bool
         */
        public function process() {
            $sessionCookieValue = $this->getSessionCookieValue();
            if(!is_null($sessionCookieValue)) {                
                $this->session  = new \model\session($this->getDbconnection(), $sessionCookieValue);
                $sessionExists  = $this->session->exists();
                if($sessionExists) define('SHOW_ACP_NAV', 1);
                
                $this->checkUpdates();
                
                return $sessionExists;
            }
            
            return false;
        }
        
        /**
         * Update check
         * @return string
         */
        private function checkUpdates() {            
            $updateValue = $this->sysconfig->checkForUpdates();
            if(!is_null($updateValue)) {
                $updateMessage = \language::replaceLanguageConstant(\language::returnLanguageConstant('UPDATE_NOTAUTOCHECK'),array('{{versionlink}}' => $updateValue));                
                \messages::registerError($updateMessage,true);
                \messages::registerMessage("<iframe src=\"$updateValue\" class=\"update-check-iframe\" scrolling=\"no\" seamless></iframe>",true);   
            }
        }        
    }
?>