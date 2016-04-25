<?php

    include 'versionlist.php';
    include 'lang.php';

    $data = json_decode(base64_decode($_GET['data']), TRUE);

    if($data['version'] > $returnData['newversion']) { die("<span style=\"font-family:sans-serif;\">{$lang[$data['language']]['DEVELOPER']}</span>"); }
    if($data['version'] < $returnData['newversion'] && isset($_GET['oudated'])) { die("<span style=\"font-family:sans-serif;\">{$lang[$data['language']]['OUTDATED']}</span>"); }
    if($data['version'] == $returnData['newversion']) { die("<span style=\"font-family:sans-serif;\">{$lang[$data['language']]['NOT_OUTDATED']}</span>"); }
    
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public");    
    header("Content-Description: File Transfer");
    header('Content-type: application/octet-stream');
    header("Content-Transfer-Encoding: binary\n");    
    header("Content-Disposition: attachment; filename=\"".$returnData['updatefile']."\"");
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".filesize($returnData['updatefile']));
    ob_end_flush();
    @readfile($returnData['updatefile']);
?>