<?

/*
	MIUIAndroid OTA Update manager file for front-end file delivery system

	Written by: MarkHUK
	
	Last modified: Wednesday August 17th 2011

	update.json?g=6884c3642fc5a684&v=MIUI-1.8.12&b=spade&d=ace&i=IMEI&t=XIAOMI-SESSION-TOKEN


*/

// Include the OTA config file (MUST BE Included!)
include('libs/config.php');

// Set the new and old versions manually e.g. new = 1.8.12 old = 1.8.5

$new_ver = '1_8_30';

$old_ver = '1_8_19';

if(empty($_GET))
{
	echo 'Invalid input';
	exit;
}

// Define OTA variables below

// Hardware ID
$hardware_id = sanitise($_REQUEST['g'], FULLSCAN);

// Users currently installed version
$current_version = sanitise($_REQUEST['v'], FULLSCAN);

// Manufacturer board name e.g. herring
$hardware_board = $_REQUEST['b'];

// Manufacturer device name e.g. crespo (Nexus S)
$device_name = $_REQUEST['d'];

// IMEI code (Last 9 digits stored only)
$imei_code = sanitise($_REQUEST['i'], FULLSCAN);

// Session Token used for MIUI.com forums
$token = sanitise($_REQUEST['t'], FULLSCAN);

// Perform version check to see if there is a new version
if(current_rom($current_version, $hardware_board, $device_name) == true)
{
	$new_version = get_new_version($current_version, $hardware_board, $device_name);
}
else
{
	$new_version = $current_version;
}
// End check new version

echo '{
    "UserLevel": 9,
    "LatestVersion": {
        "type": "rom",
	"board": "'.$hardware_board.'",
	"name": "'.get_device_name($hardware_board, $device_name, $new_version).' '.$new_version.'",
        "acknowledgementUrl": "http://miuiandroid.com/ota/'.$new_ver.'_ack.html",
        "descriptionUrl": "http://miuiandroid.com/ota/'.$new_ver.'_desc.html",
        "acknowledgement": "",
        "description":"MIUIAndroid '.get_device_name($hardware_board, $device_name, $new_version).' ROM '.$new_version.'",
        "checksum":"'.get_new_checksum($hardware_board, $device_name, $new_version).'",
        "filename":"'.get_new_filename($hardware_board, $device_name, $new_version).'",
        "filesize":"'.get_new_filesize($hardware_board, $device_name, $new_version).'",
        "mod":"'.$device_name.'",
        "version": "'.$new_version.'",
        "branch": "'.get_branch($hardware_board, $device_name, $new_version).'"
   },
    "UpdateList": [
        {
            "type": "rom",
            "board": "'.$hardware_board.'",
            "name": "'.get_device_name($hardware_board, $device_name, $new_version).' '.$current_version.'",
            "acknowledgementUrl": "http://miuiandroid.com/ota/'.$old_ver.'_ack.html",
            "acknowledgement": "",
            "description": "",
            "descriptionUrl": "http://miuiandroid.com/ota/'.$old_ver.'_desc.html",
	    "checksum":"'.get_new_checksum($hardware_board, $device_name, $current_version).'",
	    "filename":"'.get_filename($hardware_board, $device_name, $current_version).'",
	    "filesize":"'.get_new_filesize($hardware_board, $device_name, $current_version).'",
	    "mod":"'.$device_name.'",
            "version": "'.$current_version.'",
            "branch": "'.get_branch($hardware_board, $device_name, $current_version).'"
        }
    ],
    "IncrementalUpdateList": [
        {
	    "type":"rom",
	    "board":"'.$hardware_board.'",
	    "name":"'.get_device_name($hardware_board, $device_name, $new_version).' OTA from: '.$current_version.'",
	    "acknowledgementUrl":"",
            "acknowledgementUrl": "http://miuiandroid.com/ota/'.$new_ver.'_ack.html",
            "descriptionUrl": "http://miuiandroid.com/ota/'.$new_ver.'_desc.html",
	    "description":"MIUIAndroid '.get_device_name($hardware_board, $device_name, $new_version).' ROM '.$new_version.'",
            "checksum":"'.get_new_checksum($hardware_board, $device_name, $new_version).'",
            "filename":"'.get_new_filename($hardware_board, $device_name, $new_version).'",
	    "filesize":"'.get_new_filesize($hardware_board, $device_name, $new_version).'",
	    "mod":"'.$device_name.'",
	    "version":"'.substr($new_version, 5).'",
	    "versionForApply":"'.substr($current_version, 5).'",
	    "branch":"X"
        }
    ],
    "MirrorList": [
        "http://miuiandroid.com/ota/"
    ],
    "Signup": {
        "version": "'.$new_version.'",
        "total": "",
        "rank": ""
    }
}';
?>