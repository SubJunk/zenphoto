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
		<title>Users | <?php printGalleryTitle(); ?></title>
		<?php include('includes/head.php'); ?>
		<?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
		<?php
			$googleAdTopSlot = "6547808732";
			$googleAdBottomSlot = "0546946352";
			if (str_contains($_SERVER['SERVER_NAME'], 'triple')) {
				$googleAdTopSlot = "0095462325";
				$googleAdBottomSlot = "5870141077";
			} else if (str_contains($_SERVER['SERVER_NAME'], 'quad')) {
				$googleAdTopSlot = "6948285745";
				$googleAdBottomSlot = "8640142704";
			}

			$adBoxTopLeft = "";
			$adBoxBottom = '';
			global $_zp_authority;
			$cookies = $_zp_authority->getAuthCookies();
			if (empty($cookies)) {
				$adBoxTopLeft = '
					<div id="AdBoxTopLeft">
						<script type="text/javascript"><!--
						google_ad_client = "ca-pub-3418498412982536";
						/* dmb category top */
						google_ad_slot = "6547808732";
						google_ad_slot="'.$googleAdTopSlot.'"
						google_ad_width = 728;
						google_ad_height = 90;
						//-->
						</script>
						<script type="text/javascript"
						src="//pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
					</div>
				';

				$adBoxBottom = '
					<div id="AdBoxBottom">
						<script type="text/javascript"><!--
						google_ad_client = "ca-pub-3418498412982536";
						/* dmb category bottom */
						google_ad_slot="'.$googleAdBottomSlot.'"
						google_ad_width = 728;
						google_ad_height = 90;
						//-->
						</script>
						<script type="text/javascript"
						src="//pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
					</div>
				';
			}
			?>
	</head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<?php include('includes/header.php'); ?>
			<div id="AboveContentText">
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
								printPageListWithNav("« " . gettext("prev"), gettext("next") . " »");
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
		?>
	</body>
</html>
