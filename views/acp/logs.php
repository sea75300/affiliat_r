<?php if(!defined('VIEW')) die(); ?>
<form method="post" action="">
    <div class="afltr-acp-top-buttons">
        <?php viewHelper::submitButton('submdelete', language::returnLanguageConstant('OPTIONS_CLEAR_LOG')); ?>
    </div>
    <h2><?php language::printLanguageConstant('HL_LOGS_SYSTEM'); ?></h2>    
    <div class="afltr-acp-list">
        <div class="tabs">
                <ul>
                    <li><a href="#tabs-log-php"><?php language::printLanguageConstant('HL_LOGS_ERROR'); ?></a></li>
                    <li><a href="#tabs-log-system"><?php language::printLanguageConstant('HL_LOGS_SYSTEM'); ?></a></li>                   
                </ul>            
            
            <div id="tabs-log-php" class="small-text">
            <?php foreach ($errorLogLines as $errorLogLine) : ?> 
                <?php print $errorLogLine; ?>
            <?php endforeach; ?> 
            </div>
            
            <div id="tabs-log-system" class="small-text">
            <?php foreach ($systemLogLines as $systemLogLine) : ?> 
                <?php print $systemLogLine; ?>
            <?php endforeach; ?> 
            </div>
        </div>
    </div>
</form>  