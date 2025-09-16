<?php
// force UTF-8
if (!defined('WEBPATH'))
	die();

include('includes/cookiehandler.php');
include('includes/footer.php');

$googleAdTopSlot = "4377943147";
$googleAdBottomSlot = "1504367798";
if (str_contains($_SERVER['SERVER_NAME'], 'triple')) {
	$googleAdTopSlot = "2134923184";
	$googleAdBottomSlot = "1430832714";
} else if (str_contains($_SERVER['SERVER_NAME'], 'quad')) {
	$googleAdTopSlot = "7244438630";
	$googleAdBottomSlot = "1197905038";
}

$adBoxTop = '';
$adBoxBottom = "";
global $_zp_authority;
$cookies = $_zp_authority->getAuthCookies();
if (empty($cookies)) {
	$adBoxTop = '
		<div id="AdBoxTopLeft">
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- DMB Search Top -->
			<ins class="adsbygoogle"
					style="display:block"
					data-ad-client="ca-pub-3418498412982536"
					data-ad-slot="'.$googleAdTopSlot.'"
					data-ad-format="auto"
					data-full-width-responsive="true"></ins>
			<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
	';

	$adBoxBottom = '
		<div id="AdBoxBottom">
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- DMB Search Bottom -->
			<ins class="adsbygoogle"
					style="display:block"
					data-ad-client="ca-pub-3418498412982536"
					data-ad-slot="'.$googleAdBottomSlot.'"
					data-ad-format="auto"
					data-full-width-responsive="true"></ins>
			<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
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
			<?php include('includes/header.php'); ?>
			<div id="AboveContentText">
				<?php
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
					printPageListWithNav("« " . gettext("prev"), gettext("next") . " »");
					echo $adBoxBottom;
				}
				?>
				<span class="AfterImagesBreak"></span>
			</div>
		</div>
		<?php
		getFooter();
		zp_apply_filter('theme_body_close');
		?>
	</body>
</html>
