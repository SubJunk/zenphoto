<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die();

include('includes/cookiehandler.php');
include('includes/footer.php');

$thumbnailsPerPage = 30;
$thumbnailWidth = 293;
$thumbnailHeight = 100;
$googleAdTopSlot = "7478568232";
$googleAdBottomSlot = "2908767835";
if (str_contains($_SERVER['SERVER_NAME'], 'triple')) {
	$thumbnailsPerPage = 20;
	$thumbnailWidth = 450;
	$thumbnailHeight = 108;
	$googleAdTopSlot = "2441738636";
	$googleAdBottomSlot = "8348671432";
} else if (str_contains($_SERVER['SERVER_NAME'], 'quad')) {
	$thumbnailsPerPage = 15;
	$thumbnailWidth = 608;
	$thumbnailHeight = 109;
	$googleAdTopSlot = "6948285745";
	$googleAdBottomSlot = "8640142704";
}

$adBoxTopLeft = "";
$adBoxBottom = '';
global $_zp_authority;
$cookies = $_zp_authority->getAuthCookies();
if (empty($cookies)) {
	$adBoxTopLeft = '
		<div id="AdBoxTopLeft">
			<script type="text/javascript"><!--
			google_ad_client = "ca-pub-3418498412982536";
			/* dmb category top */
			google_ad_slot = "6547808732";
			google_ad_slot="'.$googleAdTopSlot.'"
			google_ad_width = 728;
			google_ad_height = 90;
			//-->
			</script>
			<script type="text/javascript"
			src="//pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
	';

	$adBoxBottom = '
		<div id="AdBoxBottom">
			<script type="text/javascript"><!--
			google_ad_client = "ca-pub-3418498412982536";
			/* dmb category bottom */
			google_ad_slot="'.$googleAdBottomSlot.'"
			google_ad_width = 728;
			google_ad_height = 90;
			//-->
			</script>
			<script type="text/javascript"
			src="//pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
	';
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<title>Random Images | <?php printGalleryTitle(); ?></title>
		<?php include('includes/head.php'); ?>
		<?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
	</head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<?php include('includes/header.php'); ?>
			<div id="AboveContentText">
				<?php
				include('includes/resolutionpreferences.php'); ?>
				<h4>Random Images</strong></h4>
				<span class="subHeading">From all categories and users</span>
			</div>
			<div id="padbox">
				<?php
					$thumbnailsPerPage = 30;

					echo $adBoxTopLeft;

					require_once(dirname(dirname(__FILE__)).'/../zp-core/'.PLUGIN_FOLDER.'/image_album_statistics.php');
					echo '<div id="albumsSearch" class="thumbnails topRow">';
					printImageStatistic($thumbnailsPerPage, "random", '', true, false, false, 40, false, $thumbnailWidth, $thumbnailHeight, true);
					echo '</div>';
				?>
				<span class="AfterImagesBreak"></span>
				<?php echo $adBoxBottom; ?>
			</div>
		</div>
		<?php
		getFooter(false, 'Random');
		zp_apply_filter('theme_body_close');
		?>
	</body>
</html>
