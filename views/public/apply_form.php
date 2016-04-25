<?php
    messages::showMessages();

    $fields = array('pageName'       => $affiliate->getPageName(),
                    'pageUrl'        => $affiliate->getPageUrl(),
                    'pageAdminName'  => $affiliate->getPageAdminName(),
                    'pageAdminEmail' => $affiliate->getPageAdminEmail(),
                    'pageButton'     => $affiliate->getPageButton());
?>
<form method="post" action="">
    <div class="afltr-public-form">
        <small><?php language::printLanguageConstant('APPLY_REQUIRED_FIELDS', null, $isNotUtf8); ?></small>
            <table class="afltr-public-table">
            <?php foreach ($fields as $key => $value) : ?>
                <tr>
                    <td class="afltr-public-label">
                        <?php language::printLanguageConstant('AFFILIATE_PUB_'.  strtoupper($key), null, $isNotUtf8) ?>:
                    </td>
                    <td class="afltr-public-content"><input type="text" class="afltr-public-input-text" name="affiliate[<?php print $key; ?>]" size="25" maxlength="255" value="<?php print $value; ?>"> *</td>
                </tr>
            <?php endforeach; ?>            
                <tr>
                    <td class="afltr-public-label">
                        <?php language::printLanguageConstant('AFFILIATE_PUB_AFFILIATECATEGORY', null, $isNotUtf8); ?>:
                    </td>
                    <td class="afltr-public-content">
                        <?php viewHelper::select('affiliate[affiliateCategory]', $categories, $affiliate->getAffiliateCategory(), false, true, $isNotUtf8); ?> *
                    </td>
                </tr>     
                <tr>
                    <td class="afltr-public-label" colspan="2">
                        <?php print utf8_decode($antiSpamQuestion); ?>
                    </td>
                </tr>    
                <tr>
                    <td class="afltr-public-label"></td>
                    <td class="afltr-public-content">
                        <input type="text" class="afltr-public-input-text" name="antiSpamAnswer" size="25" maxlength="255" value="<?php print $value; ?>">
                    </td>
                </tr>                   
                <tr>
                    <td colspan="2" class="afltr-public-button-line">
                        <?php viewHelper::submitButton('submsave', language::returnLanguageConstant('AFFILIATE_PUB_SUBMIT'), $isNotUtf8); ?>
                        <?php viewHelper::resetButton('subreset', $isNotUtf8); ?>
                    </td>
                </tr>
            </table>
    </div>
</form>

<!-- Powered by Affiliat*r <?php print $systemVersion; ?> - http://nobody-knows.org/download/affiliatr/ -->