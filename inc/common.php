<?php
    /**
     * Common inits
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    if(version_compare(PHP_VERSION, '5.3.3', '<')) die('Affiliat*r does not support php version prior to PHP 5.3.3!');

    include __DIR__.'/class/base_config.php';
    include __DIR__.'/functions.php';
    
    set_error_handler("errorHandler");   
    spl_autoload_register('autoLoader');
    
    base_config::init();
?>