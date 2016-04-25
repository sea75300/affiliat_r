<?php
    /**
     * Login controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace system;
    use \contrl AS contrl;
    
    class login extends contrl\base_contrl {
        
        public function process() {
            if(!is_null($this->getRequestVar('nologin'))) {
                \messages::registerError(\language::returnLanguageConstant('NO_LOGIN'));
            }
            if(!is_null($this->getRequestVar('nopassreset'))) {
                \messages::registerError(\language::returnLanguageConstant('LOGIN_PASSWORD_RESET_FAILED'));
            }            
            
            if(!is_null($this->getRequestVar('resetpass'))) {               
                $newPass = uniqid();
                $mailData = array(
                    'mailTo'        => $this->getSysconfig()->getAdminMail(),
                    'mailSubject'   => \language::returnLanguageConstant('LOGIN_PASSWORD_RESET'),
                    'mailText'      => $newPass,
                    'mailFrom'      => 'affiliat_r_no_reply@'.$_SERVER['HTTP_HOST']
                );                  
                if(\messages::sendEMail($mailData)) {
                    $this->getSysconfig()->setLoginPasswort($newPass);
                    $this->getSysconfig()->update();                    
                    $this->redirect();
                } else {
                    $this->redirect('', array('nopassreset'));
                }
                
                
            }
            
            $sessionCookieValue = $this->getSessionCookieValue();
            if(!is_null($sessionCookieValue)) {
                
                $session = new \model\session($this->getDbconnection(), $sessionCookieValue);
                if($session->exists()) { $this->redirect('system/dash'); }
            }
            
            if(!is_null($this->getRequestVar('passwd', array (1,4,7)))) {                
                $passwort = \tools::createPasswordHash($this->getRequestVar('passwd'), $this->getSysconfig()->getLoginPasswortSalt());
                if($passwort == $this->getSysconfig()->getLoginPasswort()) {
                    $ip = $_SERVER["REMOTE_ADDR"];
                    
                    $sessionId = sha1(uniqid($ip, true));
                    
                    $expire = time() + $this->getSysconfig()->getSessionLength();

                    $session = new \model\session($this->getDbconnection());                    
                    $session->setLogin(time());
                    $session->setLogout(0);
                    $session->setSessionId($sessionId);
                    $session->setIp($ip);
                    $session->save();
                            
                    setcookie('afltrsid', $sessionId, $expire, '/', $_SERVER["SERVER_NAME"], false, true);
                    
                    $this->redirect('system/dash');
                }                
                
                \messages::registerError(\language::returnLanguageConstant('WRONG_PASSWORD'));
            }
            
            $view = new \model\view_acp('login');
            
            $view->assign('defaultPW', '');
            
            $view->render();            
            
        }

    }
?>
