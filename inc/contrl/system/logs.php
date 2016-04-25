<?php
    /**
     * Logs controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace system;
    use \contrl AS contrl;
    
    class logs extends contrl\base_contrl {
        
        public function process() {
            if(!parent::process()) $this->redirectNoSession();

            $view           = new \model\view_acp('logs');
            $errorLogLines  = array(); 
            $systemLogLines = array();
            
            if(!is_null($this->getRequestVar('submdelete'))) {
                if(file_exists(\base_config::$logfiles['errors'])) @unlink(\base_config::$logfiles['errors']);
                if(file_exists(\base_config::$logfiles['system'])) @unlink(\base_config::$logfiles['system']);
            }
            
            if(file_exists(\base_config::$logfiles['errors'])) {
                $errorLogs     = file(\base_config::$logfiles['errors']);           
                foreach ($errorLogs as $errorLine) {
                    $errorLine = json_decode(trim($errorLine), true);                        
                    if(empty($errorLine['text'])) continue;
                    $errorLogLines[] = "<p><b>".date($this->getSysconfig()->getDateTimeMask(), $errorLine['time']).":</b> ".$errorLine['text'].'</p>'.PHP_EOL;
                }        
            }
            
            if(file_exists(\base_config::$logfiles['system'])) {
                $systemLogs     = file(\base_config::$logfiles['system']);
                foreach ($systemLogs as $systemLine) {
                    $systemLine = json_decode(trim($systemLine), true);                        
                    if(empty($systemLine['text'])) continue;
                    $systemLogLines[] = "<p><b>".date($this->getSysconfig()->getDateTimeMask(), $systemLine['time']).":</b> ".$systemLine['text'].'</p>'.PHP_EOL;
                }             
            }    
            
            $view->assign('errorLogLines', $errorLogLines);
            $view->assign('systemLogLines', $systemLogLines);    
            $view->render();
        }
        
    }
?>