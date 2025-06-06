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
		<title>FAQ | <?php printGalleryTitle(); ?></title>
		<?php include('includes/head.php'); ?>
	</head>
	<body id="FAQ">
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
				<?php if (!zp_loggedin()) { ?><a href="/page/register/" id="RegisterLink"></a><?php } ?>
				<?php include('includes/resolutionpreferences.php'); ?>
				<h4>FAQ</h4>
				<span class="subHeading">Frequently Asked Questions</span>
			</div>
			<div id="padbox">
				<h2>How can I make a quad monitor background span across screens?</h2>
				<ul>
					<li>
						On Windows 7:
						<ol>
							<li>
								Find the image you want to use on dmb and save it to your computer by using either <strong>ctrl+s</strong> or right-clicking.
							</li>
							<li>
								Right-click on your desktop and click <strong>Personalize</strong>.
							</li>
							<li>
								In the window that opens up, click <strong>Desktop Background</strong> on the lower left.
							</li>
							<li>
								In that window, select the folder that contains the image you want to use by using the <strong>Picture location</strong> options near the top.
							</li>
							<li>
								Set the <strong>Picture position</strong> option on the lower left to <strong>Tile</strong> and now it should be working!
							</li>
							<li>
								<strong>Note:</strong>If the image is not the exact size for your monitors, it won't fit nicely.<br>
								To make sure your images are always the perfect size for your monitors, click on <strong>Click to set preferences</strong> on dmb so we can automatically resize and crop images to your size.
							</li>
						</ol>
					</li>
				</ul><br style="clear:left;">
				<h2>How can I add a taskbar to my other screens?</h2>
				<ul>
					<li>
						On Windows:
						<ol>
							<li>
								<a href="http://www.realtimesoft.com/ultramon/" title="UltraMon">UltraMon</a> and <a href="http://www.displayfusion.com" title="DisplayFusion">DisplayFusion</a> are programs that add a taskbar to more than one monitor.<br>
								They both have 30-day trials.
							</li>
						</ol>
					</li>
				</ul><br style="clear:left;">
				<h2>How can I add my Google AdSense ads to my images and profile?</h2>
				<ol>
					<li>
						Go to the <a href="https://www.google.com/adsense">AdSense website</a>. Log in (create an account first if you don't have one).
					</li>
					<li>
						Go to the <strong>My ads</strong> tab.
					</li>
					<li>
						Click the <strong>New ad unit</strong> button.<br>
						<img src="/themes/mmg/images/faq-adsense-step3.png">
					</li>
					<li>
						Fill in whatever options you want, making sure the <strong>Ad size</strong> is <strong>728x90</strong>.
					</li>
					<li>
						Click the <strong>Save and get code</strong> button.
					</li>
					<li>
						Go to your <strong>Edit profile</strong> page on this website by using the <strong>User Options</strong> menu on the upper right when you are logged in.
					</li>
					<li>
						Use the image guide on that page to see which fields are required.
					</li>
					<li>
						Click Apply, now your ads will be displayed on your profile and image pages!
					</li>
				</ol><br style="clear:left;">
				<h2>What are the rules regarding content?</h2>
				<ol>
					<li>
						If you upload adult content you must mark it as NSFW using the checkbox on the right.
					</li>
					<li>
						You must only upload content you have created unless you have permission from the owner.
					</li>
					<li>
						No links, banners, buttons, etc. are allowed in the image titles, descriptions or copyright fields.<br>
						The one exception is that in the copyright field you are allowed to link to the relevant website of the copyright owner.
					</li>
				</ol>
			</div>
		</div>
		<?php
		getFooter();
		zp_apply_filter('theme_body_close');
		?>
	</body>
</html>
