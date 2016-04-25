<form method="post" action="index.php?step=1">
    <div class="afltr-acp-top-buttons">
        <?php viewHelper::submitButton('continue', language::returnLanguageConstant('NEXT_BTN')); ?>
    </div>
    <h2>Choose your language</h2>
    <div class="afltr-acp-form afltr-align-center"><?php viewHelper::select('lang', $languages); ?></div>
</form>