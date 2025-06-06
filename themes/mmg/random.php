<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die();

$adBoxTopLeft = '';
$adBoxBottom = '';
global $_zp_authority;
$cookies = $_zp_authority->getAuthCookies();
if (empty($cookies)) {
	$adBoxTopLeft = '
		<div id="AdBoxTopLeft">
			<script type="text/javascript">
			google_ad_client = "ca-pub-3418498412982536";
			google_ad_slot = "6948285745";
			google_ad_width = 728;
			google_ad_height = 90;
			</script>
			<!-- qmb category top -->
			<script type="text/javascript"
			src="//pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
	';

	$adBoxBottom = '
		<div id="AdBoxBottom">
			<script type="text/javascript">
			google_ad_client = "ca-pub-3418498412982536";
			google_ad_slot = "8640142704";
			google_ad_width = 728;
			google_ad_height = 90;
			</script>
			<!-- qmb category bottom -->
			<script type="text/javascript"
			src="//pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
	';
}

include('includes/cookiehandler.php');
include('includes/footer.php');
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
			<div id="gallerytitle">
				<a href="/" id="Logo"></a>
				<?php
				if (getOption('Allow_search')) { printSearchForm('', 'search', '', ' '); }

				if (function_exists('printUserLogin_out')) {
					callUserFunction('printUserLogin_out', '', '', NULL, ' ');
				}
				?>
			</div>
			<div id="AboveContentText">
				<?php
				if (!zp_loggedin()) { ?><a href="/page/register/" id="RegisterLink"></a><?php }
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
					printImageStatistic($thumbnailsPerPage, "random", '', true, false, false, 40, false, 608, 109, true);
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
