<?php
    /**
     * Category edit controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace category;
    use \contrl AS contrl;
    
    class edit extends contrl\base_contrl {

        public function process() {
            if(!parent::process()) $this->redirectNoSession();
                
            $categoryId = $this->getRequestVar('categoryid', array (1,4,7));

            if(is_null($categoryId)) $this->redirect('category/list');

            $category = new \model\category($this->getDbconnection(), $categoryId);

            if(!is_null($this->getRequestVar('category'))) {                    
                $data = $this->getRequestVar('category');
                foreach ($data as $key => $value) $data[$key] = $this->filterRequest($value, array (1,4,7));
                $category->setName($data['name']);
                $category->setIconPath($data['iconPath']);
                $category->setIsPrivate($data['isPrivate']);
                if($category->update()) {
                    $this->redirect('category/list', array('categoryedited=yes'));
                } else {
                    \messages::registerError(\language::returnLanguageConstant('SAVE_FAILED_CATEGORY'));
                }
            }

            $view = new \model\view_acp('category_editor');
            $view->assign('category', $category);   
            $view->assign('editormode', 1);
            $view->assign('systemmode', $this->getSysconfig()->getSystemMode());
            $view->assign('headlinetext', \language::returnLanguageConstant('HL_CATEGORIES_EDIT'));
            $view->assign('dtMask', $this->getSysconfig()->getDateTimeMask());
            $view->render();                
        } 
        
    }
?>