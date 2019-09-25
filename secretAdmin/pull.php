<?php
//error_reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// function to execute the command and print the result and exit code
function execPrint($command) {
        $result = array();
        $resultCode = "";
        exec($command, $result,$resultCode);
        echo implode("\n", $result);
        echo $resultCode;
}

// Print the exec output inside of a pre element
print("<pre>" . execPrint("cd ../ && git pull -v --commit") . "</pre>");
?>
