<?php
    /**
     * Logout controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace system;
    use \contrl AS contrl;
    
    class logout extends contrl\base_contrl {
        
        function process() {
            if(!is_null($this->getRequestVar('nologin'))) {
                \messages::registerError(\language::returnLanguageConstant('NO_LOGIN'));
            }
            
            $sessionCookieValue = $this->getSessionCookieValue();
            if(!is_null($sessionCookieValue)) {
                
                $session = new \model\session($this->getDbconnection(), $sessionCookieValue);
                if($session->exists()) {                    
                
                    $session->setLogout(time());
                    $session->update();
                            
                    setcookie('afltrsid', '', 0, '/', $_SERVER["SERVER_NAME"], false, true);
                    
                    header('Location: index.php');                    
                }                
            }
        }

    }
?>
