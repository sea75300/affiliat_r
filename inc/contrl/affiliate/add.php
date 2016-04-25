<?php
    /**
     * Affiliate list controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace affiliate;
    use \contrl AS contrl;
    
    class add extends contrl\base_contrl {
        
        public function process() {
            if(!parent::process()) $this->redirectNoSession();            
            
            $affiliate = new \model\affiliate($this->getDbconnection());

            if(!is_null($this->getRequestVar('submupload'))) {                    
                $newFile = new \model\file();
                $pageButton = $newFile->uploadFile();
                $affiliate->setPageButton($pageButton);
            }

            if(!is_null($this->getRequestVar('affiliate'))) {                    
                $data = $this->getRequestVar('affiliate');
                foreach ($data as $key => $value) $data[$key] = $this->filterRequest($value, array (1,4,7));
                $affiliate->setPageName($data['pageName']);
                $affiliate->setPageUrl($data['pageUrl']);
                $affiliate->setPageAdminName($data['pageAdminName']);
                $affiliate->setPageAdminEmail($data['pageAdminEmail']);
                $affiliate->setPageButton($data['pageButton']);
                $affiliate->setAffiliateCategory($data['affiliateCategory']);
                $affiliate->setAffiliateAddedTime(time());
                $affiliate->setAffiliateEditedTime(0);
                $affiliate->setAffiliateIsMarked(0);
                $affiliate->setAffiliateIsAccpted($data['affiliateIsAccpted']);
                if($affiliate->save()) {
                    $this->redirect('affiliate/list', array('affiliateadded=yes'));
                } else {
                    \messages::registerError(\language::returnLanguageConstant('SAVE_FAILED_AFFILIATE'));
                }
            } else {
                $affiliate->setAffiliateIsAccpted(0);
            }

            $categoryList = new \model\category_list($this->getDbconnection());

            $categories = array();
            foreach ($categoryList->getCategories() as $category) {
                $categories[$category->getName().' ('.\language::returnLanguageConstant('ID').': '.$category->getId().')'] = $category->getId();
            }

            $view = new \model\view_acp('affiliate_editor');
            $view->assign('affiliate', $affiliate);   
            $view->assign('categories', $categories);
            $view->assign('editormode', 0);
            $view->assign('headlinetext', \language::returnLanguageConstant('HL_AFFILIATE_ADD'));
            $view->assign('fileList', new \model\file_list());
            $view->render();                    
        }
    }
?>