<?php
    /**
     * Files controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace system;
    use \contrl AS contrl;
    
    class files extends contrl\base_contrl {

        public function process() {
            if(!parent::process()) $this->redirectNoSession();
            
            if(!is_null($this->getRequestVar('submupload'))) { 
                $newFile = new \model\file();
                $newFile->uploadFile();
            }            
            
            if(!is_null($this->getRequestVar('fileDelList')) ) {
                $deleted = false;
                
                $files = $this->getRequestVar('fileDelList');                
                foreach ($files as $fileName) {
                    $file = new \model\file($fileName);
                    if($file->delete()) { $deleted = true; }
                }                
                
                if($deleted) \messages::registerMessage(\language::returnLanguageConstant('DELETE_SUCCESS_FILES'));
            }             
            
            $fileList = new \model\file_list();

            $view = new \model\view_acp('file_list');
            $view->assign('fileList', $fileList->getFileList());
            $view->assign('dtMask', $this->getSysconfig()->getDateTimeMask());
            $view->render();   
        }

        
        
    }
?>