<div class="afltr-list afltr-banner-list">  
    <?php foreach ($fileList as $file) : ?>
        <?php if(count($maxSize)) : ?>  
            <?php if($file->getFileMeta(0) > $maxSize['width'] || $file->getFileMeta(1) > $maxSize['height']) : ?>   
                <?php continue; ?>    
            <?php endif; ?>    
        <?php endif; ?>
    
        <img class="afltr-banner-img" src="<?php print basename(base_config::$uploadDir); ?>/<?php print $file->getUrl(); ?>" alt="<?php print $file->getName(); ?>" <?php print $file->getFileMeta(3); ?>>
    <?php endforeach; ?>  
</div>

<!-- Powered by Affiliat*r <?php print $systemVersion; ?> - http://nobody-knows.org/download/affiliatr/ -->
