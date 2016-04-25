<!DOCTYPE HTML>
<HTML lang="de">
    <head>
        <title>Affiliat*r - <?php print \language::printLanguageConstant('ACP'); ?></title>
        <meta http-equiv="content-type" content= "text/html; charset=utf-8">
        <meta name="robots" content="noindex, nofollow">  
         
    <?php foreach ($this->getViewCssFiles() as $cssFile) : ?>
        <link rel="stylesheet" type="text/css" href="<?php print $relroot.$cssFile; ?>">
    <?php endforeach; ?>
        
    <?php foreach ($this->getViewJsFiles() as $JsFile) : ?>
        <script type="text/javascript" src="<?php print $relroot.$JsFile; ?>"></script>
    <?php endforeach; ?>        
    </head> 
    
    <body>
        <div class="afltr-bg-gradient"></div>
        
        <div class="afltr-wrapper">
            
            <div class="afltr-header">                
                <h1>Affiliat*r <span class="afltr-system-version"><?php print $systemVersion; ?></span></h1>
            </div>
  
            <?php if(!defined('MODE_INSTALL')) include_once base_config::$baseDir.'/style/navigation.php'; ?>

            <div id="afltr-message-div">
            <?php messages::showMessages(); ?>
            </div>

            <div class="afltr-contentbox">
                
            
        
    