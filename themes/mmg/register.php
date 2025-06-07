<?php
// force UTF-8 Ø

if (!defined('WEBPATH'))
	die();
if (function_exists('printRegistrationForm')) {
	include('includes/cookiehandler.php');
	include('includes/footer.php');
	?>
	<!DOCTYPE html>
	<html>
		<head>
			<?php zp_apply_filter('theme_head'); ?>
			<title>Register | <?php printGalleryTitle(); ?></title>
			<?php include('includes/head.php'); ?>
		</head>
		<body>
			<?php zp_apply_filter('theme_body_open'); ?>
			<div id="main">
				<div id="gallerytitle">
					<a href="/" id="Logo"></a>
				<div class="registerOrLoginLinks">
					<?php
					callUserFunction('printUserLogin_out', '', ' ', NULL, ' ');
					?>
				</div>
					<?php if (getOption('Allow_search')) {
						printSearchForm('', 'search', '', ' ');
					} ?>
				</div>
				<div id="AboveContentText">
					<?php include('includes/resolutionpreferences.php'); ?>
					<h4>Register</h4>
					<span class="subHeading">It's free!</span>
				</div>
				<div class="halfWidth">
					<div class="subPadbox">
						<?php printRegistrationForm(); ?>
					</div>
				</div>
				<div class="halfWidth">
					<div class="right">
						<div class="subPadbox">
							<h2>Why register?</h2>
							<ul style="margin-left:20px;list-style-type:disc;">
								<li>
									<h2 style="font-size:18px;color:#c66;margin:0;padding:0 0 5px 0;">Make money</h2>
									<ul style="margin:0 0 10px 20px;">
										<li>Display your own Google AdSense ads on your profile and image pages to make money. <strong>You keep 100% of the profits!</strong></li>
									</ul>
								</li>
								<li>
									<h2 style="font-size:18px;color:#c66;margin:0;padding:0 0 5px 0;">See less ads</h2>
									<ul style="margin:0 0 10px 20px;">
										<li>Some ads are hidden for members, allowing you to see a cleaner website</li>
									</ul>
								</li>
								<li>
									<h2 style="font-size:18px;color:#c66;margin:0;padding:0 0 5px 0;">Fame</h2>
									<ul style="margin:0 0 10px 20px;">
										<li>This is a high-traffic website, meaning that when you add your art it will be seen by a huge amount of people</li>
									</ul>
								</li>
							</ul>
							<h2>Rules</h2>
							<ul style="margin-left:20px;list-style-type:disc;">
								<li>
									<h2 style="font-size:18px;color:#c66;margin:0;padding:0 0 5px 0;">Adult content labeling</h2>
									<ul style="margin:0 0 10px 20px;">
										<li>If you upload adult content you must mark it as NSFW using the checkbox on the right.</li>
									</ul>
								</li>
								<li>
									<h2 style="font-size:18px;color:#c66;margin:0;padding:0 0 5px 0;">Ownership</h2>
									<ul style="margin:0 0 10px 20px;">
										<li>You must only upload content you have created unless you have permission from the owner.</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<br style="clear:left;">
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
