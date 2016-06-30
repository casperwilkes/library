<?php

/**
 * Gets a url parameter.
 * @param string $param The url parameter to $_GET
 * @return string Parameter or empty string
 */
function get_param($param = '') {
    return isset($_GET[$param]) ? $_GET[$param] : '';
}
