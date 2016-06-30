<?php

/**
 * Redirection header.
 * @param string $location Where to send user to.
 */
function redirect($location = NULL) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}
