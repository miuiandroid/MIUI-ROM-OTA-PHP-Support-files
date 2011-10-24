<?php

include('libs/config.php');

// Change to current release, needs to be made dynamic eventually
// open to changes to make this more flexible
$current_rel = sanitise($_POST["fversion"], FULLSCAN);

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
        $device = substr($file, 12, 33);
        $device = substr($device, 0, -11);
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

if(strtoupper(device_name($file)) == strtoupper('Captivate'))
{
	$board = 'aries';
	$device = 'captivatemtd';
	$name = 'Samsung Captivate';
}
else if(strtoupper(device_name($file)) == strtoupper('Defy'))
{
	$board = 'jordan';
	$device = 'umts_jordan';
	$name = 'Motorola Defy';
}
else if(strtoupper(device_name($file)) == strtoupper('Desire'))
{
	$board = 'bravo';
	$device = 'bravo';
	$name = 'HTC Desire';
}
else if(strtoupper(device_name($file)) == strtoupper('DesireZ'))
{
	$board = 'vision';
	$device = 'vision';
	$name = 'HTC Desire Z';
}
else if(strtoupper(device_name($file)) == strtoupper('DHD'))
{
	$board = 'spade';
	$device = 'ace';
	$name = 'HTC Desire HD';
}
else if(strtoupper(device_name($file)) == strtoupper('HD2'))
{
	$board = 'leo';
	$device = 'leo';
	$name = 'HTC Desire HD2';
}
else if(strtoupper(device_name($file)) == strtoupper('I9000'))
{
	$board = 'aries';
	$device = 'galaxys';
	$name = 'Samsung Galaxy S';
}
else if(strtoupper(device_name($file)) == strtoupper('IncredibleS'))
{
	$board = 'vivo';
	$device = 'vivo';
	$name = 'HTC Incredible S';
}
else if(strtoupper(device_name($file)) == strtoupper('Milestone'))
{
	$board = 'sholes';
	$device = 'umts_sholes';
	$name = 'Motorola Milestone';
}
else if(strtoupper(device_name($file)) == strtoupper('N1'))
{
	$board = 'mahimahi';
	$device = 'passion';
	$name = 'Google Nexus One';
}
else if(strtoupper(device_name($file)) == strtoupper('NS'))
{
	$board = 'herring';
	$device = 'crespo';
	$name = 'Google Nexus S';
}
else if(strtoupper(device_name($file)) == strtoupper('Vibrant'))
{
	$board = 'aries';
	$device = 'vibrantmtd';
	$name = 'Samsung Vibrant';
}
else if(strtoupper(device_name($file)) == strtoupper('Optimus2x'))
{
	$board = 'p990';
	$device = 'p990';
	$name = 'LG Optimus 2X';
}
else if(strtoupper(device_name($file)) == strtoupper('DroidInc'))
{
	$board = 'inc';
	$device = 'inc';
	$name = 'HTC Droid Incredible';
}
else if(strtoupper(device_name($file)) == strtoupper('mione'))
{
	$board = 'MIONE';
	$device = 'mione_plus';
	$name = 'Xiaomi MIONE plus';
}
else if(strtoupper(device_name($file)) == strtoupper('SGS2'))
{
	$board = 'GT-I9100';
	$device = 'galaxys2';
	$name = 'Samsung Galaxy S2';
}
else if(strtoupper(device_name($file)) == strtoupper('DesireS'))
{
	$board = 'saga';
	$device = 'saga';
	$name = 'HTC Desire S';
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
