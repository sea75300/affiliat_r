<?php
    /**
     * Dashboard conatiner boxcontent
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2014, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace interfaces;
    use model AS model;
    
    interface dashcontainer {

        public function getBoxContent();
        
        public function getBoxHeadline();
        
        public function getBoxName();        
        
        public function getPosition();
        
        public function getSize();
        
        public function getHeight();
        
    }
