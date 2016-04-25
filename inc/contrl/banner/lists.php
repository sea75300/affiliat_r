<?php
    /**
     * Files controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace banner;
    use \contrl AS contrl;
    
    class lists extends contrl\base_contrl {

        public function process() {
            if(!parent::process()) $this->redirectNoSession();
            
            if(!is_null($this->getRequestVar('submupload'))) { 
                $newFile = new \model\file();
                $newFile->uploadFile(\base_config::$bannerDir);
            }            
            
            if(!is_null($this->getRequestVar('fileDelList')) ) {
                $deleted = false;
                
                $files = $this->getRequestVar('fileDelList');                
                foreach ($files as $fileName) {
                    $file = new \model\file($fileName, \base_config::$bannerDir);
                    if($file->delete()) { $deleted = true; }
                }                
                
                if($deleted) \messages::registerMessage(\language::returnLanguageConstant('DELETE_SUCCESS_FILES'));
            }             
            
            $fileList = new \model\file_list(\base_config::$bannerDir);

            $view = new \model\view_acp('banner_list');
            $view->assign('fileList', $fileList->getFileList());
            $view->assign('dtMask', $this->getSysconfig()->getDateTimeMask());
            $view->render();   
        }

        
        
    }
?>