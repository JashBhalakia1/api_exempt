<?php
session_start();
require "includes/constants.php";
require "includes/dbConnection.php";
require "lang/en.php";

// Class Auto Load
function classAutoLoad($classname) {
    $directories = ["contents", "layouts", "menus", "forms", "processes", "global"];

    foreach ($directories as $dir) {
        $filename = __DIR__ . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $classname . ".php";
        if (file_exists($filename) && is_readable($filename)) {
            require_once $filename;
        }
    }
}

spl_autoload_register('classAutoLoad');

// Create instances of all classes
$ObjLayouts = new layouts();
$ObjMenus = new menus();
$ObjHeadings = new headings();
$ObjCont = new contents();
$ObjForm = new user_forms();
$conn = new dbConnection(DBTYPE, HOSTNAME, DBPORT, HOSTUSER, HOSTPASS, DBNAME);

// Create process instances
$ObjAuth = new auth();

// Use only available variables in method calls
try {
    $ObjAuth->signup($conn, null, null, $lang, null);
    $ObjAuth->verify_code($conn, null, null, $lang, null);
    $ObjAuth->set_passphrase($conn, null, null, $lang, null);
    $ObjAuth->signin($conn, null, null, $lang, null);
    $ObjAuth->signout($conn, null, null, $lang, null);
    $ObjAuth->save_details($conn, null, null, $lang, null);
} catch (Exception $e) {
    error_log("Error in authentication process: " . $e->getMessage());
}
