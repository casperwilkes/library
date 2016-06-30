<?php

/**
 * Returns the visitors IP address when submitting media. Used to log IP into
 * the database.
 * @return string
 */
//function get_ip() {
//    //check ip from share internet
//    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
//        $ip = $_SERVER['HTTP_CLIENT_IP'];
//    }   //to check ip is pass from proxy
//    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
//        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
//    } else {
//        $ip = $_SERVER['REMOTE_ADDR'];
//    }
//    return $ip;
//}

function get_ip() {
    $keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
    foreach ($keys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }

                return null;
            }
        }
    }
}
