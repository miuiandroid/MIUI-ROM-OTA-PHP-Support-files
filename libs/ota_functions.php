<?php

// Function to get current user version and then find new version
// @param current_version (users currently installed MIUI version e.g. 1.8.12)
function current_rom($current_version, $hardware_board, $device_name)
{
	/*
	// SQL
	$sql = "SELECT * FROM devices WHERE version > '$current_version' AND device='$device_name' AND board='$hardware_board' LIMIT 1";

	// Query
	$query = mysql_query($sql)or die(mysql_error());

	// Get num_rows
	$num_rows = mysql_num_rows($query);

	// Get version new
	$get_latest_version = mysql_fetch_assoc($query);

	if($num_rows > 0) return true;
	*/
	
	
	
	// select all versions for device
	$sql = "SELECT version FROM devices WHERE device = '$device_name' AND board = '$hardware_board' ORDER BY INET_ATON(version) DESC LIMIT 0, 1";
	$query = mysql_query($sql);
	$latest_version = mysql_result($query,0);


	if(version_compare($current_version, $latest_version) < 0){
		//echo "success";
		return true;
	}else{
		//echo "no dice";
	}	
		

	
	
}

// Function to get branch e.g. Stable or Dev
function get_branch($hardware_board, $device_name, $version)
{
	
	// SQL
	$sql = "SELECT branch FROM devices WHERE version='$version' AND device='$device_name' AND board='$hardware_board' LIMIT 1";

	// Query
	$query = mysql_query($sql)or die(mysql_error());

	$branch = mysql_fetch_assoc($query);

	return $branch['branch'];
}

// Function to return the latest version number
function get_new_version($current_version)
{
	/*
	// SQL
	$sql = "SELECT version FROM devices WHERE version > '$current_version' LIMIT 1";

	// Query
	$query = mysql_query($sql)or die(mysql_error());

	$version = mysql_fetch_assoc($query);

	return $version['version'];
	*/
	
	
	// select all versions for device
	$sql = "SELECT version FROM devices ORDER BY INET_ATON(version) DESC LIMIT 0, 1";
	$query = mysql_query($sql);
	$latest_version = mysql_result($query,0);


	if(version_compare($current_version, $latest_version) < 0){
		//echo "success";
		return $latest_version;
	}else{
		//echo "no dice";
	}	

	
}

// Function to get the device name
function get_device_name($hardware_board, $device_name, $new_version)
{
		// SQL
	$sql = "SELECT * FROM devices WHERE version='$new_version' AND board='$hardware_board' AND device='$device_name' LIMIT 1";

		// Query
		$query = mysql_query($sql)or die(mysql_error());

	$device_name = mysql_fetch_assoc($query);

	return $device_name['name'];
}

// Function to retrieve new OTA filesize details
function get_new_filesize($hardware_board, $device_name, $new_version)
{
	// SQL
	$sql = "SELECT * FROM devices WHERE version='$new_version' AND board='$hardware_board' AND device='$device_name'";
		
		// Query
		$query = mysql_query($sql)or die(mysql_error());

	$new_filesize = mysql_fetch_assoc($query);

	return $new_filesize['filesize'];
}
// Function to retrieve	current filesize details
function get_filesize($hardware_board, $device_name, $current_version)
{
		// SQL
	$sql = "SELECT * FROM devices WHERE version='$current_version' AND board='$hardware_board' AND device='$device_name' LIMIT 1";

		// Query
		$query = mysql_query($sql)or die(mysql_error());

		$filesize = mysql_fetch_assoc($query);
 
		return $filesize['filesize'];
}

// Function to get the new file name for the OTA
function get_new_filename($hardware_board, $device_name, $new_version)
{
		// SQL
	$sql = "SELECT * FROM devices WHERE version='$new_version' AND board='$hardware_board' AND device='$device_name' LIMIT 1";
		
	// Query
		$query = mysql_query($sql)or die(mysql_error());

	$new_filename = mysql_fetch_assoc($query);

	return $new_filename['filename'];
}

// Function to get the file name of the current file
function get_filename($hardware_board, $device_name, $current_version)
{
		// SQL
	$sql = "SELECT * FROM devices WHERE version='$current_version' AND board='$hardware_board' AND device='$device_name' LIMIT 1";

		// Query
		$query = mysql_query($sql)or die(mysql_error());

		$filename = mysql_fetch_assoc($query);

		return $filename['filename'];
}

// Function to return the current files MD5 checksum
function get_checksum($hardware_board, $device_name, $current_version)
{
		// SQL
	$sql = "SELECT * FROM devices WHERE version='$current_version' AND board='$hardware_board' AND device='$device_name' LIMIT 1";

		// Query
		$query = mysql_query($sql)or die(mysql_error());

		$checksum = mysql_fetch_assoc($query);

		return $checksum['checksum'];
}

// Function to return the new OTA files MD5 checksum
function get_new_checksum($hardware_board, $device_name, $new_version)
{
		// SQL
	$sql = "SELECT * FROM devices WHERE version='$new_version' AND board='$hardware_board' AND device='$device_name' LIMIT 1";

		// Query
		$query = mysql_query($sql)or die(mysql_error());

	$new_checksum = mysql_fetch_assoc($query);

	return $new_checksum['checksum'];
}
?>
