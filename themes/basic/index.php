<?php
// force UTF-8 Ø

if (!defined('WEBPATH'))
	die();
?>
<!DOCTYPE html>
<html<?php printLangAttribute(); ?>>
	<head>
		<meta charset="<?php echo LOCAL_CHARSET; ?>">
		<?php zp_apply_filter('theme_head'); ?>
		<?php printHeadTitle(); ?>
		<link rel="stylesheet" href="<?php echo pathurlencode($zenCSS); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo pathurlencode(dirname(dirname($zenCSS))); ?>/common.css" type="text/css" />
		<?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
	</head>
	<body>
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<div id="gallerytitle">
				<?php
				if (getOption('Allow_search')) {
					printSearchForm();
				}
				?>
				<h2><?php
					printHomeLink('', ' | ');
					printGalleryTitle();
					printCurrentPageAppendix(); 
					?></h2>
			</div>
			<div id="padbox">
				<?php
				$rotations = array(
						null,
						'0', // undefined
						'1: Normal (0 deg)',
						'2: Mirrored',
						'3: Upside-down ',
						'4: Upside-down Mirrored',
						'5: 90 deg CW Mirrored',
						'6: 90 deg CCW',
						'7: 90 deg CCW Mirrored',
						'8: 90 deg CW',
						'9' //undefined
				);
				echo '<ul>';
				foreach ($rotations as $value) {
					//$splits = preg_split('/!([(0-9)])/', strval($value));
					//$rotation = $splits[0];
					$rotation = intval(substr(strval($value), 0, 1));
					echo '<li>';
					if (is_null($value)) {
						echo 'NULL';
					} else {
						echo $value;
					}
					echo ' => ' . $rotation;
					echo '</li>';
				}
				echo '</ul>';
				?>
				
				<?php printGalleryDesc(); ?>
				
				
				<div id="albums">
					<?php while (next_album()): ?>
						<div class="album">
							<div class="thumb">
								<a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php printAnnotatedAlbumTitle(); ?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
							</div>
							<div class="albumdesc">
								<h3><a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php printAnnotatedAlbumTitle(); ?>"><?php printAlbumTitle(); ?></a></h3>
								<small><?php printAlbumDate(""); ?></small>
								<div><?php printAlbumDesc(); ?></div>
							</div>
							<p style="clear: both; "></p>
						</div>
					<?php endwhile; ?>
				</div>
				<br class="clearall">
				<?php printPageListWithNav("« " . gettext("prev"), gettext("next") . " »"); ?>
			</div>
		</div>
		<?php include 'inc-footer.php'; ?>
	</body>
</html>