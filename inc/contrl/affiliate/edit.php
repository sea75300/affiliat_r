<?php
    /**
     * Affiliate edit controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace affiliate;
    use \contrl AS contrl;
    
    class edit extends contrl\base_contrl {

        public function process() {
            if(!parent::process()) $this->redirectNoSession();
                
            $affiliateId = $this->getRequestVar('affiliateid', array (1,4,7));

            if(is_null($affiliateId)) $this->redirect('affiliate/list');

            $affiliate = new \model\affiliate($this->getDbconnection(), $affiliateId);

            if(!is_null($this->getRequestVar('affiliate'))) {                    
                $data = $this->getRequestVar('affiliate');
                foreach ($data as $key => $value) $data[$key] = $this->filterRequest($value, array (1,4,7));
                $affiliate->setPageName($data['pageName']);
                $affiliate->setPageUrl($data['pageUrl']);
                $affiliate->setPageAdminName($data['pageAdminName']);
                $affiliate->setPageAdminEmail($data['pageAdminEmail']);
                $affiliate->setPageButton($data['pageButton']);
                $affiliate->setAffiliateCategory($data['affiliateCategory']);
                $affiliate->setAffiliateEditedTime(time());
                $affiliate->setAffiliateIsMarked($data['affiliateIsMarked']);
                $affiliate->setAffiliateIsAccpted($data['affiliateIsAccpted']);
                if($affiliate->update()) {
                    $this->redirect('affiliate/list', array('affiliateedited=yes'));
                } else {
                    \messages::registerError(\language::returnLanguageConstant('SAVE_FAILED_AFFILIATE'));
                }
            }

            $categoryList = new \model\category_list($this->getDbconnection());

            $categories = array();
            foreach ($categoryList->getCategories() as $category) {
                $categories[$category->getName().' ('.\language::returnLanguageConstant('ID').': '.$category->getId().')'] = $category->getId();
            }

            $view = new \model\view_acp('affiliate_editor');
            $view->assign('affiliate', $affiliate);   
            $view->assign('categories', $categories);
            $view->assign('editormode', 1);
            $view->assign('headlinetext', \language::returnLanguageConstant('HL_AFFILIATE_EDIT'));
            $view->assign('markedstatus', array(\language::returnLanguageConstant('NO_VALUE') => 0, \language::returnLanguageConstant('YES_VALUE') => 1));
            $view->assign('dtMask', $this->getSysconfig()->getDateTimeMask());
            $view->assign('fileList', new \model\file_list());
            $view->render();                
        } 
        
    }
?>