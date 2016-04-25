<?php if(!defined('VIEW')) die(); ?>
<form method="post" action="">
    <div class="afltr-acp-top-buttons">
        <a class="buttons afltr-add-btn" href="?module=category/add"><?php language::printLanguageConstant('HL_CATEGORIES_ADD'); ?></a>
        <?php viewHelper::submitButton('submdelete', language::returnLanguageConstant('DELETE_BTN'), 'submdelete'); ?>
    </div>
    <h2><?php language::printLanguageConstant('HL_CATEGORIES_MNG'); ?></h2>
    <div class="afltr-acp-list">
            <table class="afltr-acp-table">
                <tr>
                    <th class="afltr-acp-td-35px afltr-align-center"></th>
                    <th class="afltr-padding-left afltr-align-left"><?php language::printLanguageConstant('CATEGORY_NAME'); ?></th>
                    <th class="afltr-acp-td-w4 afltr-align-left"><?php language::printLanguageConstant('CATEGORY_ICONPATH'); ?></th>
                    <th class="afltr-acp-td-w2 afltr-align-center"><?php language::printLanguageConstant('CATEGORY_PRIVATE'); ?></th>
                    <th class="afltr-acp-td-35px afltr-align-center afltr-padding-left"><input type="checkbox" id="afltr-checkbox-selectall"></th>
                </tr>        
            <?php foreach ($categoryList as $categoryId => $category) : ?>
                <?php $iconPath = $category->getIconPath(); ?>
                <tr class="afltr-bg-toggle">
                    <td class="afltr-acp-td-35px afltr-align-center afltr-padding-left"><a class="buttons" href="index.php?module=category/edit&categoryid=<?php print $category->getId(); ?>" title="<?php language::printLanguageConstant('EDIT_BTN'); ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
                    <td class="afltr-padding-left afltr-align-left"><?php print $category->getName(); ?></td>
                    <td class="afltr-acp-td-w4 afltr-align-left afltr-overflow-hidden"><?php if(!empty($iconPath)) : ?><img src="<?php print $iconPath; ?>" alt="<?php print $category->getName(); ?>" title="<?php print $category->getName(); ?>"><?php endif; ?></td>
                    <td class="afltr-acp-td-w2 afltr-align-center"><?php viewHelper::boolToText($category->isPrivate()) ?></td>
                    <td class="afltr-acp-td-35px afltr-align-center afltr-padding-left"><input type="checkbox" class="afltr-checkbox" name="categoryDelList[]" value="<?php print $category->getId(); ?>"></td>
                </tr>  
            <?php endforeach; ?>             
            </table>
    </div>
</form>