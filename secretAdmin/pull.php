<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
function execPrint($command) {
    $result = array();
    exec($command, $result);
    foreach ($result as $line) print($line . "\n");
}
// Print the exec output inside of a pre element
print("<pre>" . execPrint("git pull") . "</pre>");
print("<pre>" . execPrint("whoami") . "</pre>");
?>