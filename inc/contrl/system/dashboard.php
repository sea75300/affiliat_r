<?php
    /**
     * Dashboard controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace system;
    use \contrl AS contrl;
    
    class dashboard extends contrl\base_contrl {

        public function process() {
            if(!parent::process()) $this->redirectNoSession();

            $containers = array();
            
            $containerClassFiles = scandir(\base_config::$baseDir.'/inc/dashcontainers/');
            foreach ($containerClassFiles as $containerClassFile) {
                if(strpos($containerClassFile, '.php') === false) { continue; }
                
                $containerClassFile = str_replace('.php', '', $containerClassFile);                
                $containerObject = new $containerClassFile($this);
                
                if(is_a($containerObject, '\interfaces\dashcontainer')) {                    
                    $containerPosition = $containerObject->getPosition();                    
                    if(isset($containers[$containerPosition])) { $containerPosition++; }                    
                    $containers[$containerPosition] = new \model\dashboard_container($containerObject->getBoxName(),$containerObject->getBoxHeadline(),$containerObject->getBoxContent(),$containerObject->getSize(),$containerObject->getHeight());
                } else {                    
                    $message = \language::replaceLanguageConstant(\language::returnLanguageConstant('DASH_CONTAINER_INSTANCE'), array('{{dashcontainer}}' => $containerClassFile));
                    \messages::registerError($message);
                }              
            }      	            

            if(count($containers) >= 1) ksort($containers);
            
            $view = new \model\view_acp('dashboard');
            $view->assign('statsContainers', $containers);
            $view->render();   
        }

    }
?>