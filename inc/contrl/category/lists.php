<?php
    /**
     * Category list controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace category;
    use \contrl AS contrl;
    
    class lists extends contrl\base_contrl {
        
         
        public function process() {
            if(!parent::process()) $this->redirectNoSession();

            if(!is_null($this->getRequestVar('categoryDelList')) ) {
                $categoryIds = $this->getRequestVar('categoryDelList');                
                foreach ($categoryIds as $categoryId) {
                    $category = new \model\category($this->getDbconnection(), $this->filterRequest($categoryId, array(1,4,7)));
                    $category->delete();
                }                
                $this->redirect('category/list', array('categorydeleted=yes'));
            }            
            
            $categoryList = new \model\category_list($this->getDbconnection());

            if(!is_null($this->getRequestVar('categoryadded'))) {
                \messages::registerMessage(\language::returnLanguageConstant('SAVE_SUCCESS_ADDCATEGORY'));
            }
            if(!is_null($this->getRequestVar('categoryedited'))) {
                \messages::registerMessage(\language::returnLanguageConstant('SAVE_SUCCESS_EDITCATEGORY'));
            }    
            if(!is_null($this->getRequestVar('categorydeleted'))) {
                \messages::registerMessage(\language::returnLanguageConstant('DELETE_SUCCESS_CATEGORIES'));
            }            
            
            $view = new \model\view_acp('category_list');
            $view->assign('categoryList', $categoryList->getCategories());
            $view->assign('dtMask', $this->getSysconfig()->getDateTimeMask());
            $view->render();  
        }
        
    }
?>