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
		<title>Password | <?php printGalleryTitle(); ?></title>
		<?php include('includes/head.php'); ?>
	</head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<div id="gallerytitle">
				<h2>
					<span>
						<?php printHomeLink('', ' | '); ?>
						<a href="<?php echo html_encode(getGalleryIndexURL()); ?>" title="<?php echo gettext('Gallery Index'); ?>"><?php printGalleryTitle(); ?></a>
					</span> |
					<?php echo gettext("A password is required for the page you requested"); ?>
				</h2>
			</div>
			<div id="padbox">
				<?php printPasswordForm($hint, $show, false); ?>
			</div>
		</div>
		<?php
		getFooter();
		zp_apply_filter('theme_body_close');
		include('includes/piwik.php');
		?>
	</body>
</html>
