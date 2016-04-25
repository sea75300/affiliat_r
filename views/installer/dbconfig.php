<form method="post" action="index.php?step=2&amp;lang=<?php print $lang; ?>">
    <div class="afltr-acp-top-buttons">
        <?php viewHelper::submitButton('submsavesyscfg', language::returnLanguageConstant('NEXT_BTN')); ?>
    </div>
    <h2><?php language::printLanguageConstant('HL_INSTALL_DBCONNECT'); ?></h2>
    <div class="afltr-acp-form afltr-align-center">     
        <table class="afltr-acp-table">
            <tr>
                <td class="afltr-td-label afltr-align-right">
                    <?php language::printLanguageConstant('INSTALL_DBTYPE') ?>:
                </td>
                <td class="afltr-padding-left">
                <?php viewHelper::select('dbconfig[DBTYPE]', $dbtypes, null, false, false) ?>
                </td>                
            </tr>            
            <?php foreach ($fields as $key => $value) : ?>
                <tr>
                    <td class="afltr-td-label afltr-align-right">
                        <?php language::printLanguageConstant('INSTALL_'.  strtoupper($key)) ?>:
                    </td>
                    <td class="afltr-padding-left">
                        <?php if($key == 'DBPASS') : ?>
                        <input type="password" class="input-text ui-state-default ui-corner-all" name="dbconfig[<?php print $key; ?>]" size="50" maxlength="255" value=""></td>
                        <?php else : ?>
                        <input type="text" class="input-text ui-state-default ui-corner-all" name="dbconfig[<?php print $key; ?>]" size="50" maxlength="255" value="<?php print $value; ?>"></td>
                        <?php endif; ?>
                </tr>
            <?php endforeach; ?>     
        </table>
    </div>    
</form>