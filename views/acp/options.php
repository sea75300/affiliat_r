<?php if(!defined('VIEW')) die(); ?>
<form method="post" action="">
    <div class="afltr-acp-top-buttons">
        <a class="buttons afltr-options-btns" href="?module=system/files"><?php language::printLanguageConstant('HL_FILES_MNG'); ?></a>
        <a class="buttons afltr-options-btns" href="?module=system/logs"><?php language::printLanguageConstant('HL_LOGS_SYSTEM'); ?></a>
        <div class="afltr-divider-buttons"></div>
        <?php viewHelper::saveButton('submsave'); ?>
        <?php viewHelper::resetButton('subreset'); ?>
    </div>    
    <h2><?php language::printLanguageConstant('HL_OPTIONS'); ?></h2>
    <div class="afltr-acp-form">
        <table class="afltr-acp-table">
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('OPTIONS_LOGINPASSWORT') ?>:
                </td>
                <td class="afltr-padding-left afltr-align-left">
                    <input type="password" class="input-text ui-state-default ui-corner-all" name="options[loginPasswort]" size="50" maxlength="255" value="" title="<?php language::printLanguageConstant('SAVE_FAILED_PASSWORD'); ?>">
                </td>                
            </tr>                   
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('OPTIONS_SYSLANGUAGE'); ?>:
                </td>
                <td class="afltr-padding-left afltr-align-left">
                    <?php viewHelper::select('options[sysLanguage]', $languages, $syslang, false, false); ?>
                </td>
            </tr> 
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('OPTIONS_SYSTEMMODE'); ?>:
                </td>
                <td class="afltr-padding-left afltr-align-left">
                    <?php viewHelper::select('options[systemMode]', $modes, $sysmode, false, false); ?>                   
                </td>
            </tr>              
        <?php foreach ($fields as $key => $value) : ?>

            <tr<?php if($key == 'iframecss') : ?> id="iframecsstr"<?php endif; ?><?php if($key == 'iframecss' && $sysmode == 2) : ?> class="afltr-hide"<?php endif; ?>>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('OPTIONS_'.  strtoupper($key)) ?>:
                </td>
                <td class="afltr-padding-left afltr-align-left">
                <?php if($key == 'timeZone') : ?>
                    <?php viewHelper::select('options[timeZone]', $timeZones, $value, false, false); ?>
                <?php elseif($key == 'dateTimeMask') : ?>                                    
                    <input type="text" class="input-text afltr-options-input-<?php print strtolower($key); ?> ui-state-default ui-corner-all" name="options[<?php print $key; ?>]" size="50" maxlength="255" value="<?php print $value; ?>" title="<?php print date($value); ?>">
                <?php else : ?>                                    
                    <input type="text" class="input-text afltr-options-input-<?php print strtolower($key); ?> ui-state-default ui-corner-all" name="options[<?php print $key; ?>]" size="50" maxlength="255" value="<?php print $value; ?>">
                <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>               
        </table>    
    </div>
    <script type="text/javascript">
        var afltrJsDTMasks = <?php print $dtMasks; ?>;
        jQuery('.afltr-options-input-datetimemask').autocomplete({
            source: afltrJsDTMasks,
            minLength: 0
        });        
    </script>      
</form>  