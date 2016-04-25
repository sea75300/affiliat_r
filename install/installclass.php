<?php
    /**
     * Installer class
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    class installclass {
        private $dbconnection;

        public function setDbconnection($dbconnection) {
            $this->dbconnection = $dbconnection;
        }
        
        public function createConfigFile(array $configData) {   
            $fileContent = '
            <?php                
                $config = array(
                    \'DBNAME\' => \''.\contrl\base_contrl::filterRequest($configData['DBNAME'], array (1,4,7)).'\',
                    \'DBHOST\' => \''.\contrl\base_contrl::filterRequest($configData['DBHOST'], array (1,4,7)).'\',
                    \'DBUSER\' => \''.\contrl\base_contrl::filterRequest($configData['DBUSER'], array (1,4,7)).'\',
                    \'DBPASS\' => \''.\contrl\base_contrl::filterRequest($configData['DBPASS'], array (1,4,7)).'\',
                    \'DBTYPE\' => \''.\contrl\base_contrl::filterRequest($configData['DBTYPE'], array (1,4,7)).'\',
                    \'DBPREF\' => \''.\contrl\base_contrl::filterRequest($configData['DBPREF'], array (1,4,7)).'\'
                );
            ?>';                        
            $fileContent = str_replace('            ', '', $fileContent);
            file_put_contents(base_config::$baseDir.'/inc/config/config.php', trim($fileContent));   
        }
        
        public function createTable($tableName) {            
            $query = file_get_contents(base_config::$baseDir.'/install/sql/tab_'.$tableName.'.sql');
            $query = str_replace('{{dbprefix}}', $this->dbconnection->getDbprefix(), $query);
            if(!$this->dbconnection->exec($query)) {
                die("ERROR while creating table $tableName!!!");
            }            
        }
        
        public function createConfigKey($newConfig) {      
            include \base_config::$baseDir.'/version.php';
            
            $newConfig['sysVersion']        = $afltrVersion;
            $newConfig['loginPasswortSalt'] = uniqid(md5($_SERVER['HTTP_HOST']), true);
            
            if(!preg_match("/^.*(?=.{6,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $newConfig['loginPasswort'])) {
                return false;
            }

            $newConfig['loginPasswort'] = \tools::createPasswordHash($newConfig['loginPasswort'], $newConfig['loginPasswortSalt']);
            $config = new \model\system_config($this->dbconnection);

            foreach ($newConfig as $key => $value) {  
                $value = \contrl\base_contrl::filterRequest($value, array (1,4,7));
                $config->save($key, $value);                
            }
            
            return true;
        }
        
        public function createStdCategory() {
            $category = new \model\category($this->dbconnection);
            $category->setName('Links');
            $category->save();            
        }
        
        
        
    }
?>