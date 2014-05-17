<?php

include('libs/config.php');

// Change to current release, needs to be made dynamic eventually
// open to changes to make this more flexible
$current_rel = "1.8.30";

// Function to ensure OTA is not already inserted, if it is we ignore it and move to the next device
function check_ota_inserted($device, $board, $version)
{
	$sql = "SELECT * FROM devices WHERE device='$device' AND board='$board' AND version='$version'";

	$query = mysql_query($sql)or die(mysql_error());
	
	$num_rows = mysql_num_rows($query);

	if($num_rows >= 1)
	{
		return true;
	}
}
// EF

// Function to get files name is correct to our rom /pack
function check_files_name($file, $marker)
{
        return strpos($file, $marker) === 0;
}
// EF

// Function to get device name from file name
function device_name($file)
{
	//This should solve issue of change lenght of version, 1.10.8 is 6 chars, 1.10.21 is 7 chars
	$device = substr( trim($file) , 12, -1*( strlen($GLOBALS['current_rel']) + 5 ))
        /*
        $device = substr($file, 12, 33);
        $device = substr($device, 0, -11);
        */
        return $device;
}
// EF

// Function to convert filesize properly
function filesizeinfo( $file,$precision = 0)
{
	$sizes=array( 'YB','ZB','EB','PB','TB','GB','MB','kB','B' );
	$total=count( $sizes );
           
	while($total-- && $file > 1024) $file /= 1024;
	
	return substr(round($file,$precision).$sizes[$total], 0,3);
}

// Define the OTA file repo
$ota_dir = "/home/miuiandroid/public_html/ota/".$current_rel;

// Set the OTA branch X = development
$branch = 'X';

// Read through currently available public OTA ROMS
if ( ($handle = opendir($ota_dir)) )
{
	// Loop through all files
        while( false !== ($file = readdir($handle)) )
        {
                if(check_files_name($file, 'miuiandroid'))
                {

// Filename OTA
$filename = 'miuiandroid_'.device_name($file).'-'.$current_rel.'.zip';

// Version
$version = 'MIUI-'.$current_rel;

// Filesize OTA
$filesize = filesize($ota_dir.'/'.$filename);

$ota_filesize = filesizeinfo($filesize);

// MD5 of OTA (Change the path to suite your local UNIX path to the OTA repository)
$checksum = md5_file("/home/miuiandroid/public_html/ota/".$current_rel."/miuiandroid_".device_name($file)."-".$current_rel.".zip");

if(device_name($file) == 'Captivate')
{
	$board = 'aries';
	$device = 'captivatemtd';
	$name = 'Samsung Captivate';
}
else if(device_name($file) == 'Defy')
{
	$board = 'jordan';
	$device = 'umts_jordan';
	$name = 'Motorola Defy';
}
else if(device_name($file) == 'Desire')
{
	$board = 'bravo';
	$device = 'bravo';
	$name = 'HTC Desire';
}
else if(device_name($file) == 'DesireZ')
{
	$board = 'vision';
	$device = 'vision';
	$name = 'HTC DesireZ';
}
else if(device_name($file) == 'DHD')
{
	$board = 'spade';
	$device = 'ace';
	$name = 'HTC Desire HD';
}
else if(device_name($file) == 'HD2')
{
	$board = 'leo';
	$device = 'leo';
	$name = 'HTC HD2';
}
else if(device_name($file) == 'I9000')
{
	$board = 'aries';
	$device = 'galaxys';
	$name = 'Samsung GalaxyS';
}
else if(device_name($file) == 'Milestone')
{
	$board = 'sholes';
	$device = 'umts_sholes';
	$name = 'Motorola Milestone';
}
else if(device_name($file) == 'N1')
{
	$board = 'mahimahi';
	$device = 'passion';
	$name = 'Google Nexus One';
}
else if(device_name($file) == 'NS')
{
	$board = 'herring';
	$device = 'crespo';
	$name = 'Google Nexus S';
}
else if(device_name($file) == 'Vibrant')
{
	$board = 'aries';
	$device = 'vibrantmtd';
	$name = 'Samsung Vibrant';
}
else if(device_name($file) == 'Optimus2x')
{
	$board = 'p990';
	$device = 'p990';
	$name = 'LG Optimus 2X';
}
else if(device_name($file) == 'DroidInc')
{
	$board = 'inc';
	$device = 'inc';
	$name = 'HTC Droid Incredible';
}
// End device specific name checks

		// Insert each devices OTA data in the loop
		$insert_ota_data = "INSERT INTO devices (`device`,`board`,`name`,`version`,`checksum`,`filename`,`filesize`,`branch`)
					VALUES(
					 '$device',
					 '$board',
					 '$name',
					 '$version',
					 '$checksum',
					 '$filename',
					 '$ota_filesize',
					 '$branch'					
					)";
                        // Lets check if this OTA is already in the database
                        if(check_ota_inserted($device, $board, $version) == true)
                        {
							$query = '';
							$insert_ota_data = '';
			  			}
                        else if(check_ota_inserted($device, $board, $version) != true)
                        {
								// Execute insert OTA data
								$query = mysql_query($insert_ota_data)or die(mysql_error());
 	                	}
		    } // End while

    } // End if

        // close directory
        closedir($handle);
}
?>
