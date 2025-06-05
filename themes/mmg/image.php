<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();

include('includes/cookiehandler.php');
include('includes/footer.php');

$fullWidth = getFullWidth();
$quarterWidth = $fullWidth / 4;
$quarterWidth2 = $quarterWidth * 2;
$quarterWidth3 = $quarterWidth * 3;
$height = getFullHeight();

if (!empty($userWidth) && !empty($userHeight)) {
	$quarterUserWidth = $userWidth / 4;
} else {
	$quarterUserWidth = $quarterWidth;
}

$downloadOptions = '
	<div id="DownloadOptions">
		Separate images:<br>
		<a href="'.getCustomImageURL(false, $quarterUserWidth, $userHeight, $quarterWidth, $height, '0', '0').'">Left</a> | 
		<a href="'.getCustomImageURL(false, $quarterUserWidth, $userHeight, $quarterWidth, $height, $quarterWidth, '0').'">Mid-left</a> | 
		<a href="'.getCustomImageURL(false, $quarterUserWidth, $userHeight, $quarterWidth, $height, $quarterWidth2, '0').'">Mid-right</a> | 
		<a href="'.getCustomImageURL(false, $quarterUserWidth, $userHeight, $quarterWidth, $height, $quarterWidth3, '0').'">Right</a>
	</div>
';

