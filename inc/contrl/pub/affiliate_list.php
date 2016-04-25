<?php
    /**
     * Affiliate list controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace pub;
    use \contrl AS contrl;
    
    class affiliate_list extends contrl\base_contrl {
        
        private $categoryId;
        
        private $viewName;
        
        private $acceptedOnly;

        private $textOnly;
        
        private $openBlank;
        
        private $isNotUtf8;
        
        private $returnRender;

        public function __construct($categoryId, $viewName = null, $acceptedOnly = false, $textOnly = 0, $openBlank = false, $isNotUtf8 = false) {
            $viewName = (is_null($viewName)) ? 'affiliate_list' : $viewName;

            parent::__construct();
            $this->categoryId   = $categoryId;
            $this->viewName     = $viewName;
            $this->acceptedOnly = $acceptedOnly;
            $this->textOnly     = $textOnly;
            $this->openBlank    = $openBlank;
            $this->isNotUtf8    = $isNotUtf8;
            $this->returnRender = false;
        }

        public function setReturnRender($returnRender) {
            $this->returnRender = $returnRender;
        }        
        
        public function process() {
            $affiliates = new \model\affiliate_list($this->getDbconnection(), $this->categoryId, $this->acceptedOnly, $this->textOnly);            
            
            $view = new \model\view_public($this->viewName);
            if(count($affiliates->getAffiliates()) > 0) {
                $view->assign('affiliates', $affiliates->getAffiliates());
            } else {
                $view->assign('notaffiliates', true);
            }
            
            $category   = new \model\category($this->getDbconnection(), $this->categoryId);
            $value = ($this->openBlank) ? 'target="_blank"' : '';                        
            $categoryName = ($this->textOnly == 2) ? $category->getName().'-text' : $category->getName();
            
            $view->assign('linkTarget', $value);
            $view->assign('categoryNameClass', strtolower($categoryName));
            $view->assign('showastext', $this->textOnly);
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