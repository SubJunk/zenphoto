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
		global $_zp_authority;
		$cookies = $_zp_authority->getAuthCookies();
		if (empty($cookies)) { ?>
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3418498412982536" crossorigin="anonymous"></script>
		<?php } ?>
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
