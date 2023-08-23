<?php
    $language = strtolower($_POST['language']);
    $code = $_POST['code'];

    $random = substr(md5(mt_rand()), 0, 7);
    $filePath = "temp/" . $random . "." . $language;
    if($language == "python"){
        $filePath = "temp/" . $random . ".py";
    }
    if($language == "node"){
        $filePath = "temp/" . $random . ".js";
    }
    $programFile = fopen($filePath, "w");
    fwrite($programFile, $code);
    fclose($programFile);

    /*header('Content-Type: application/octet-stream');
    header("Content-Transfer-Encoding: Binary"); 
    header("Content-disposition: attachment; filename=\"".$random . "." . $language."\""); 
    //readfile($filePath);
    //exit;
    $path = getcwd();*/

    echo $filePath;