$adBoxTop = '';
$adBoxBottom = '';
global $_zp_authority;
$cookies = $_zp_authority->getAuthCookies();
if (empty($cookies)) {
	$albumAdSlot = getAdSlot();
	$albumAdClient = getAdClient();
	$adBoxTop = '
		<div id="AdBoxTopLeft">
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<ins class="adsbygoogle"
			     style="display:inline-block;width:728px;height:90px"
			     data-ad-client="ca-pub-3418498412982536"
			     data-ad-slot="2551180628"></ins>
			<script>
			     (adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
	';
	if (!empty($albumAdSlot) && !empty($albumAdClient)) {
		$adBoxBottom = '
			<div id="AdBoxBottom">
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
				     style="display:inline-block;width:728px;height:90px"
				     data-ad-client="'.$albumAdClient.'"
				     data-ad-slot="'.$albumAdSlot.'"></ins>
				<script>
				     (adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		';
	} else {
		$adBoxBottom = '
			<div id="AdBoxBottom">
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
				     style="display:inline-block;width:728px;height:90px"
				     data-ad-client="ca-pub-3418498412982536"
				     data-ad-slot="1797404444"></ins>
				<script>
				     (adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		';
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<title><?php printBareImageTitle(); ?> | <?php printBareAlbumTitle(); ?> | <?php printGalleryTitle(); ?></title>
		<?php include('includes/head.php'); ?>
		<?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
	</head>
	<body id="ImagePage">
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<div id="gallerytitle">
				<a href="/" id="Logo"></a>
				<?php
				if (getOption('Allow_search')) {
					printSearchForm('', 'search', '', ' ');
				}
				if (!zp_loggedin() && function_exists('printRegistrationForm')) {
					?>

					<?php
				}
				if (function_exists('printUserLogin_out')) {
					callUserFunction('printUserLogin_out', '', '', NULL, ' ');
				}
				?>
			</div>
			<div id="AboveContentText">
				<?php if (!zp_loggedin()) { ?><a href="/page/register/" id="RegisterLink"></a><?php } ?>
				<?php include('includes/resolutionpreferences.php'); ?>
				<h1>Image: <strong><?php printImageTitle(true); ?></strong></h1>
				<?php
					$imageByArray = getAlbumBreadcrumb();
					if (empty($imageByArray['link'])) {
						$imageBy = '<a href="'.getAlbumURL().'">'.getBareAlbumTitle().'</a>';
					} else {
						$imageBy = '<a href="'.$imageByArray['link'].'">'.$imageByArray['title'].'</a>';
					}
				?>
				<span class="subHeading">by <?php echo $imageBy; ?></span>
			</div>
			<div id="padbox">
				<div id="SingleImageContainer">
					<?php
					if (!getNSFW()) {
						echo $adBoxTop;
					}

					$bareImageTitle = html_encode(getBareImageTitle());
					$originalImageWidth = getFullWidth();
					$originalImageHeight = getFullHeight();
					$resizedImage = false;
					if (getNSFW() && !$enableNSFW) {
						?>
						<a href="javascript:void(0);" class="EnableNSFW" title="NSFW">
							<img src="/themes/mmg/images/nsfwblocker.png" alt="NSFW">
						</a>
						<?php
					} else {
						if (!empty($userWidth) && !empty($userHeight) && !$disableImageResizing) {
							$userCustomImageURL = getCustomImageURL(null, $userWidth, $userHeight, $userWidth, $userHeight, null, null, false);
							echo '
								<a href="'.$userCustomImageURL.'" title="'.$bareImageTitle.'">
									<img src="'.$userCustomImageURL.'" alt="'.$bareImageTitle.'">
								</a>
							';
							$resizedImage = true;
						} else {
							$fullimage = getFullImageURL();
							if (!empty($fullimage)) {
								?>
								<a href="<?php echo html_encode($fullimage); ?>" title="<?php echo $bareImageTitle; ?>">
									<img src="<?php echo html_encode($fullimage); ?>" alt="<?php echo getImageTitle(); ?>">
								</a>
								<?php
							}
						}
						echo $downloadOptions;
					}

					if (!getNSFW()) {
						echo $adBoxBottom;
					}
					?>
				</div>
			</div>
			<?php
			if (function_exists('printRelatedItems')) {
				printRelatedItems(3, "images", null, null, true);
			}
			?>
			<div class="halfWidth">
				<div class="subPadbox imageInfo">
					<h2>Details</h2>
					<div><strong>Description:</strong>
					<?php
					$imageDescription = getImageDesc();
					if (!empty($imageDescription)) {
						printImageDesc(true);
					} else {
						printImageTitle(true);
					}
					?>
					</div>
					<?php
					$tempTags = getTags();
					if (!empty($tempTags)) {
						echo "<div>";
						printTags('links', gettext('<strong>Tags:</strong>') . ' ', 'taglist', '');
						echo '<br style="clear:left;"></div>';
					}
					?>
					<div><strong><?php if($resizedImage) { echo 'Original '; } ?>Resolution:</strong> <?php echo $originalImageWidth . 'x' . $originalImageHeight; ?></div>
					<?php
						$copyrightFromDatabase = $_zp_current_image->getCopyright();
						$copyrightText = 'Unknown (Do you own this image or know who does? <a href="/page/contact/?subject=Copyright ' . getMainSiteURL() . getImageURL() . '">Please let us know here</a>).';
						if (!empty($copyrightFromDatabase)) {
							$copyrightText = $copyrightFromDatabase;
						}
					?>
					<div><strong>Copyright:</strong> <?php echo $copyrightText; ?></div>
					<div><strong>Date added:</strong> <?php echo getImageDate("%e %B %Y"); ?></div>
					<div><strong>Instructions:</strong> <a href="/page/faq" title="How to make backgrounds span across screens">How to make backgrounds span across screens</a></div>
				</div>
				<div class="subPadbox">
					<h2>Rating</h2>
					<?php
					if (function_exists('printRating')) {
						printRating();
					}
					if (function_exists('printAddToFavorites')) {
						echo '<div style="margin-top:10px;">';
						printAddToFavorites($_zp_current_image);
						echo '</div>';
					}
					?>
				</div>
			</div>
			<div class="halfWidth">
				<div class="right">
					<div class="subPadbox commentsContainer">
						<h2>Comments</h2>
						<?php callUserFunction('printCommentForm'); ?>
					</div>
				</div>
			</div>
			<br style="clear:left;">
		</div>
		<?php
		getFooter(false, 'Image ' . getBareImageTitle() . ' (' . getFullImageURL() . ')');
		zp_apply_filter('theme_body_close');
		include('includes/piwik.php');
		?>
	</body>
</html>
