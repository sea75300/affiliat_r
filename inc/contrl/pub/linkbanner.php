<?php
    /**
     * Link banner controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2014, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace pub;
    use \contrl AS contrl;
    
    class linkbanner extends contrl\base_contrl {
        
        private $isNotUtf8    = false;
        
        private $returnRender;
        
        private $maxSize;
                
        function __construct($isNotUtf8, $maxSize = array()) {
            parent::__construct();
            $this->isNotUtf8    = $isNotUtf8;
            $this->returnRender = false;
            
            if(isset($maxSize['width']) && !isset($maxSize['height'])) {
                $maxSize['height'] = $maxSize['width'];
            }
            
            if(isset($maxSize['height']) && !isset($maxSize['width'])) {
                $maxSize['width'] = $maxSize['height'];
            }            
            
            $this->maxSize      = $maxSize;
        }

        public function setReturnRender($returnRender) {
            $this->returnRender = $returnRender;
        }
        
        public function process() {
            
            $fileList = new \model\file_list(\base_config::$bannerDir);

            $view = new \model\view_public('banner_list');
            $view->assign('fileList', $fileList->getFileList());
            $view->assign('maxSize', $this->maxSize);
            $view->assign('isNotUtf8', $this->isNotUtf8);
            $view->assign('systemVersion', $this->getSysconfig()->getSysVersion());            
            $view->setReturnRender($this->returnRender);
            
            if($this->returnRender) {
                $data = $view->render();
                return $data;                
            }
            
            $view->render();                    
        }
    }
?>