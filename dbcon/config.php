<?php

/**
 * Database config variables
 */
ini_set('display_errors', 0);
session_start();
$url = $_SERVER['SERVER_NAME'];
$url = $url . "/";
if ($_SERVER['HTTP_HOST'] == "localhost") {
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "123456");
    define("DB_DATABASE", "teejay");
} else {
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "Oditek123@");
    define("DB_DATABASE", "teejay");
}
define("USER_SITE_URL", "http://" . $url);
define("ADMIN_SITE_URL", "http://" . $url . "admin/");
?>