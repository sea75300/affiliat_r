<?php
    /**
     * Affiliater class
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    include_once __DIR__.'/inc/common.php';
    include_once __DIR__.'/inc/controllers.php';

    final class affiliatr {
        
        /**
         * Affiliates anzeigen
         * @param int $categoryId
         * @param bool $acceptedOnly
         * @param int $textOnly
         * @param bool $openBlank
         * @param string $view
         * @param bool $isNotUtf8
         */
        public static function showAffiliates($categoryId, $acceptedOnly = true, $textOnly = 0, $openBlank = false, $view = null, $isNotUtf8 = false) {
            $controller = new \pub\affiliate_list($categoryId, $view, $acceptedOnly, $textOnly, $openBlank, $isNotUtf8);
            return $controller->process();      

            unset($controller);
        }
        
        /**
         * Affiliate apply form anzeigen
         * @param bool $isNotUtf8
         */
        public static function applyForm($isNotUtf8 = false) {
            $controller = new \pub\apply($isNotUtf8);
            $controller->process();         
            
            unset($controller);
        }
        
        /**
         * Link-us-Banner anzeigen
         * @param bool $isNotUtf8
         */
        public static function showLinkbanner($isNotUtf8 = false, $maxSize = array()) {
            $controller = new \pub\linkbanner($isNotUtf8, $maxSize);
            $controller->process();         
            
            unset($controller);
        }        
    }  
?>