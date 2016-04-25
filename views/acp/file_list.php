<?php if(!defined('VIEW')) die(); ?>
<form method="post" action="">
    <div class="afltr-acp-top-buttons">
        <a href="#" class="buttons show-upload-dialog"><?php language::printLanguageConstant('FILES_UPLOAD'); ?></a>
        <?php viewHelper::submitButton('submdelete', language::returnLanguageConstant('DELETE_BTN'), 'submdelete'); ?>
    </div>
    <h2><?php language::printLanguageConstant('HL_FILES_MNG'); ?></h2>
    <div class="afltr-acp-list">
            <table class="afltr-acp-table">
                <tr>
                    <th class="afltr-padding-left afltr-align-left"><?php language::printLanguageConstant('FILES_NAME'); ?></th>
                    <th class="afltr-acp-td-w4 afltr-align-left"><?php language::printLanguageConstant('FILES_METAINFOS'); ?></th>
                    <th class="afltr-acp-td-35px afltr-align-center"><input type="checkbox" id="afltr-checkbox-selectall"></th>
                </tr>        
            <?php foreach ($fileList as $file) : ?>
                <tr class="afltr-bg-toggle">
                    <td class="afltr-padding-left afltr-align-left afltr-acp-table-td-top"><a target="_blank" class="afltr-file-liste-link afltr-link afltr-link-files" href="<?php print $file->getUrl(); ?>"><?php print $file->getName(); ?></a></td>
                    <td class="afltr-acp-td-w4 afltr-align-left">
                        <?php print $file->getResolution(); ?><br>
                        <b class="afltr-file-list-label"><?php language::printLanguageConstant('FILES_UPLOADEDON'); ?>:</b> <?php print date($dtMask, $file->getCreatedTime()) ?>
                    </td>
                    <td class="afltr-acp-td-35px afltr-align-center"><input type="checkbox" class="afltr-checkbox" name="fileDelList[]" value="<?php print $file->getName(); ?>"></td>
                </tr>  
            <?php endforeach; ?>             
            </table>
    </div>
</form>

<?php include 'file_upload_form.php'; ?>