<?php
    /**
     * Affiliate contact controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace system;
    use \contrl AS contrl;
    
    class cache extends contrl\base_contrl {

        public function process() {
            if(!parent::process()) $this->redirectNoSession();

            $file = new \model\file();
            if(!unlink(\base_config::$updateCache)) {
                \messages::logSystem('Unable to clear cache!');
                \messages::registerError(\language::returnLanguageConstant('CACHE_CLEARED_FAILED'));
            } else {
                \messages::registerMessage(\language::returnLanguageConstant('CACHE_CLEARED_OK'));
            }

            \messages::showMessages();
            die();
            
        } 
        
    }
?>