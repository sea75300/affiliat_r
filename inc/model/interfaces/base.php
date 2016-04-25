<?php
    /**
     * Model base
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    namespace interfaces;
    use model AS model;

    interface base {

        public function save();
        
        public function update();
        
        public function delete();
    }
?>