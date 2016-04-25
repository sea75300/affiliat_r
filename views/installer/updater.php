<?php if(count($fileList)) : ?>
<div class="afltr-acp-top-buttons">
    <a class="buttons" href="#" id="afltr-updater-show-details"><?php language::printLanguageConstant('UPDATE_SHOWDETAILS'); ?></a>
</div>
<?php endif; ?>
<h2><?php language::printLanguageConstant('UPDATER'); ?></h2>
<div class="afltr-acp-form">
    <table class="afltr-acp-table">
        <tr>
            <td class="afltr-td-label afltr-align-right">
                <?php language::printLanguageConstant('UPDATE_CURRENT_VERSION') ?>:
            </td>
            <td class="afltr-padding-left afltr-align-left"><?php print $version; ?></td>
        </tr> 
        <tr>
            <td class="afltr-td-label afltr-align-right">
                <?php language::printLanguageConstant('UPDATE_NEW_VERSION') ?>:
            </td>
            <td class="afltr-padding-left afltr-align-left"><?php print $newVersion; ?></td>
        </tr> 
        <?php if(count($fileList)) : ?>
        <tr id="afltr-updater-show-details-list" style="display:none;">
            <td class="afltr-padding-left afltr-align-left" colspan="2">
                <?php foreach ($fileList as $file => $check) : ?>
                <table class="afltr-acp-table" style="width:50%;margin: 0 auto;">
                        <tr>
                            <td>
                                <?php print $file; ?>
                            </td>
                            <td class="afltr-padding-left afltr-align-center afltr-acp-td-35px">
                                <?php if($check) : ?>
                                    <span class="afltr-bool-to-text-icon ui-icon ui-icon-check"></span>
                                <?php else : ?>
                                    <span class="afltr-bool-to-text-icon ui-icon ui-icon-closethick"></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                <?php endforeach; ?>
            </td>
        </tr>
        <?php endif; ?>        
    </table>
</div>