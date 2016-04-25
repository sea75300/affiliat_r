<?php
    /**
     * Installer
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    define('MODE_INSTALL', 0);

    include dirname(__DIR__).'/inc/common.php';

    $controller = new \system\installer();
?>
