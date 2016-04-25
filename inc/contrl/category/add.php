<?php
    /**
     * Category add controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace category;
    use \contrl AS contrl;
    
    class add extends contrl\base_contrl {
        
        public function process() {
            if(!parent::process()) $this->redirectNoSession();

            $category = new \model\category($this->getDbconnection());

            if(!is_null($this->getRequestVar('submupload'))) {                    
                $newFile = new \model\file();
                $icon = $newFile->uploadFile();
                $category->setIconPath($icon);
            }            
            
            if(!is_null($this->getRequestVar('category'))) {                    
                $data = $this->getRequestVar('category');
                foreach ($data as $key => $value) $data[$key] = $this->filterRequest($value, array (1,4,7));
                $category->setName($data['name']);
                $category->setIconPath($data['iconPath']);
                $category->setIsPrivate($data['isPrivate']);
                if($category->save()) {
                    $this->redirect('category/list', array('categoryadded=yes'));
                } else {
                    \messages::registerError(\language::returnLanguageConstant('SAVE_FAILED_CATEGORY'));
                }
            } else {
                $category->setIsPrivate(0);
            }

            $view = new \model\view_acp('category_editor');
            $view->assign('category', $category);   
            $view->assign('editormode', 0);
            $view->assign('headlinetext', \language::returnLanguageConstant('HL_CATEGORIES_ADD'));
            $view->render();                   
        }
    }
?>