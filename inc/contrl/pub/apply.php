<?php
    /**
     * Apply controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace pub;
    use \contrl AS contrl;
    
    class apply extends contrl\base_contrl {
        
        private $isNotUtf8    = false;
        
        private $returnRender;
        
        function __construct($isNotUtf8) {
            parent::__construct();
            $this->isNotUtf8 = $isNotUtf8;
            $this->returnRender = false;
        }

        public function setReturnRender($returnRender) {
            $this->returnRender = $returnRender;
        }
        
        public function process() {
            
            $affiliate = new \model\affiliate($this->getDbconnection());

            if(!is_null($this->getRequestVar('submsave')) && !is_null($this->getRequestVar('antiSpamAnswer'))) {
                
                if($this->getRequestVar('antiSpamAnswer') === $this->getSysconfig()->getAntispamAnswer()) {
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
                    $affiliate->setAffiliateIsAccpted(0);
                    if($affiliate->save()) {
                        \messages::registerNotice(\language::returnLanguageConstant('APPLY_OK'));
                        
                        $catgory = new \model\category($this->dbconnection, $affiliate->getAffiliateCategory());
                        
                        $mailData = array(
                            'mailTo'        => $this->getSysconfig()->getAdminMail(),
                            'mailSubject'   => \language::replaceLanguageConstant(\language::returnLanguageConstant('APPLY_MAIL_SUBJECT'), array('{{affiliateKategory}}' => $catgory->getName())),
                            'mailText'      => \language::replaceLanguageConstant(
                                    \language::returnLanguageConstant('APPLY_MAIL_TEXT'),
                                    array('{{name}}'              => $affiliate->getPageAdminName(),
                                          '{{page}}'              => $affiliate->getPageUrl(),
                                          '{{affiliateKategory}}' => $catgory->getName(),
                                          '{{acpLink}}'           => \base_config::$rootPath)),
                            'mailFrom'      => $affiliate->getPageAdminEmail()
                        );                        
                        \messages::sendEMail($mailData);
                    } else {
                        \messages::registerError(\language::returnLanguageConstant('APPLY_FAILED'));
                    }

                    $affiliate = new \model\affiliate($this->getDbconnection());   
                } else {
                    \messages::registerError(\language::returnLanguageConstant('APPLY_FAILED_SPAM'));
                    
                }
            }

            $categoryList = new \model\category_list($this->getDbconnection(), false);

            $categories = array();
            foreach ($categoryList->getCategories() as $category) { $categories[$category->getName()] = $category->getId(); }

            $view = new \model\view_public('apply_form');
            $view->assign('affiliate', $affiliate);   
            $view->assign('categories', $categories);
            $view->assign('antiSpamQuestion', $this->getSysconfig()->getAntispamQuestion());
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