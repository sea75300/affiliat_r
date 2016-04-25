<?php
    /**
     * Options controller
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace system;
    use \contrl AS contrl;
    
    class options extends contrl\base_contrl {
        
        public function process() {
            if(!parent::process()) $this->redirectNoSession();

            if(!is_null($this->getRequestVar('options'))) {
                
                $data        = $this->getRequestVar('options');
                $sysConfigObj= $this->getSysconfig();          
                
                if(!empty($data['loginPasswort']) && !$sysConfigObj->isPasswordSecure($data['loginPasswort'])) {
                    \messages::registerError(\language::returnLanguageConstant('SAVE_FAILED_PASSWORD'));
                    unset($data['loginPasswort']);                    
                }
                
                foreach ($data as $key => $value) {
                    if($value == '') continue;
                    $fn = 'set'.$key;
                    $sysConfigObj->$fn($this->filterRequest($value, array (1,4,7)));
                }
                $sysConfigObj->update();

                \messages::registerMessage(\language::returnLanguageConstant('SAVE_SUCCESS_OPTIONS'));
            }

            $fields = array(
                'adminMail'         => $this->getSysconfig()->getAdminMail(),
                'iframecss'         => $this->getSysconfig()->getIframecss(),                
                'sessionLength'     => $this->getSysconfig()->getSessionLength(),
                'timeZone'          => $this->getSysconfig()->getTimeZone(),
                'dateTimeMask'      => $this->getSysconfig()->getDateTimeMask(),
                'antispamQuestion'  => $this->getSysconfig()->getAntispamQuestion(),
                'antispamAnswer'    => $this->getSysconfig()->getAntispamAnswer()
            );

            $dtMasksArray = array('d.m.Y', 'd. M Y', 'd.n.Y', 'j.m.Y', 'j. M Y', 'j.n.Y', 'M dS Y', 'm/d/Y', 'n/d/Y');
            
            $dtMasks = array();
            foreach ($dtMasksArray as $dtMask) {
                $dtMasks[] = array('label' => $dtMask.' ('.date($dtMask).')', 'value' => $dtMask);
            }

            $timeZones = timezone_identifiers_list();            
            $timeZones = array_combine(array_values($timeZones), array_values($timeZones));            
            unset($timeZones['UTC']);
            
            $view = new \model\view_acp('options');            
            $view->assign('languages', \language::getLanguages());
            $view->assign('modes', array('iframe' => 1, 'phpcinlude' => 2));
            $view->assign('timeZones', array_unique($timeZones));
            $view->assign('syslang', $this->getSysconfig()->getSysLanguage());
            $view->assign('sysmode', $this->getSysconfig()->getSystemMode());
            $view->assign('dtMasks', json_encode($dtMasks));
            $view->assign('fields', $fields);
            $view->render();
        }
        
    }
?>