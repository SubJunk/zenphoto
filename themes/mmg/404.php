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
		<title>Page not found | <?php printGalleryTitle(); ?></title>
		<?php include('includes/head.php'); ?>
	</head>
	<body id="BrokenLinkPage">
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<?php include('includes/header.php'); ?>
			<div id="AboveContentText">
				<?php include('includes/resolutionpreferences.php'); ?>
				<h4>Error: <strong>Page not found</strong></h4>
				Broken link
			</div>
			<div id="padbox">
				This is an error page, which probably means the image you were looking for has been removed by its author :(<br />
				Please click the logo on the upper-left corner to find more images, or use the search box to find what you're looking for.
			</div>
		</div>
		<?php
		getFooter();
		zp_apply_filter('theme_body_close');
		?>
	</body>
</html>
