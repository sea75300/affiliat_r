<?php
    /**
     * Updater class
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    class updateclass {
        private $dbconnection;

        private $sysconfig;
                
        public function __construct($dbconnection, $sysconfig) {
            $this->dbconnection = $dbconnection;
            $this->sysconfig = $sysconfig;
        }

        public function runUpdate($fileList = array()) {
            $view = new \model\view_installer('updater');
            $view->assign('version', $this->sysconfig->getSysVersion());

            include \base_config::$baseDir.'/version.php';
            
            $this->updateConfigKey('sysVersion', $afltrVersion);                        
            
            if(file_exists(\base_config::$updateCache)) {
                @unlink (\base_config::$updateCache);
            }
            
            $fileDeleteList = array(
                '/inc/model/model_base.php',
                '/inc/model/dashcontainerbox.php',
                '/inc/lib/jquery/jquery-1.10.2.min.js'
            );
            
            foreach ($fileDeleteList as $fileDelete) {
                if(file_exists(\base_config::$baseDir.$fileDelete)) {
                    @unlink (\base_config::$baseDir.$fileDelete);
                }                
            }
            
            $file = new \model\file();
            if(is_dir(base_config::$baseDir.'/inc/lib/lightbox')) {
                $file->deleteRecursive(base_config::$baseDir.'/inc/lib/lightbox');
            }
            if(is_dir(base_config::$baseDir.'/inc/lib/jquery_ui')) {
                $file->deleteRecursive(base_config::$baseDir.'/inc/lib/jquery_ui');
            }
            
            if(!file_exists(base_config::$uploadDir.'/banners')) {
                mkdir(base_config::$uploadDir.'/banners');                
            }
            
            $this->createConfigKey('timeZone', 'Europe/Berlin');
            
            $newVersion = $this->dbconnection->select("config", "config_value", "config_key LIKE 'sysVersion'");
            
            \messages::registerMessage(\language::returnLanguageConstant('UPDATE_SUCCESS'), true);
            
            $view->assign('newVersion', $newVersion[0]['config_value']);
            $view->assign('fileList', $fileList);
            $view->render();
        }

        private function createConfigKey($key, $value) {            
            $config = new \model\system_config($this->dbconnection);
            $config->save($key, $value); 
        }

        private function updateConfigKey($key, $value) { 
            $params = array($value);
            $where  = "config_key LIKE '$key'";
            $this->id = $this->dbconnection->update('config', array('config_value'), array('?'), $params, $where);
        }        
    }
?>