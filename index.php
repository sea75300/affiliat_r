<?php
    /**
     * Index, main file
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    include __DIR__.'/inc/common.php';
    include __DIR__.'/inc/controllers.php';
    
    date_default_timezone_set('Europe/Berlin');
    
    $module = (isset($_GET['module'])) ? contrl\base_contrl::filterRequest($_GET['module'], array(1,4,7)) : '';

    $controllerName = (isset($controllers[$module])) ? $controllers[$module] : 'system\login';
    
    if(!class_exists($controllerName)) die("The controller class <b>$module</b> does not exist!");    
    
    $controller = new $controllerName();    
    if(!is_a($controller, 'contrl\base_contrl')) die("The controller module <b>$module</b> must be an instance of <b>contrl\base_contrl</b> and contain a method <b>process()</b>!");    
    $controller->process();    
    
?>