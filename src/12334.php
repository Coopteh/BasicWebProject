<?php


function custom_error_handler($errno, $errstr, $errfile, $errline)
{
    $error_message = "[{$errno}] {$errstr} in {$errfile} on line {$errline}\n";
    error_log($error_message, 3, 'errors.log');
}

set_error_handler('custom_error_handler', E_ALL);

try {
    $x = 10 / 0;
} catch (\Throwable $t) {

    trigger_error($t->getMessage(), E_USER_ERROR);
}

restore_error_handler();
?>