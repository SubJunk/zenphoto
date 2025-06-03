<?php
// force UTF-8
if (!defined('WEBPATH'))
	die();

include('includes/cookiehandler.php');
include('includes/footer.php');

$adBoxTop = '';
$adBoxBottom = '';
global $_zp_authority;
$cookies = $_zp_authority->getAuthCookies();
if (empty($cookies)) {
	$adBoxTop = '
		<div id="AdBoxTopLeft">
			<script type="text/javascript">
			google_ad_client = "ca-pub-3418498412982536";
			google_ad_slot = "7244438630";
			google_ad_width = 728;
			google_ad_height = 90;
			</script>
			<!-- qmb search top (2) -->
			<script type="text/javascript"
			src="//pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
	';

	$adBoxBottom = '
		<div id="AdBoxBottom">
			<script type="text/javascript">
			google_ad_client = "ca-pub-3418498412982536";
			google_ad_slot = "1197905038";
			google_ad_width = 728;
			google_ad_height = 90;
			</script>
			<!-- qmb search bottom (2) -->
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
		<title>Search | <?php printGalleryTitle(); ?></title>
		<?php include('includes/head.php'); ?>
		<?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
	</head>
	<body id="SearchPage">
		<?php
		zp_apply_filter('theme_body_open');
		?>
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
				<?php
				if (!zp_loggedin()) { ?><a href="/page/register/" id="RegisterLink"></a><?php }
				include('includes/resolutionpreferences.php'); ?>
				<h4>Search: <strong><?php echo getSearchWords(); ?></strong></h4>
				<span class="subHeading">Results</span>
			</div>
			<div id="padbox">
				<?php echo $adBoxTop; ?>
				<h2>Images</h2>
				<div id="albumsSearch" class="thumbnails">
					<ul>
						<?php while (next_image()): $c++; ?>
							<li>
								<a href="<?php echo html_encode(getImageURL()); ?>" title="<?php echo html_encode(getBareImageTitle()); ?>">
									<?php printImageThumb(getAnnotatedImageTitle()); ?>
								</a>
								<h3>
									<a href="<?php echo html_encode(getImageURL()); ?>" title="<?php echo html_encode(getBareImageTitle()); ?>">
										<?php echo html_encode(getBareImageTitle()); ?>
									</a>
								</h3>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
				<?php
				if ($c == 0) {
					echo "<p>" . gettext("Sorry, no image matches found. Try refining your search.") . "</p>";
				} else {
					printPageListWithNav("&laquo; " . gettext("prev"), gettext("next") . " &raquo;");
				}
				echo $adBoxBottom;
				?>
				<span class="AfterImagesBreak"></span>
			</div>
			<?php
			$isAlbumResult = false;
			$c = 0;
			while (next_album()): $c++;
				if ($c == 1) {
					$isAlbumResult = true;
					?>
				<div class="subPadbox">
					<h2>Users</h2>
					<div id="albumsusersinner" class="thumbnails">
						<ul>
				<?php } ?>
						<li>
							<a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php printAlbumTitle(); ?>">
								<?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?>
							</a>
							<h3>
								<a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php printAlbumTitle(); ?>"><?php printAlbumTitle(); ?></a>
							</h3>
						</li>
			<?php
			endwhile;
			if ($isAlbumResult) { ?>
					</ul>
				</div>
				<span class="AfterImagesBreak"></span>
			</div>
			<?php
			}
			?>
		</div>
		<?php
		getFooter();
		zp_apply_filter('theme_body_close');
		include('includes/piwik.php');
		?>
	</body>
</html>
