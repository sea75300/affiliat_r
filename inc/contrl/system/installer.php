<?php
    /**
     * Installer controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace system;
    use \contrl AS contrl;

    class installer extends contrl\base_contrl {
        
        private $checkFolders = array(
            'inc/config',
            'logs',
            'upgrade',
            'uploads',
            'cache'
        );

        public function __construct() {

            if(!file_exists(\base_config::$baseDir.'/inc/config/config.php') || (file_exists(\base_config::$baseDir.'/inc/config/config.php') && file_exists(\base_config::$baseDir.'/install/'))) {
                $this->request = array_merge($_REQUEST, $_COOKIE); 
                $this->runInstall();
            } else {
                parent::__construct();
            }
        }

        private function runInstall() {            
            $this->checkRequirements();

            $step = $this->getRequestVar('step');

            define('INSTALL_MODE', 0);
            
            if(is_null($step)) {
                \language::init('de');
                
                $view = new \model\view_installer('start');
                $view->assign('languages', \language::getLanguages());
                $view->assign('lang', '');
                $view->render();   
            } else {
                $setupLang = $this->getRequestVar('lang');
                if(empty($setupLang)) { header ('Location: index.php'); }

                \language::init($setupLang);
                $install = new \installclass();
                
                if(!is_null($this->getRequestVar('pins'))) {
                    \messages::registerError(\language::returnLanguageConstant('SAVE_FAILED_PASSWORD'), true);
                }                
                
                if(!is_null($this->getRequestVar('dbconfig'))) {
                    $install->createConfigFile($this->getRequestVar('dbconfig'));                    
                }
                
                if($step > 1) {
                    $this->dbconnection = new \database();
                    $install->setDbconnection($this->dbconnection);
                }                

                if(!is_null($this->getRequestVar('submsave'))) {
                    if(!$install->createConfigKey($this->getRequestVar('options'))) {
                        header ('Location: index.php?step=2&lang='.$setupLang.'&pins=yes');
                    }
                }

                if($step == 1) {
                    if(!isset($_GET['lang'])) header ('Location: index.php?step=1&lang='.$setupLang);
                    
                    $view = new \model\view_installer('dbconfig');
                    $view->assign('fields', array(
                        'DBHOST' => 'localhost',
                        'DBNAME' => '',
                        'DBUSER' => '',
                        'DBPASS' => '',
                        'DBPREF' => 'afltr'
                    ));
                    $view->assign('lang', $setupLang);
                    $view->assign('dbtypes', array('MySQL' => 'mysql'));
                    $view->render();                    
                }
                
                if($step == 2) {  
                    $tables = array('affiliates', 'categories', 'config', 'logins');
                    foreach ($tables as $table) { $install->createTable($table); }

                    $install->createStdCategory();
                    
                    $fields = array(
                        'adminMail'         => 'example@your.domain',
                        'iframecss'         => '',
                        'sessionLength'     => '3600',
                        'timeZone'          => 'Europe/London',
                        'dateTimeMask'      => 'd.m.Y H:i',
                        'antispamQuestion'  => '',
                        'antispamAnswer'    => ''
                    );                    
                    
                    $timeZones = timezone_identifiers_list();            
                    $timeZones = array_combine(array_values($timeZones), array_values($timeZones));   

                    $view = new \model\view_installer('config');
                    $view->assign('fields', $fields);
                    $view->assign('modes', array('iframe' => 1, 'phpcinlude' => 2));
                    $view->assign('timeZones', $timeZones);                    
                    $view->assign('sysmode', 1);
                    $view->assign('languages', \language::getLanguages());
                    $view->assign('lang', $setupLang);
                    $view->render();                    
                }
                
                if($step == 3) {
                    $view = new \model\view_installer('end');
                    $view->render();
                    
                    $file = new \model\file();
                    $file->deleteRecursive(\base_config::$baseDir.'/install/');
                }

            }            
        }
        
        private function checkRequirements() {
            if(!class_exists('PDO')) {
                \messages::registerError('PHP PDO extension not found! Unable to proceed. Contact your host!',true);die();                
            }
            
            foreach ($this->checkFolders as $checkFolder) {
                if(!is_writable(\base_config::$baseDir.'/'.$checkFolder)) { \messages::registerError("Unable to write in folder <b>/$checkFolder</b>!",true); }
            }
              
            if(!\base_config::canConnect()) {
                \messages::registerNotice('PHP setting <b>allow_url_fopen</b> is diabled. This is not required, but recommended.',true);
            }
        }

        public function process() {
            if(!parent::process()) $this->redirectNoSession(true);
            
            @unlink(\base_config::$updateCache);
            
            $fileList = array();

            $updateFileName = $this->getRequestVar('file');
            if(!is_null($updateFileName)) {
                $fileName   = base64_decode($updateFileName);
                $updateFile = new \model\file();
                
                if($updateFile->downloadPackage($fileName) && $updateFile->unzipPackage(basename($fileName), $fileList)) {                     
                    $updateFile->copyRecursive(\base_config::$updateFolder.'affiliat_r/', \base_config::$baseDir);
                    $updateFile->deleteRecursive(\base_config::$updateFolder.'affiliat_r/');
                    @unlink(\base_config::$updateFolder.basename($fileName));
                }
            }

            $update = new \updateclass($this->dbconnection, $this->sysconfig);
            $update->runUpdate($fileList);
        }

    }
?>