<div class="afltr-list afltr-list-<?php print $categoryNameClass; print $showastext; ?>">  
    <?php if(isset($notaffiliates)) : ?>
    -
    <?php else : ?>
    
        <?php if($showastext == 2) : ?><ul><?php endif; ?>
    
        <?php foreach ($affiliates as $affiliateId => $affiliate) : ?>
            <?php $affiliate->setLinkTarget($linkTarget); ?>
            <?php if($showastext == 2) : ?><li><?php endif; ?>
                <?php print $affiliate; ?>                
            <?php if($showastext == 2) : ?></li><?php endif; ?>
        <?php endforeach; ?>           
        
        <?php if($showastext == 2) : ?></ul><?php endif; ?>
    <?php endif; ?>
</div>

<!-- Powered by Affiliat*r <?php print $systemVersion; ?> - http://nobody-knows.org/download/affiliatr/ -->
