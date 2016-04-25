<div class="afltr-dialog-integration" title="<?php language::printLanguageConstant('CATEGORY_INTEGRATION'); ?>">
    <div class="afltr-acp-form" style="width: auto;margin: 0;">
        <table class="afltr-acp-table" id="afltr-integration-table">
            <tr>
                <td colspan="4" class="buttons-line afltr-align-center">
                    <input id="integration-text" class="input-text ui-state-default ui-corner-all" style="width:95%;" readonly="readonly" type="text" value="&lt;?php affiliatr::showAffiliates(<?php print $category->getId(); ?>, false, 0, false, null, false); ?&gt;" title="<?php language::printLanguageConstant('CATEGORY_INTEGRATION_COPY'); ?>">
                </td>
            </tr>
            <tr>            
                <td style="width: 25%;">
                    <select id="integration-textonly" class="input-select afltr-ui-select" style="width: 100%;">
                        <option value="0"><?php language::printLanguageConstant('CATEGORY_INTEGRATION_TXTBTN'); ?></option>
                        <option value="1"><?php language::printLanguageConstant('CATEGORY_INTEGRATION_BTNOL'); ?></option>
                        <option value="2"><?php language::printLanguageConstant('CATEGORY_INTEGRATION_TXTOL'); ?></option>
                    </select>                
                </td>                

                <td style="width: 25%;" class="afltr-align-center">
                    <?php language::printLanguageConstant('CATEGORY_INTEGRATION_ACCONLY'); ?>                
                    <input type="checkbox" value="1" id="integration-acceptedonly">
                </td>

                <td style="width: 25%;" class="afltr-align-center">
                    <?php language::printLanguageConstant('CATEGORY_INTEGRATION_NEWWIN'); ?>                
                    <input type="checkbox" value="1" id="integration-openblank">
                </td>

                <td style="width: 25%;" class="afltr-align-center">
                    <?php language::printLanguageConstant('CATEGORY_INTEGRATION_NOTUTF'); ?>
                    <input type="checkbox" value="1" id="integration-isnotutf8">
                </td>
            </tr>
            <tr>
                <td class="small-text afltr-align-center" colspan="4"><?php language::printLanguageConstant('CATEGORY_INTEGRATION_NOTICE'); ?></td>
            </tr>
        </table>          
    </div>        

    <script type="text/javascript">
        function updateIntegrationText() {
            var integration_string = '\<\?php affiliatr::showAffiliates(';

            var acceptedonly = jQuery('#integration-acceptedonly').prop('checked');
            var textonly     = jQuery('#integration-textonly').val();
            var openblank    = jQuery('#integration-openblank').prop('checked');
            var isnotutf8    = jQuery('#integration-isnotutf8').prop('checked');

            integration_string += <?php print $category->getId(); ?> + ', ' + acceptedonly + ', ' + textonly + ', ' + openblank + ', null, ' + isnotutf8;
            integration_string += '); ?\>';

            jQuery('#integration-text').val(integration_string);
        }
        
        jQuery(document).ready( function() {
            jQuery('#afltr-integration-table input[type=checkbox]').click(function() {
                updateIntegrationText();
            });           
        });
    </script>    
</div> 