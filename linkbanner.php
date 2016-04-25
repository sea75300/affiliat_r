<?php
    /**
     * Bewerbungsform ausgeben
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */
    include __DIR__.'/affiliatr_functions.php';

    $baseCtrl = new \contrl\base_contrl();
    $config   = new model\system_config($baseCtrl->getDbconnection());

    if($config->getSystemMode() == 2) die(basename (__FILE__).' should be used with system mode "iframe"!');
    
    $maxSize = array();

    $maxWidth   = $baseCtrl->getRequestVar('maxwidth');
    $maxHeight  = $baseCtrl->getRequestVar('maxheight');
    
    if(!is_null($maxWidth)) { $maxSize['width'] = $maxWidth; }
    if(!is_null($maxHeight)) { $maxSize['height'] = $maxHeight; }
    
?>
<!DOCTYPE HTML>
<HTML lang="de">
    <head>
        <title>Affiliat*r - <?php print $config->getSysVersion(); ?></title>
        <meta http-equiv="content-type" content= "text/html; charset=utf-8">
        <meta name="robots" content="noindex, nofollow">  
        <link rel="stylesheet" type="text/css" href="<?php print $config->getIframecss(); ?>">
    </head> 
    
    <body>
        <?php affiliatr::showLinkbanner(false, $maxSize); ?>
    </body>
</html>