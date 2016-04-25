<form method="post" action="index.php?step=3&amp;lang=<?php print $lang; ?>">
    <div class="afltr-acp-top-buttons">
        <?php viewHelper::saveButton('submsave'); ?>
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
                        <?php viewHelper::select('options[sysLanguage]', $languages, $lang, false, false); ?>                   
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
                <tr<?php if($key == 'iframecss') : ?> id="iframecsstr"<?php endif; ?>>
                    <td class="afltr-td-label afltr-align-right">
                        <?php language::printLanguageConstant('OPTIONS_'.  strtoupper($key)) ?>:
                    </td>
                    <td class="afltr-padding-left afltr-align-left">
                    <?php if($key == 'timeZone') : ?>
                        <?php viewHelper::select('options[timeZone]', $timeZones, $value, false, false); ?>
                    <?php else : ?>                                    
                        <input type="text" class="input-text afltr-options-input-<?php print strtolower($key); ?> ui-state-default ui-corner-all" name="options[<?php print $key; ?>]" size="50" maxlength="255" value="<?php print $value; ?>">
                    <?php endif; ?>
                    </td>                
                </tr>
            <?php endforeach; ?>                
            </table>    
    </div>
</form>  