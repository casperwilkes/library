<?php

/**
 * Creates a logfile for errors.
 * 
 * @param string $log Name of log file
 * @param string $action Method or cause of error
 * @param string $message Error message
 */
function log_message($log = '', $action = '', $message = '') {
    // Logging directory //
    $logs_dir = 'logs';
    // Path to directory //
    $log_path = SITE_ROOT . DS . $logs_dir;
    // filepath for log file //
    if (strlen($log)) {
        // If using __CLASS__ for log name //
        $log = strpos($log, '_') ? strstr($log, '_', TRUE) : $log;
        $logfile = $log_path . DS . strtolower($log) . '.txt';
    } else {
        // If log name was not specified //
        $logfile = $log_path . DS . 'General.txt';
    }
    // Set directory and log permissions //
    $permission = 0755;
    // Test file before writing //
    $new = file_exists($logfile) ? false : true;
    if (!is_dir($log_path)) {
        mkdir($log_path, $permission);
    }
    // If action or method wasn't specified //
    if (!strlen($action)) {
        $action = 'An unspecified error has occured';
    }
    // opens file if exists, if not creates giving appropriate information //
    // Open in Append mode //
    $handle = fopen($logfile, 'a');
    if ($handle) {
        // sets time //
        $timestamp = strftime("%m/%d/%Y %H:%M:%S", time());
        // Log line //
        $content = "{$timestamp} || {$action} || {$message}\n";
        // Write to file //
        fwrite($handle, $content);
        // Close file //
        fclose($handle);
        // change permissions on *nix //
        if ($new) {
            chmod($logfile, $permission);
        }
    } else {
        echo 'Could not open log file for writing.';
    }
}
