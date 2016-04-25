<?php
    if(!defined('VIEW')) die();
    $fields = array('pageButton'     => tools::removeUploadPath($affiliate->getPageButton()),
                    'pageName'       => $affiliate->getPageName(),
                    'pageUrl'        => $affiliate->getPageUrl(),
                    'pageAdminName'  => $affiliate->getPageAdminName(),
                    'pageAdminEmail' => $affiliate->getPageAdminEmail());
?>
<form method="post" action="">
    <div class="afltr-acp-top-buttons">
        <?php if($editormode == 0) : ?>
        <a href="#" class="buttons show-upload-dialog" title="<?php language::printLanguageConstant('FILES_UPLOAD_AC_NOTICE'); ?>"><?php language::printLanguageConstant('FILES_UPLOAD'); ?></a>
        <div class="afltr-divider-buttons"></div>
        <?php endif; ?> 
        <?php viewHelper::saveButton('submsave'); ?>
        <?php viewHelper::resetButton('subreset'); ?>
    </div>
    <h2><?php print $headlinetext; ?></h2>
    <div class="afltr-acp-form">
        <table class="afltr-acp-table">
        <?php if($editormode == 1) : ?>
            <tr>
                <td class="afltr-align-center small-text" colspan="2">
                    <?php print "<span class=\"afltr-td-label\">".language::returnLanguageConstant('ID').":</span> ".$affiliate->getId(); ?> &bull;
                    <?php print "<span class=\"afltr-td-label\">".language::returnLanguageConstant('AFFILIATE_AFFILIATEADDEDTIME').":</span> ".date($dtMask, $affiliate->getAffiliateAddedTime()); ?> &bull;
                    <?php print "<span class=\"afltr-td-label\">".language::returnLanguageConstant('AFFILIATE_AFFILIATEEDITEDTIME').":</span> ".date($dtMask, $affiliate->getAffiliateEditedTime()); ?>
                </td>
            </tr>   
        <?php endif; ?>  
        <?php foreach ($fields as $key => $value) : ?>
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('AFFILIATE_'.  strtoupper($key)) ?>:
                </td>
                <td class="afltr-padding-left"><input type="text" class="input-text afltr-affiliate-input-<?php print strtolower($key); ?> ui-state-default ui-corner-all" name="affiliate[<?php print $key; ?>]" size="50" maxlength="255" value="<?php print $value; ?>"></td>                
            </tr>
        <?php endforeach; ?>            
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('AFFILIATE_AFFILIATECATEGORY'); ?>:
                </td>
                <td class="afltr-padding-left">
                    <?php viewHelper::select('affiliate[affiliateCategory]', $categories, $affiliate->getAffiliateCategory()); ?>
                </td>
            </tr>                
            <?php if($editormode == 1) : ?>
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('AFFILIATE_AFFILIATEISMARKED'); ?>:
                </td>
                <td class="afltr-padding-left">
                    <?php viewHelper::select('affiliate[affiliateIsMarked]', $markedstatus, $affiliate->affiliateIsMarked(), false, false); ?>
                </td>
            </tr>
            <?php endif; ?>                
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('AFFILIATE_AFFILIATEISACCEPTED'); ?>:
                </td>
                <td class="afltr-padding-left">
                    <?php  viewHelper::boolSelect('affiliate[affiliateIsAccpted]', $affiliate->affiliateIsAccpted()); ?>
                </td>
            </tr>                                
        </table>
    </div>
    <script type="text/javascript">
        var afltrJsFileList = <?php print $fileList; ?>;
        jQuery('.afltr-affiliate-input-pagebutton').autocomplete({
            source: afltrJsFileList,
            minLength: 0
        });        
    </script>    
</form> 

<?php if($editormode == 0) include 'file_upload_form.php'; ?>