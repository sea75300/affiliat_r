<?php
    /**
     * Affiliate list controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace affiliate;
    use \contrl AS contrl;
    
    class lists extends contrl\base_contrl {        
         
        public function process() {
            if(!parent::process()) $this->redirectNoSession();

            if(!is_null($this->getRequestVar('affiliateDelList')) ) {
                $affiliateIds = $this->getRequestVar('affiliateDelList');                
                foreach ($affiliateIds as $affiliateId) {
                    $affiliate = new \model\affiliate($this->getDbconnection(), $this->filterRequest($affiliateId, array(1,4,7)));
                    $affiliate->delete();
                }                
                $this->redirect('affiliate/list', array('affiliatedeleted=yes'));
            }            
            
            $affiliateList = new \model\affiliate_list($this->getDbconnection());
            $affiliateList->setGroupByCategory(true);

            if(!is_null($this->getRequestVar('affiliateadded'))) {
                \messages::registerMessage(\language::returnLanguageConstant('SAVE_SUCCESS_ADDAFFILIATE'));
            }
            if(!is_null($this->getRequestVar('affiliateedited'))) {
                \messages::registerMessage(\language::returnLanguageConstant('SAVE_SUCCESS_EDITAFFILIATE'));
            }    
            if(!is_null($this->getRequestVar('affiliatedeleted'))) {
                \messages::registerMessage(\language::returnLanguageConstant('DELETE_SUCCESS_AFFILIATES'));
            }            

            $view = new \model\view_acp('affiliate_list');
            $view->assign('theList', $affiliateList->getAffiliates());
            $view->assign('dtMask', $this->getSysconfig()->getDateTimeMask());
            $view->render();   
        }
        
    }
?>