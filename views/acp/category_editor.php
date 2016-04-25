<?php if(!defined('VIEW')) die(); ?>
<?php $iconPath = tools::removeUploadPath($category->getIconPath()); ?>
<form method="post" action="">
    <div class="afltr-acp-top-buttons">
        <?php if($editormode == 0) : ?>
        <a href="#" class="buttons show-upload-dialog" title="<?php language::printLanguageConstant('FILES_UPLOAD_AC_NOTICE'); ?>"><?php language::printLanguageConstant('FILES_UPLOAD'); ?></a>        
        <?php endif; ?>
        <?php if($editormode == 1) : ?>
        <a href="#" class="buttons show-integration-dialog"><?php language::printLanguageConstant('CATEGORY_INTEGRATION'); ?></a>        
        <?php endif; ?>        
        <div class="afltr-divider-buttons"></div>
        <?php viewHelper::saveButton('submsave'); ?>
        <?php viewHelper::resetButton('subreset'); ?>
    </div>
    <h2><?php print $headlinetext; ?></h2>
    <div class="afltr-acp-form">       
        <table class="afltr-acp-table">           
        <?php if($editormode == 1) : ?>
            <tr>
                <td class="afltr-align-center small-text" colspan="2">
                    <span class="afltr-td-label"><?php print language::printLanguageConstant('ID'); ?>:</span> <?php print $category->getId(); ?>
                </td>
            </tr>              
        <?php endif; ?>                   
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('CATEGORY_NAME'); ?>:
                </td>
                <td class="afltr-padding-left"><input type="text" class="input-text ui-state-default ui-corner-all" name="category[name]" size="50" maxlength="255" value="<?php print $category->getName(); ?>"></td>
            </tr>                
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('CATEGORY_ICONPATH'); ?>:
                </td>
                <td class="afltr-padding-left"><input type="text" class="input-text ui-state-default ui-corner-all" name="category[iconPath]" size="50" maxlength="255" value="<?php print $iconPath; ?>"></td>
            </tr>
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('CATEGORY_PRIVATE'); ?>:
                </td>
                <td class="afltr-padding-left"><?php viewHelper::boolSelect('category[isPrivate]', $category->isPrivate()); ?></td>
            </tr>              
            </table>
    </div>
</form>
<?php if($editormode == 0) include 'file_upload_form.php'; ?>
<?php if($editormode == 1) include 'category_integration_form.php'; ?>