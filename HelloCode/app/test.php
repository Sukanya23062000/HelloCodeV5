<?php
    $language = strtolower($_POST['language']);
    $code = $_POST['code'];
    $input = $_POST['input'];
    $random = substr(md5(mt_rand()), 0, 7);
    $filePath = "temp/" . $random . "." . $language;
    $programFile = fopen($filePath, "w");
    fwrite($programFile, $code);
    fclose($programFile);
    $command = "";
    if($language == "php") {
        //$output = shell_exec("E:\\xampp\php\php.exe $filePath 2>&1");
        //echo $output;
        $command = "E:\\xampp\php\php.exe $filePath";
    }
    if($language == "python") {
        //$output = shell_exec("C:\Python311\python.exe $filePath 2>&1");
        //echo $output;
        $command = "C:\Python311\python.exe $filePath";
    }
    if($language == "node") {
        rename($filePath, $filePath.".js");
        //$output = shell_exec("node $filePath.js 2>&1");
        //echo $output;
        $command = "node $filePath.js";
    }
    if($language == "c") {
        $outputExe = $random . ".exe";
        $outputError = shell_exec("gcc $filePath -o $outputExe 2>&1");
        if($outputError == ""){
            //$output = shell_exec(__DIR__ . "//$outputExe");
            //echo $output;
            $command = __DIR__ . "//$outputExe";
        }else{
            echo $outputError;
        }
    }
    if($language == "cpp") {
        $outputExe = $random . ".exe";
        $outputError = shell_exec("g++ $filePath -o $outputExe 2>&1");
        if($outputError == ""){
            //$output = shell_exec(__DIR__ . "//$outputExe");
            //echo $output;
            $command = __DIR__ . "//$outputExe";
        }else{
            echo $outputError;
        }
    }
    if($language == 'java'){
        $newFilePath = "temp/" . $random;
        mkdir($newFilePath);
        $outputError = shell_exec("javac -d $newFilePath $filePath 2>&1");
        if($outputError == ""){
            $objFile = glob($newFilePath . "/*.class");
            $objFile = $objFile[0];
            $objFile = str_replace('.class', '', $objFile);
            $objFile = explode('/', $objFile);
            $objFile = $objFile[sizeof($objFile)-1];
            $path = getcwd();
            //$output = shell_exec("java -cp $path\\temp\\$random $objFile 2>&1");
            //echo $output;
            $command = "java -cp $path\\temp\\$random $objFile";
        }else{
            echo $outputError;
        }
    }

    $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
        1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        2 => array("pipe", "w") // stderr is a file to write to
     );
     $process = proc_open($command, $descriptorspec, $pipes);
     if (is_resource($process)) {
        // Write the input to Pipe 0 (STDIN)
        fwrite($pipes[0], $input);
        fclose($pipes[0]);
        
        // Read the output from Pipe 1 (STDOUT)
        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        
        // Read the error from Pipe 2 (STDERR)
        $error = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        
        // Close the process
        $exitCode = proc_close($process);
        
     // Display the output or error
     if ($exitCode === 0) {
        echo $output;
     } else {
        echo $error;
     }
  } else {
     echo "Failed to execute the command.";
  }