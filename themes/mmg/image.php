<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();

include('includes/cookiehandler.php');
include('includes/footer.php');

$height = getFullHeight();
$fullWidth = getFullWidth();
$downloadOptions = '<div id="DownloadOptions">Separate images:<br>';

$relatedItemsCount = 6;
if (str_contains($_SERVER['SERVER_NAME'], 'dual')) {
	$halfWidth = $fullWidth / 2;

	if (!empty($userWidth) && !empty($userHeight) && is_numeric($userWidth) && is_numeric($userHeight)) {
		$halfUserWidth = $userWidth / 2;
	} else {
		$halfUserWidth = $halfWidth;
	}

	$downloadOptions .= '
		<a href="'.getCustomImageURL(null, $halfUserWidth, $userHeight, $halfWidth, $height, '0', '0').'">Left</a> | 
		<a href="'.getCustomImageURL(null, $halfUserWidth, $userHeight, $halfWidth, $height, $halfWidth, '0').'">Right</a>
	';
} else if (str_contains($_SERVER['SERVER_NAME'], 'triple')) {
	$thirdWidth = $fullWidth / 3;
	$thirdWidth2 = $thirdWidth * 2;

	if (!empty($userWidth) && !empty($userHeight) && is_numeric($userWidth) && is_numeric($userHeight)) {
		$thirdUserWidth = $userWidth / 3;
	} else {
		$thirdUserWidth = $thirdWidth;
	}

	$downloadOptions .= '
		<a href="'.getCustomImageURL(false, $thirdUserWidth, $userHeight, $thirdWidth, $height, '0', '0').'">Left</a> | 
		<a href="'.getCustomImageURL(false, $thirdUserWidth, $userHeight, $thirdWidth, $height, $thirdWidth, '0').'">Middle</a> | 
		<a href="'.getCustomImageURL(false, $thirdUserWidth, $userHeight, $thirdWidth, $height, $thirdWidth2, '0').'">Right</a>
	';
	$relatedItemsCount = 4;
} else if (str_contains($_SERVER['SERVER_NAME'], 'quad')) {
	$quarterWidth = $fullWidth / 4;
	$quarterWidth2 = $quarterWidth * 2;
	$quarterWidth3 = $quarterWidth * 3;

	if (!empty($userWidth) && !empty($userHeight) && is_numeric($userWidth) && is_numeric($userHeight)) {
		$quarterUserWidth = $userWidth / 4;
	} else {
		$quarterUserWidth = $quarterWidth;
	}

	$downloadOptions .= '
		<a href="'.getCustomImageURL(false, $quarterUserWidth, $userHeight, $quarterWidth, $height, '0', '0').'">Left</a> | 
		<a href="'.getCustomImageURL(false, $quarterUserWidth, $userHeight, $quarterWidth, $height, $quarterWidth, '0').'">Mid-left</a> | 
		<a href="'.getCustomImageURL(false, $quarterUserWidth, $userHeight, $quarterWidth, $height, $quarterWidth2, '0').'">Mid-right</a> | 
		<a href="'.getCustomImageURL(false, $quarterUserWidth, $userHeight, $quarterWidth, $height, $quarterWidth3, '0').'">Right</a>
	';
	$relatedItemsCount = 3;
}
$downloadOptions .= '</div>';

$adClient = "ca-pub-3418498412982536";
$userAdClient = getAdClient();
if (!empty($userAdClient)) {
	$adClient = $userAdClient;
}

$googleAdTopSlot = "7725395108";
$googleAdBottomSlot = "3448981436";
if (str_contains($_SERVER['SERVER_NAME'], 'triple')) {
	$googleAdTopSlot = "9663446374";
	$googleAdBottomSlot = "6324641038";
} else if (str_contains($_SERVER['SERVER_NAME'], 'quad')) {
	$googleAdTopSlot = "2551180628";
	$googleAdBottomSlot = "1797404444";
}

$adBoxTop = "";
$adBoxBottom = "";
global $_zp_authority;
$cookies = $_zp_authority->getAuthCookies();
if (empty($cookies)) {
	$albumAdSlot = getAdSlot();
	$albumAdClient = getAdClient();
	$adBoxTop = '
		<div id="AdBoxTopLeft">
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<!-- DMB Image Top -->
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
	if (!empty($albumAdSlot) && !empty($albumAdClient)) {
		$adBoxBottom = '
			<div id="AdBoxBottom">
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<ins class="adsbygoogle"
						style="display:block"
						data-ad-client="'.$albumAdClient.'"
						data-ad-slot="'.$albumAdSlot.'"
						data-ad-format="auto"
						data-full-width-responsive="true"></ins>
				<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
		';
	} else {
		$adBoxBottom = '
			<div id="AdBoxBottom">
				<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- DMB Image Middle -->
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
			<?php include('includes/header.php'); ?>
			<div id="AboveContentText">
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

						if (!getNSFW()) {
							echo $adBoxBottom;
						}
					}
					?>
				</div>
			</div>
			<div class="subPadbox thumbnails related-items-container">
				<?php
				if (function_exists('printRelatedItems')) {
					printRelatedItems($relatedItemsCount, "images", null, null, true);
				}
				?>
				<br style="clear:left;">
			</div>
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
						$copyrightText = 'Unknown (Do you own this image or know who does? <a href="/page/contact/?subject=Copyright ' . getParentSiteURL() . getImageURL() . '">Please let us know here</a>).';
						if (!empty($copyrightFromDatabase)) {
							$copyrightText = $copyrightFromDatabase;
						}
					?>
					<div><strong>Copyright:</strong> <?php echo $copyrightText; ?></div>
					<div><strong>Date added:</strong> <?php echo getImageDate("F j, Y"); ?></div>
					<div><strong>Instructions:</strong> <a href="/page/faq" title="How to make backgrounds span across screens">How to make backgrounds span across screens</a></div>
				</div>
				<div class="subPadbox">
					<h2>Rating</h2>
					<?php
					callUserFunction('printRating');
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
		?>
	</body>
</html>
