<?php if(defined('SHOW_ACP_NAV')) : ?>
<div class="afltr-navigation afltr-align-center">
    <a class="buttons" href="?module=system/dash"><?php language::printLanguageConstant('HL_DASHBOARD'); ?></a>
    <a class="buttons" href="?module=affiliate/list"><?php language::printLanguageConstant('HL_AFFILIATE_MNG'); ?></a>
    <a class="buttons" href="?module=category/list"><?php language::printLanguageConstant('HL_CATEGORIES_MNG'); ?></a>
    <a class="buttons" href="?module=banner/list"><?php language::printLanguageConstant('HL_LINKBUTTONS'); ?></a>
    <a class="buttons" href="?module=system/options"><?php language::printLanguageConstant('HL_OPTIONS'); ?></a>
    <a class="buttons" id="afltr-clear-cache" title="<?php language::printLanguageConstant('HL_CACHE_CLEAR'); ?>"><?php language::printLanguageConstant('HL_CACHE_CLEAR'); ?></a>
    <a class="buttons" href="?module=system/logout" title="<?php language::printLanguageConstant('LOGOUT_BTN'); ?>"><?php language::printLanguageConstant('LOGOUT_BTN'); ?></a>
</div>
<?php endif; ?>