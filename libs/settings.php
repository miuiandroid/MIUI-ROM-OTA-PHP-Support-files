<?php

// Create the Settings class object
class Settings {
	
	// Define variables
	var $mysql_host;
	var $mysql_db;
	var $mysql_username;
	var $mysql_password;
	var $mysql_connid;

	/* Connect to the mysql database */
	function db_connect()
	{
		$this->mysql_connid = mysql_connect ("$this->mysql_host", "$this->mysql_username", "$this->mysql_password") or die("Connection failed to  MySQL Database");

		// Select the database
		mysql_select_db($this->mysql_db) or die("Could not select database");		
	} // EF
	
	// Kill active connections to $mysql_connid
	function kill()
	{
		mysql_close();
	} // EF

} // End of Settings Class

?>