<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();

$isOfficialCategory = false;

include('includes/cookiehandler.php');
include('includes/footer.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<title>Favorites | <?php printGalleryTitle(); ?></title>
		<?php include('includes/head.php'); ?>
		<?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
		<?php
		global $_zp_authority;
		$cookies = $_zp_authority->getAuthCookies();
		if (empty($cookies)) { ?>
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-3418498412982536" crossorigin="anonymous"></script>
		<?php } ?>
	</head>
	<body id="FavoritesPage">
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<div id="gallerytitle">
				<a href="/" id="Logo"></a>
				<div class="registerOrLoginLinks">
					<?php
					callUserFunction('registerUser::printLink', gettext('Register'), '', ' | ');
					callUserFunction('printUserLogin_out', '', ' ', NULL, ' ');
					?>
				</div>
				<?php
				if (getOption('Allow_search')) {
					printSearchForm('', 'search', '', ' ');
				}
				?>
			</div>
			<div id="AboveContentText">
				<?php include('includes/resolutionpreferences.php'); ?>
					<h4>Your: <strong>Favorites</strong></h4>
					<span class="subHeading">Manage and view your favorites</span>
			</div>
			<?php
			$hasAlbum = false;
			$count = 0;
			while (next_album()):
				$count++;
				if ($count == 1) {
					echo '
						<div id="padbox">
							<div id="albums">
					';
					$hasAlbum = true;
				} ?>
				<div class="album">
					<div class="thumb">
						<a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php printAnnotatedAlbumTitle(); ?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
					</div>
					<div class="albumdesc">
						<h3><a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php printAnnotatedAlbumTitle(); ?>"><?php printAlbumTitle(); ?></a></h3>
						<small><?php printAlbumDate(""); ?></small>
						<div><?php printAlbumDesc(); ?>
						<?php printAddToFavorites($_zp_current_album, '',gettext('Remove')); ?></div>
					</div>
					<p style="clear: both; "></p>
				</div>
			<?php
			endwhile;
			if ($hasAlbum) {
				echo '
						</div>
					</div>
				';
			}
			?>
			<div class="subPadbox">
				<div id="albumsSearch">
					<div class="thumbnails">
						<ul>
						<?php
						while (next_image()) {
							?>
							<li class="image">
								<a href="<?php echo html_encode(getImageURL()); ?>" title="<?php echo html_encode(getBareImageTitle()); ?>">
								<?php printImageThumb(getAnnotatedImageTitle()); ?></a>
								<h3><a href="<?php echo html_encode(getImageURL()); ?>" title="<?php echo html_encode(getBareImageTitle()); ?>">
								<?php echo html_encode(getBareImageTitle()); ?></a></h3>
								<?php printAddToFavorites($_zp_current_image, '',gettext('Remove')); ?>
							</li>
							<?php
						}
						?>
						</ul>
					</div>
				</div>
				<?php @call_user_func('printSlideShowLink'); ?>
				<?php printPageListWithNav("« " . gettext("prev"), gettext("next") . " »"); ?>
				<span class="AfterImagesBreak"></span>
			</div>
			<br style="clear:left;">
		</div>
		<?php
		getFooter(true, 'Favorites');
		zp_apply_filter('theme_body_close');
		?>
	</body>
</html>
