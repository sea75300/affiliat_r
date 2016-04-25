<?php if(!defined('VIEW')) die(); ?>
<form method="post" action="">
    <div class="afltr-acp-top-buttons">
        <?php viewHelper::submitButton('submmail', language::returnLanguageConstant('SENDMAIL_BTN')); ?>
        <?php viewHelper::resetButton('subreset'); ?>
    </div>
    <h2><?php language::printLanguageConstant('HL_CONTACT'); ?></h2>
    <div class="afltr-acp-form">
        <table class="afltr-acp-table">
            <tr>
                <td class="afltr-td-label afltr-align-right afltr-acp-td-w2">
                    <?php language::printLanguageConstant('CONTACT_RECIPIENT'); ?>:
                </td>
                <td class="afltr-padding-left">                    
                    <input type="text" class="input-text ui-state-default ui-corner-all" name="mailData[mailRecipients]" size="50" maxlength="255" value="<?php print $recipients; ?>">
                </td>
                <td class="afltr-align-center ui-corner-all" style="vertical-align:top;">
                    <p><?php language::printLanguageConstant('CONTACT_RECIPIENT_ADDITIONAL'); ?></p>
                </td>                
            </tr>               
            <tr>
                <td class="afltr-td-label afltr-align-right afltr-acp-td-w2">
                    <?php language::printLanguageConstant('CONTACT_SUBJECT'); ?>:
                </td>
                <td class="afltr-padding-left">
                    <input type="text" class="input-text ui-state-default ui-corner-all" name="mailData[mailSubject]" size="50" maxlength="255" value="<?php print $mailSubject; ?>">
                </td>
                <td class="afltr-align-center ui-state-highlight ui-corner-all" style="vertical-align:top;" rowspan="2">
                    <p class="afltr-td-label"><?php language::printLanguageConstant('CONTACT_TEXT_REPLACER'); ?></p>
                    <p class="afltr-align-left afltr-padding-left">
                        <span class="afltr-span-fixed-size afltr-acp-td-w5 afltr-td-label"><?php language::printLanguageConstant('AFFILIATE_PAGENAME') ?>:</span> {{pagename}}<br>
                        <span class="afltr-span-fixed-size afltr-acp-td-w5 afltr-td-label"><?php language::printLanguageConstant('AFFILIATE_PAGEURL') ?>:</span> {{pageurl}}<br>
                        <span class="afltr-span-fixed-size afltr-acp-td-w5 afltr-td-label"><?php language::printLanguageConstant('AFFILIATE_PAGEADMINNAME') ?>:</span> {{adminname}}<br>
                        <span class="afltr-span-fixed-size afltr-acp-td-w5 afltr-td-label"><?php language::printLanguageConstant('AFFILIATE_PAGEADMINEMAIL') ?>:</span> {{adminmail}}<br>
                        <span class="afltr-span-fixed-size afltr-acp-td-w5 afltr-td-label"><?php language::printLanguageConstant('AFFILIATE_AFFILIATECATEGORY') ?>:</span> {{category}}</p>
                    <p class="small-text">
                        <?php language::printLanguageConstant('CONTACT_TEXT_REPLACER_NOTICE') ?>
                    </p>
                </td>
            </tr>                               
            <tr>
                <td class="afltr-td-label afltr-align-right afltr-acp-table-td-top afltr-acp-td-w2">
                    <?php language::printLanguageConstant('CONTACT_TEXT'); ?>:
                </td>
                <td class="afltr-padding-left">
                    <textarea class="input-text input-textarea ui-state-default ui-corner-all" name="mailData[emailText]"><?php print $emailText; ?></textarea>
                </td>
            </tr>                                
        </table>
    </div>   
</form> 