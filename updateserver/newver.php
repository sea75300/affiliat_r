<?php

    include 'versionlist.php';

    $data = json_decode(base64_decode($_GET['data']), TRUE);
    
    header('Content-type: text/plain');
    header("Content-Transfer-Encoding: binary\n");

    $returnData['updatefile'] = base64_encode($returnData['updatefile']);
    
    print base64_encode(json_encode($returnData));
    flush();
?>