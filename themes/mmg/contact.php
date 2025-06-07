<?php
// force UTF-8 Ø

if (!defined('WEBPATH'))
	die();
if (function_exists('printContactForm')) {
	include('includes/cookiehandler.php');
	include('includes/footer.php');
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<?php zp_apply_filter('theme_head'); ?>
			<title>Contact | <?php printGalleryTitle(); ?></title>
			<?php include('includes/head.php'); ?>
		</head>
		<body id="ContactPage">
			<?php zp_apply_filter('theme_body_open'); ?>
			<div id="main">
				<?php include('includes/header.php'); ?>
				<div id="AboveContentText">
					<?php include('includes/resolutionpreferences.php'); ?>
					<h4><?php echo gettext('Contact us.') ?></h4>
					<span class="subHeading">We will usually reply within one day</span>
				</div>
				<div id="padbox">
					<?php
						$subject = '';
						if (isset($_GET['subject'])) {
							$subject =  sanitize($_GET['subject'], 3);
						}
						contactForm::printContactForm($subject);
					?>
				</div>
			</div>
			<?php
			getFooter();
			zp_apply_filter('theme_body_close');
			?>
		</body>
	</html>
	<?php
} else {
	include(dirname(__FILE__) . '/404.php');
}
?>
