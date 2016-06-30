<?php

/**
 * checks and returns allowable extensions. 
 * Used for validating and serving images.
 * @param string $image
 * @return string|boolean Either type or false
 */
function check_ext($image) {
    // Array of allowable formats //
    $allowed_ext = array('gif', 'png', 'jpg', 'jpeg');
    // Last element count //
    $last_element = 0;
    // Lowercase the extension //
    $im = strtolower($image);
    if (!is_null($im) && strlen($im)) {
        // Turn image name into an array //
        if (strpos($im, '/')) {
            $name = explode('/', $im);
        } else {
            $name = explode('.', $im);
        }
        // Get the last element in array //
        $last_element = count($name) - 1;
        // Compares format against allowable formats //
        if (in_array($name[$last_element], $allowed_ext)) {
            return $name[$last_element];
        }
        return FALSE;
    }
    return FALSE;
}
