<?php
    /**
     * Affiliates ausgeben
     * @author Stefan Seehafer <sea75300@yahoo.de>
     * @copyright (c) 2013-2015, Stefan Seehafer
     * @license http://www.gnu.org/licenses/gpl.txt GPLv3
     */

    include __DIR__.'/affiliatr_functions.php';

    $baseCtrl = new \contrl\base_contrl();
    $config   = new model\system_config($baseCtrl->getDbconnection());
    
    if($config->getSystemMode() == 2) die(basename (__FILE__).' should be used with system mode "iframe"!');
    
    $textToBool = array('true' => true, 'false' => false);
        
    $categoryId     = $baseCtrl->getRequestVar('category');
    $acceptedOnly   = is_null($baseCtrl->getRequestVar('acceptedonly')) ? true : $textToBool[$baseCtrl->getRequestVar('acceptedonly')];
    $textOnly       = is_null($baseCtrl->getRequestVar('textonly')) ? 0 : (int) $baseCtrl->getRequestVar('textonly');
    $openBlank      = is_null($baseCtrl->getRequestVar('openblank')) ? false : $textToBool[$baseCtrl->getRequestVar('openblank')];   
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
    <?php if(!is_null($categoryId)) : ?>
        
        <?php affiliatr::showAffiliates((int) $categoryId, $acceptedOnly, $textOnly, $openBlank); ?>
        
    <?php else : ?>
        
        <?php
            $categories = new \model\category_list($baseCtrl->getDbconnection());
            $categories = $categories->getCategories();           
        ?>

        <?php foreach ($categories as $id => $category) : ?>

            <h3><?php print $category->getName(); ?></h3>

            <?php affiliatr::showAffiliates($id, $acceptedOnly, $textOnly, $openBlank); ?>

        <?php endforeach; ?>
    
    <?php endif; ?>
    </body>
</html>