<?php

// Include OTA support functions
include('ota_functions.php');

// Include XSS filtering support function
include('xss-filter.php');

// Include the settings class file
include('settings.php');

// create settings object
$settings = new settings();

//Configure database params
$settings->mysql_db       = "ota";		// name of database, recommend to call it ota
$settings->mysql_host     = "CHANGEME";	// Your MySQL host e.g. localhost or 127.0.0.1
$settings->mysql_username	= "CHANGEME";	// MySQL username
$settings->mysql_password	= "CHANGEME";	// MySQL password

// Connect settings object
$settings->db_connect();

?>
