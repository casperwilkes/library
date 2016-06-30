<?php

/**
 * this sets up the config for current DB
 * sets all to constants
 * is defined ? if not return null and define it
 * Always put inside of another config file and include it
 */
defined("DB_SERVER") ? null : define("DB_SERVER", "localhost");
defined("DB_USER") ? null : define("DB_USER", "username");
defined("DB_PASS") ? null : define("DB_PASS", "user_password");
defined("DB_NAME") ? null : define("DB_NAME", "name_of_db");

/**
 * A better method of setting and using for an included config file
 */
return array(
    'server' => 'localhost',
    'db_name' => 'name_of_db',
    'username' => 'user_name',
    'password' => 'user_password',
);
