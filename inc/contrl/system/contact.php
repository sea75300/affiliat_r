<?php
    /**
     * Affiliate contact controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace system;
    use \contrl AS contrl;
    
    class contact extends contrl\base_contrl {

        public function process() {
            if(!parent::process()) $this->redirectNoSession();
                
            $affiliateIds = array($this->getRequestVar('affiliateid', array (1,4,7)));            
            $data = array('emailText' => '', 'mailSubject' => '');

            if(is_null($affiliateIds[0])) $this->redirect('affiliate/list');
            
            if(!is_null($this->getRequestVar('mailData'))) {
                $data = array_merge($data, $this->getRequestVar('mailData'));

                if(strpos($data['mailRecipients'], PHP_EOL) == false) { str_replace(PHP_EOL, ';', $data['mailRecipients']); }
                $recipients = explode(';', $data['mailRecipients']);
                
                $sendRecipients = array();
                
                $affiliateList = new \model\affiliate_list($this->dbconnection);
                foreach ($affiliateList->getAffiliateIdsByEmail($recipients) as $affiliateIdArr) {
                    $affiliate  = new \model\affiliate($this->getDbconnection(), $affiliateIdArr['id']);
                    $category = new \model\category($this->getDbconnection(), $affiliate->getAffiliateCategory());

                    $replacers = array(
                        'pagename'  => $affiliate->getPageName(),
                        'pageurl'   => $affiliate->getPageUrl(),
                        'adminname' => $affiliate->getPageAdminName(),
                        'adminmail' => $affiliate->getPageAdminEmail(),
                        'category'  => $category->getName()
                    );
                    
                    $mailtext = $data['emailText'];
                    foreach ($replacers as $key => $value) $mailtext = str_replace('{{'.$key.'}}', $value, $mailtext);

                    $mailData = array(
                        'mailTo'        => $affiliate->getPageAdminEmail(),
                        'mailSubject'   => $this->filterRequest($data['mailSubject'], array (1,4,7,2)),
                        'mailText'      => $this->filterRequest($mailtext, array (1,4,7,2)),
                        'mailFrom'      => 'affiliat_r_no_reply@'.$_SERVER['HTTP_HOST']
                    );                        

                    \messages::sendEMail($mailData);                       
                    $sendRecipients[] = $affiliate->getPageAdminEmail();
                }
                
                $mailtext = $data['emailText'];
                foreach ($replacers as $key => $value) $mailtext = str_replace('{{'.$key.'}}', '', $mailtext);
                foreach ($recipients as $recipient) {
                    if(in_array($recipient, $sendRecipients)) continue;
                    $mailData = array(
                        'mailTo'        => $recipient,
                        'mailSubject'   => $this->filterRequest($data['mailSubject'], array (1,4,7,2)),
                        'mailText'      => $this->filterRequest($mailtext, array (1,4,7,2)),
                        'mailFrom'      => 'affiliat_r_no_reply@'.$_SERVER['HTTP_HOST']
                    );

                    \messages::sendEMail($mailData);                     
                }
                
                $this->redirect('affiliate/list');
            } else {
                $affiliate  = new \model\affiliate($this->getDbconnection(), $affiliateIds[0]);
                $recipients = array($affiliate->getPageAdminEmail());
            }

            $data['recipients'] = implode(';', $recipients);
            
            $view = new \model\view_acp('contact');
            foreach ($data as $key => $value) { $view->assign($key, $value); }
            $view->render();                
        } 
        
    }
?>