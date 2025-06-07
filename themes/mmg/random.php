<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die();

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
		<?php
		global $_zp_authority;
		$cookies = $_zp_authority->getAuthCookies();
		if (empty($cookies)) { ?>
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3418498412982536" crossorigin="anonymous"></script>
		<?php } ?>
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

					require_once(dirname(dirname(__FILE__)).'/../zp-core/'.PLUGIN_FOLDER.'/image_album_statistics.php');
					echo '<div id="albumsSearch" class="thumbnails topRow">';
					printImageStatistic($thumbnailsPerPage, "random", '', true, false, false, 40, false, 608, 109, true);
					echo '</div>';
				?>
				<span class="AfterImagesBreak"></span>
			</div>
		</div>
		<?php
		getFooter(false, 'Random');
		zp_apply_filter('theme_body_close');
		?>
	</body>
</html>
