<?php if(!defined('VIEW')) die(); ?>
<div class="afltr-dialog" title="<?php language::printLanguageConstant('FILES_UPLOAD'); ?>">
    <form method="post" action="" enctype="multipart/form-data" id="afltr-banner-upload">
        <div class="afltr-acp-form afltr-acp-form-nomargin">
            <table class="afltr-acp-table afltr-padding-top">  
                <tr>
                    <td class="afltr-padding-left">
                        <input type="file" class="input-text ui-state-default ui-corner-all" name="pageButtonFile">
                    </td>
                </tr> 
                <tr class="afltr-hide">
                    <td colspan="2" class="buttons-line afltr-align-center">
                        <?php viewHelper::submitButton('submupload', ''); ?>
                        <?php viewHelper::resetButton('subreset'); ?>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>

<script type="text/javascript">
    var dialogUploadButtonDescr = '<?php language::printLanguageConstant('UPLOAD_BTN') ?>';
    var dialogResetButtonDescr = '<?php language::printLanguageConstant('RESET_BTN') ?>';
</script>