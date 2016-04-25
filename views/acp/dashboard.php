<?php if(!defined('VIEW')) die(); ?>
<h2><?php language::printLanguageConstant('HL_DASHBOARD'); ?></h2>
<div class="afltr-dashboard-containers">
    <?php foreach ($statsContainers as $statsContainer) : ?>
    <?php print $statsContainer; ?>
    <?php endforeach; ?>
</div>