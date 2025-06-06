<?php
$userWidth  = "";
$userHeight = "";
$disableImageResizing = false;
$enableNSFW = false;
$sFWText = 'non-adult';

if (isset($_GET['userwidth'])) {
	$userWidth  = $_GET['userwidth'];
}
if (isset($_GET['userheight'])) {
	$userHeight = $_GET['userheight'];
}

if (isset($_COOKIE['DisableImageResizing']) && $_COOKIE['DisableImageResizing'] == "yes") {
	$disableImageResizing = true;
}

if (isset($_COOKIE['EnableNSFW']) && $_COOKIE['EnableNSFW'] == "yes") {
	$enableNSFW = true;
	$sFWText = '';
}

if (!empty($userWidth) && !empty($userHeight)) {
	if (is_numeric($userWidth) && is_numeric($userHeight)) {
		$inTwoMonths = 60 * 60 * 24 * 60 + time();
		setcookie('width' , $userWidth , $inTwoMonths, '/');
		setcookie('height', $userHeight, $inTwoMonths, '/');
	} elseif ($userWidth == "all" && $userHeight == "all") {
		setcookie('width' , "", time() - 3600, '/');
		setcookie('height', "", time() - 3600, '/');
		$userWidth  = "";
		$userHeight = "";
	}
} else if (!empty($_COOKIE['width']) && is_numeric($_COOKIE['width']) && !empty($_COOKIE['height']) && is_numeric($_COOKIE['height'])) {
	$userWidth  = $_COOKIE['width'];
	$userHeight = $_COOKIE['height'];
}

$userResolution = "";
if (!empty($userWidth) && !empty($userHeight)) {
	if ($disableImageResizing) {
		$resolutionPreferences = '
			Currently showing all '.$sFWText.' <strong style="color:#c33;">'.$userWidth.'x'.$userHeight.'</strong>+ images<br />
			<a href="javascript:void(0);" id="ResolutionPreferencesLink">Click to change your preferences</a>
		';
	} else {
		$resolutionPreferences = '
			Currently showing all '.$sFWText.' <strong style="color:#c33;">'.$userWidth.'x'.$userHeight.'</strong> images<br />
			<a href="javascript:void(0);" id="ResolutionPreferencesLink">Click to change your preferences</a>
		';
	}
	$userResolution = $userWidth."x".$userHeight;
} else {
	$resolutionPreferences = '
		Currently showing all '.$sFWText.' images<br />
		<a href="javascript:void(0);" id="ResolutionPreferencesLink">Click to set preferences</a>
	';
}

$welcomeTextDisplay = false;
if (isset($_COOKIE['ShowWelcomeText'])) {
	$welcomeTextDisplay = true;
}
?>
