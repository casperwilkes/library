<?php

/**
 * Deprecated mysql db commands
 */
require_once("the_db_constants");

// 1. NEED TO CREATE A NEW DB CONNECTION//
$connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
if (!$connection) {
    die("Database connection has failed: " . mysql_error());
}

// 2. SELECT THE DB TO USE //
$db_select = mysql_select_db(DB_NAME, $connection);
if (!$db_select) {
    die("Database selection has failed: " . mysql_error());
}

// 3. PERFORMS THE DB QUERYING//
$sql = "SELECT * FROM table";
$result = mysql_query($sql, $connection);
if (!$result) {
    die("The database query has failed: " . mysql_error());
}

// 4. RETURNS QUERY DATA //
while ($row = mysql_fetch_array($result)) {
    // PUT DATA COMMANDS HERE //
}

// 5. CLOSE CONNECTION //
if (isset($connection)) {
    mysql_close($connection);
    unset($connection);
}
