<?php
    /**
     * System config object
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace model;

    class system_config {
        
        private $dbconnection;

        private $systemMode;

        private $iframecss;
        
        private $loginPasswort;
        
        private $loginPasswortSalt;

        private $sysVersion;
        
        private $sessionLength;
        
        private $dateTimeMask;
        
        private $sysLanguage;
        
        private $antispamQuestion;
        
        private $antispamAnswer;
        
        private $adminMail;

        private $tabName = 'config';
        
        private $timeZone;


        /**
         * 
         * @param \database $dbconnection DB-Verbindung
         */
        function __construct(\database $dbconnection) {
            $this->dbconnection      = $dbconnection;
            $this->loadData();
        }

        /**
         * 
         * @return string
         */
        public function getSystemMode() {
            return $this->systemMode;
        }

        /**
         * 
         * @return string
         */
        public function getIframecss() {
            return $this->iframecss;
        }

        /**
         * 
         * @return string
         */
        public function getLoginPasswort() {
            return $this->loginPasswort;
        }

        /**
         * 
         * @return string
         */
        public function getSysVersion() {
            return $this->sysVersion;
        }

        /**
         * 
         * @return string
         */
        public function getSessionLength() {
            return $this->sessionLength;
        }

        /**
         * 
         * @return string
         */
        public function getDateTimeMask() {
            return $this->dateTimeMask;
        }

        /**
         * 
         * @return string
         */
        public function getSysLanguage() {
            return $this->sysLanguage;
        }

        /**
         * 
         * @param string $systemMode
         */
        public function setSystemMode($systemMode) {
            $this->systemMode = $systemMode;
        }

        /**
         * 
         * @param string $iframecss
         */
        public function setIframecss($iframecss) {
            $this->iframecss = $iframecss;
        }

        /**
         * 
         * @param string $loginPasswort
         */
        public function setLoginPasswort($loginPasswort) {
            $this->loginPasswort = \tools::createPasswordHash($loginPasswort, $this->getLoginPasswortSalt());
        }

        /**
         * 
         * @param string $sysVersion
         */
        public function setSysVersion($sysVersion) {
            $this->sysVersion = $sysVersion;
        }

        /**
         * 
         * @param string $sessionLength
         */
        public function setSessionLength($sessionLength) {
            $this->sessionLength = $sessionLength;
        }

        /**
         * 
         * @param string $dateTimeMask
         */
        public function setDateTimeMask($dateTimeMask) {
            $this->dateTimeMask = $dateTimeMask;
        }

        /**
         * 
         * @param string $sysLanguage
         */
        public function setSysLanguage($sysLanguage) {
            $this->sysLanguage = $sysLanguage;
        }
        
        /**
         * 
         * @return string
         */
        public function getAntispamQuestion() {
            return $this->antispamQuestion;
        }

        /**
         * 
         * @return string
         */
        public function getAntispamAnswer() {
            return $this->antispamAnswer;
        }

        /**
         * 
         * @param string $antispamQuestion
         */
        public function setAntispamQuestion($antispamQuestion) {
            $this->antispamQuestion = $antispamQuestion;
        }
        
        /**
         * 
         * @param string $antispamAnswer
         */
        public function setAntispamAnswer($antispamAnswer) {
            $this->antispamAnswer = $antispamAnswer;
        }        
        
        /**
         * 
         * @return string
         */
        public function getAdminMail() {
            return $this->adminMail;
        }

        /**
         * 
         * @param string $adminMail
         */
        public function setAdminMail($adminMail) {
            $this->adminMail = $adminMail;
        }        
        
        /**
         * 
         * @return string
         */
        public function getLoginPasswortSalt() {
            return $this->loginPasswortSalt;
        }        
        
        /**
         * 
         * @return string
         */        
        public function getTimeZone() {
            return $this->timeZone;
        }

        /**
         * 
         * @param string $timeZone
         */        
        public function setTimeZone($timeZone) {
            $this->timeZone = $timeZone;
        }        
        
        /**
         * Speichert
         */
        public function save($confKeyName, $confkeyValue) {
            $count = $this->dbconnection->count($this->tabName, 'id', "config_key LIKE '$confKeyName'");
            if($count > 0) return false;
            
            $values = array('?', '?', '?');
            $params = array(NULL,
                            $confKeyName,
                            $confkeyValue);
            $this->id = $this->dbconnection->insert($this->tabName, 'id, config_key, config_value', implode(', ', $values), $params);
            $this->loadData();
            if($this->id > 0) return true;
            return false;
        }        
        
        /**
         * Aktualisiert
         * @return void
         */
        public function update() {
            $confKeys = array(
                'systemMode'        => $this->getSystemMode(),
                'iframecss'         => $this->getIframecss(),
                'loginPasswort'     => $this->getLoginPasswort(),
                'sessionLength'     => $this->getSessionLength(),
                'dateTimeMask'      => $this->getDateTimeMask(),
                'sysLanguage'       => $this->getSysLanguage(),
                'antispamQuestion'  => $this->getAntispamQuestion(),
                'antispamAnswer'    => $this->getAntispamAnswer(),
                'adminMail'         => $this->getAdminMail(),
                'timeZone'          => $this->getTimeZone()
            );            
            
            foreach ($confKeys as $confKey => $confValue) {          
                $params = array($confValue);
                $where  = "config_key LIKE '$confKey'";            
                $this->id = $this->dbconnection->update($this->tabName, array('config_value'), array('?'), $params, $where);                
            }
            
            $this->loadData();
        }
        
        /**
         * 
         * @return void
         */        
        public function delete($confKeyName) {
            return $this->dbconnection->delete($this->tabName, "config_key LIKE $confKeyName");
        }
      
        /**
         * Lädt Daten
         * @return void
         */        
        private function loadData() {            
            $systemconfig = $this->dbconnection->select($this->tabName, 'config_key, config_value');
            foreach ($systemconfig as $value) {
                $this->{$value['config_key']} = $value['config_value'];
            }
        }
        
        /**
         * Prüft ob Update verfügbar sind
         * @return string|null
         */
        public function checkForUpdates() {

            $data = array(
                'version'   => $this->getSysVersion(),
                'language'  => $this->getSysLanguage(),
                'phpvers'   => PHP_VERSION,
                'isauto'    => (int) \base_config::canConnect()
            );
            
            $url = \base_config::$updateServer.'noauto.php?data='.  base64_encode(json_encode($data));
            
            if(!\base_config::canConnect()) return $url;            
            
            if(file_exists(\base_config::$updateCache)) {
                $updateCache = json_decode(file_get_contents(\base_config::$updateCache), true);

                if($updateCache['expire'] >= time()) {
                    if(!empty($updateCache['message'])) \messages::registerNotice($updateCache['message'],true);
                    return;
                }                
            }
            
            try {
                $url = \base_config::$updateServer.'newver.php?data='.  base64_encode(json_encode($data));
                $updateData = fopen($url, 'r');                
                $updateData = fgets($updateData);
                $updateData = json_decode(base64_decode($updateData), true);
                $updateMessage = '';

                if(version_compare($updateData['newversion'], $this->getSysVersion(), '>')) {
                    
                    if(isset($updateData['forceupdate']) && $updateData['forceupdate']) {
                        header("Location: ?module=system/update&file=".$updateData['updatefile']);
                    }
                    
                    $updateMessage = \language::replaceLanguageConstant(
                                        \language::returnLanguageConstant('UPDATE_NEWVERSION'),
                                        array('{{versionlink}}' => '?module=system/update&file='.$updateData['updatefile'])
                                    );                    
                    \messages::registerNotice($updateMessage,true);                
                }
                
                $cacheTmp = array(
                    'expire'  => time() + 43200,
                    'message' => $updateMessage
                );

                file_put_contents(\base_config::$updateCache, json_encode($cacheTmp));                 
            } catch (\Exception $ex) {
                \messages::registerError($ex->getMessage(),true);
            }
            
            return null;
        }
        
        /**
         * Prüft, ob Passwort Minmum-Sicherheit entspricht
         * @param string $passwd
         * @return boolean
         */
        public function isPasswordSecure($passwd) {
            if(preg_match("/^.*(?=.{6,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $passwd)) { return true; }
            
            return false;
        }
        
    }
?>