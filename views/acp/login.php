<?php if(!defined('VIEW')) die(); ?>
<div class="afltr-login-form">
    <form method="post" action="">            
        <?php language::printLanguageConstant('LOGIN_PASSWORT'); ?><br>
        <input type="password" class="input-text ui-state-default ui-corner-all" name="passwd" size="50" maxlength="255" value="<?php print $defaultPW; ?>">
        <?php viewHelper::submitButton('submpass', language::returnLanguageConstant('LOGIN_BTN')); ?><br>
        <div class="afltr-align-center afltr-padding-top small-text"><?php language::printLanguageConstant('LOGIN_RESET_PASSWORD'); ?></div>
    </form>      
</div>