<?php

/**
 * Lazy Loader.
 * @param string $class_name
 */
function __autoload($class_name) {
    // Splits class name by '_' //
    $loader = array();
    @list($loader['file_name'], $loader['suffix']) = explode('_', $class_name, 2);
    switch (strtolower($loader['suffix'])) {
        case(''):
            $dir = 'includes';
            break;
        case('controller'):
            $dir = 'controllers';
            break;
        default :
            $dir = 'models';
            break;
    }

    $file_path = SYSTEM . DS . $dir . DS . strtolower($loader['file_name']) . '.php';

    if (file_exists($file_path)) {
        include_once $file_path;
    } else {
        see_var(realpath($file_path), 'realpath');
        see_var($file_path, 'Requested Path');
        die('The requested path could not be loaded.');
    }
}
