<div class="wrap">
<h2>Affiliat*r Integration</h2>

<div class="tabs">
    <ul>
        <li><a href="#nnorg-wp-affiliatr-config"><?php print __('Configuration', 'nnorg-wp-affiliatr'); ?></a></li>
        <li><a href="#nnorg-wp-affiliatr-integration"><?php print __('Integration Assistent', 'nnorg-wp-affiliatr'); ?></a></li>
    </ul>
    
    <div id="nnorg-wp-affiliatr-config">
        <form method="post" action="">
            <table class="form-table">
                <tr>
                    <th scope="row"><label><?php print __('Path from root', 'nnorg-wp-affiliatr'); ?></label></th>
                    <td><input class="regular-text" type="text" name="nnorg_afltr_path" value="<?php print esc_attr($nnorg_afltr_path); ?>" /></td>
                </tr>
            </table>

            <?php submit_button( __( 'Save Changes' ), 'primary', 'Update' ); ?>

        </form>
    </div>
    
    <div id="nnorg-wp-affiliatr-integration">
        <table class="form-table">
            <tr><td scope="row" colspan="10"><span class="description"><?php print __('Copy this text onto the page or post you want to display affiliates.', 'nnorg-wp-affiliatr'); ?></span></td></tr>
            <tr><td colspan="10"><input id="nnorg-wp-affiliatr-integration-text" class="regular-text" readonly="readonly" type="text" style="width: 100%;" /></td></tr>
            <tr>
                <th scope="row" style="width: 100px;"><label>Category</label></th>
                <td><input class="regular-text" type="text" id="nnorg-wp-affiliatr-integration-category" value="0" maxlength="5" style="width:50px;"></td>
                <th scope="row" style="width: 100px;"><label>textOnly</label></th>                
                <td><select id="nnorg-wp-affiliatr-integration-textonly">
                        <option value="0">Text and Button</option>
                        <option value="1">Button only</option>
                        <option value="2">Text only</option>
                    </select>                
                </td>                
                
                <th scope="row" style="width: 100px;"><label>acceptedOnly</label></th>
                <td><input type="checkbox" value="1" id="nnorg-wp-affiliatr-integration-acceptedonly"></td>
                
                <th scope="row" style="width: 100px;"><label>openBlank</label></th>
                <td><input type="checkbox" value="1" id="nnorg-wp-affiliatr-integration-openblank"></td>
                
                <th scope="row" style="width: 100px;"><label>isNotUtf8</label></th>
                <td><input type="checkbox" value="1" id="nnorg-wp-affiliatr-integration-isnotutf8"></td>
            </tr>
            <tr>
                <td colspan="10"><input class="button button-primary" type="submit" id="nnorg-wp-affiliatr-integration-create" value="Create"></td>
            </tr>
        </table>        
        
        
    </div>
    
</div>

<script type="text/javascript">
    jQuery(document).ready( function() {
        jQuery('.tabs').tabs();
        jQuery('#nnorg-wp-affiliatr-integration-create').click(function() {
            var integration_string = '[affiliatr action="showAffiliates" ';
            
            var category     = 'category="' + jQuery('#nnorg-wp-affiliatr-integration-category').val() + '"';
            var acceptedonly = 'acceptedonly="' + (jQuery('#nnorg-wp-affiliatr-integration-acceptedonly').prop('checked') ? 1 : 0) + '"';
            var textonly     = 'textonly="' + jQuery('#nnorg-wp-affiliatr-integration-textonly').val() + '"';
            var openblank    = 'openblank="' + (jQuery('#nnorg-wp-affiliatr-integration-openblank').prop('checked') ? 1 : 0) + '"';
            var isnotutf8    = 'isnotutf8="' + (jQuery('#nnorg-wp-affiliatr-integration-isnotutf8').prop('checked') ? 1 : 0) + '"';
            
            integration_string += category + ' ' + acceptedonly + ' ' + textonly + ' ' + openblank + ' ' + isnotutf8;
            integration_string += ']';

            jQuery('#nnorg-wp-affiliatr-integration-text').val(integration_string);
            
        });
    });
</script>


</div>