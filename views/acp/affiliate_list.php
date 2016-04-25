<?php if(!defined('VIEW')) die(); ?>
<form method="post" action="">
    <div class="afltr-acp-top-buttons">
        <a class="buttons afltr-add-btn" href="?module=affiliate/add"><?php language::printLanguageConstant('HL_AFFILIATE_ADD'); ?></a>
        <?php viewHelper::submitButton('submdelete', language::returnLanguageConstant('DELETE_BTN'), 'submdelete'); ?>
    </div>
    <h2><?php language::printLanguageConstant('HL_AFFILIATE_MNG'); ?></h2>
    <div class="afltr-acp-list">
        <table class="afltr-acp-table">
            <tr>
                <th class="afltr-list-marked"></th>
                <th class="afltr-acp-td-35px afltr-align-center"></th>
                <th class="afltr-padding-left afltr-align-left"><?php language::printLanguageConstant('AFFILIATE_PAGENAME'); ?></th>
                <th class="afltr-acp-td-w3 afltr-align-center"><?php language::printLanguageConstant('AFFILIATE_PAGEADMINNAME'); ?></th>
                <th class="afltr-acp-td-w1 afltr-align-center"><?php language::printLanguageConstant('AFFILIATE_AFFILIATECATEGORY'); ?></th>
                <th class="afltr-acp-td-w1 afltr-align-center"><?php language::printLanguageConstant('AFFILIATE_AFFILIATEEDITEDTIME'); ?></th>
                <th class="afltr-acp-td-w0 afltr-align-center"><?php language::printLanguageConstant('AFFILIATE_AFFILIATEISMARKED'); ?></th>
                <th class="afltr-acp-td-w0 afltr-align-center"><?php language::printLanguageConstant('AFFILIATE_AFFILIATEISACCEPTED'); ?></th>
                <th class="afltr-acp-td-35px afltr-align-center"><input type="checkbox" id="afltr-checkbox-selectall"></th>
            </tr>        
        <?php foreach ($theList as $category => $affiliateList) : ?>
            <tr class="afltr-bg-toggle afltr-affiliate-list">
                <td colspan="9">
                    <h3><?php print $category; ?></h3>
                </td>
            </tr>
            <?php if(count($affiliateList) == 0) : ?>
            <tr><td class="afltr-padding-left">-</td></tr>
            <?php endif; ?>
            <?php foreach ($affiliateList as $affiliateId => $affiliate) : ?>
                <?php $pageButton = $affiliate->getPageButton(); ?>
                <tr class="afltr-bg-toggle afltr-bg-accepted<?php print $affiliate->affiliateIsAccpted(); ?> afltr-bg-marked<?php print $affiliate->affiliateIsMarked(); ?>">
                    <td class="afltr-list-marked<?php print $affiliate->affiliateIsMarked(); ?>"></td>
                    <td class="afltr-acp-td-35px afltr-align-center afltr-padding-left"><a class="buttons" href="index.php?module=affiliate/edit&affiliateid=<?php print $affiliate->getId(); ?>" title="<?php language::printLanguageConstant('EDIT_BTN'); ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
                    <td class="afltr-padding-left afltr-align-left afltr-overflow-hidden">                    
                        <a class="afltr-link" href="<?php print $affiliate->getPageUrl(); ?>" target="_blank">
                        <?php if(!empty($pageButton)) : ?>
                        <img src="<?php print $pageButton; ?>" alt="<?php print $affiliate->getPageName(); ?>" title="<?php print $affiliate->getPageName(); ?>">
                        <?php else: ?>                    
                        <?php print $affiliate->getPageName(); ?>
                        <?php endif; ?></a></td>
                    <td class="afltr-acp-td-w3 afltr-align-center"><a class="afltr-link show-upload-dialog" href="?module=system/contact&affiliateid=<?php print $affiliate->getId(); ?>"><?php print $affiliate->getPageAdminName(); ?></a></td>
                    <td class="afltr-acp-td-w1 afltr-align-center"><?php print $affiliate->getAffiliateCategory(); ?></td>
                    <td class="afltr-acp-td-w1 afltr-align-center"><?php if($affiliate->getAffiliateEditedTime() > 0) print date($dtMask, $affiliate->getAffiliateEditedTime()); else print date($dtMask, $affiliate->getAffiliateAddedTime()); ?></td>
                    <td class="afltr-acp-td-w0 afltr-align-center"><?php viewHelper::boolToText($affiliate->affiliateIsMarked()); ?></td>
                    <td class="afltr-acp-td-w0 afltr-align-center"><?php viewHelper::boolToText($affiliate->affiliateIsAccpted()); ?></td>
                    <td class="afltr-acp-td-35px afltr-align-center"><input type="checkbox" class="afltr-checkbox" name="affiliateDelList[]" value="<?php print $affiliate->getId(); ?>"></td>
                </tr>  
            <?php endforeach; ?>
        <?php endforeach; ?>
        </table>
    </div>
</form>