<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();

include('includes/cookiehandler.php');
include('includes/footer.php');

$adBoxTopLeft = '';
$adBoxTopRight = '';
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
	$adBoxTopRight = '
		<div id="AdBoxTopRight">
			<script type="text/javascript">
			google_ad_client = "ca-pub-3418498412982536";
			google_ad_slot = "9005579036";
			google_ad_width = 300;
			google_ad_height = 600;
			</script>
			<!-- qmb category right -->
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
$adBoxTopRight = '';
?>
<!DOCTYPE html>
<html>
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<title>Users | <?php printGalleryTitle(); ?></title>
		<?php include('includes/head.php'); ?>
		<?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
	</head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<div id="gallerytitle">
				<a href="/" id="Logo"></a>
				<?php
				if (getOption('Allow_search')) {
					printSearchForm('', 'search', '', ' ');
				}
				if (function_exists('printUserLogin_out')) {
					callUserFunction('printUserLogin_out', '', '', NULL, ' ');
				}
				?>
			</div>
			<div id="AboveContentText">
				<?php if (!zp_loggedin()) { ?><a href="/page/register/" id="RegisterLink"></a><?php } ?>
				<?php include('includes/resolutionpreferences.php'); ?>
				<h4>Users</h4>
				<span class="subHeading">All user profiles</span>
			</div>
			<div id="padbox">
				<?php echo $adBoxTopLeft; ?>
				<div id="albums" class="thumbnails">
					<ul>
						<?php
							$count = 0;
							while (next_album(false, NULL, true)):
								$count++;
								if ($count == 1) {
									echo $adBoxTopRight;
									?>
									<div id="images">
										<div class="thumbnails topRow">
											<ul>
									<?php
									$hasImage = true;
								}
								?>
								<li>
									<a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo getAnnotatedAlbumTitle(); ?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
									<h3><a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo getAnnotatedAlbumTitle(); ?>"><?php printAlbumTitle(); ?></a></h3>
								</li>
								<?php
							endwhile;
							if ($hasImage) {
								?>
											</ul>
										</div>
									</div>
								<?php
								printPageListWithNav("&laquo; " . gettext("prev"), gettext("next") . " &raquo;");
								echo $adBoxBottom;
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<?php
		getFooter();
		zp_apply_filter('theme_body_close');
		include('includes/piwik.php');
		?>
	</body>
</html>
