<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();

$isOfficialCategory = false;

include('includes/cookiehandler.php');
include('includes/footer.php');

$adBoxTopLeft = '';
$adBoxBottom = '';
global $_zp_authority;
$cookies = $_zp_authority->getAuthCookies();
if (empty($cookies)) {
	$adBoxTopLeft = '
		<div id="AdBoxTopLeft">
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<ins class="adsbygoogle"
			     style="display:inline-block;width:728px;height:90px"
			     data-ad-client="ca-pub-3418498412982536"
			     data-ad-slot="6948285745"></ins>
			<script>
			     (adsbygoogle = window.adsbygoogle || []).push({});
			</script>
		</div>
	';

	$albumAdSlot = getAdSlot();
	$albumAdClient = getAdClient();
	if (!empty($albumAdSlot) && !empty($albumAdClient)) {
		$adBoxBottom = '
			<div id="AdBoxBottom">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- qmb category bottom -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:728px;height:90px"
				     data-ad-client="ca-pub-3418498412982536"
				     data-ad-slot="8640142704"></ins>
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
		<title><?php printAlbumTitle(); ?> | <?php printGalleryTitle(); ?></title>
		<?php include('includes/head.php'); ?>
		<?php if (class_exists('RSS')) printRSSHeaderLink('Album', getAlbumTitle()); ?>
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
				if (!zp_loggedin() && function_exists('printRegistrationForm')) {
					?>

					<?php
				}
				if (function_exists('printUserLogin_out')) {
					?>
					<div id="LoginContainer">
					<?php printUserLogin_out('', '', NULL, ' '); ?>
					</div>
					<?php
				}
				?>
			</div>
			<div id="AboveContentText">
				<?php if (!zp_loggedin()) { ?><a href="/page/register/" id="RegisterLink"></a><?php } ?>
				<?php include('includes/resolutionpreferences.php'); ?>
				<?php
				if (
					getAlbumTitle() != "Abstract" &&
					getAlbumTitle() != "Animals" &&
					getAlbumTitle() != "Astronomy" &&
					getAlbumTitle() != "Celebrities" &&
					getAlbumTitle() != "Computers / Technology" &&
					getAlbumTitle() != "Crafted Nature" &&
					getAlbumTitle() != "Gaming" &&
					getAlbumTitle() != "Industrial" &&
					getAlbumTitle() != "Macabre / Surreal" &&
					getAlbumTitle() != "Microscopic" &&
					getAlbumTitle() != "Nature" &&
					getAlbumTitle() != "Popular Culture" &&
					getAlbumTitle() != "Science Fiction / Fantasy"
				) {
					?>
					<h4>User: <strong><?php echo getAlbumTitle(); ?></strong></h4>
					<span class="subHeading">Profile</span>
					<?php
				} else {
					$isOfficialCategory = true;
					?>
					<h4>Category: <strong><?php echo getAlbumTitle(); ?></strong></h4>
					<span class="subHeading">Official category</span>
			<?php } ?>
			</div>
			<?php
			$hasImage = false;
			$count = 0;
			while (next_image()):
				$count++;
				if ($count == 1) {
					?>
					<div id="padbox">
						<?php echo $adBoxTopLeft; ?>
						<div id="images">
							<div class="thumbnails topRow">
								<ul>
					<?php
					$hasImage = true;
				}
				?>
				<li class="image">
					<a href="<?php echo html_encode(getImageURL()); ?>" title="<?php echo html_encode(getBareImageTitle()); ?>">
					<?php printImageThumb(getAnnotatedImageTitle()); ?></a>
					<span class="imageResolutionContainer"><a href="<?php echo html_encode(getImageURL()); ?>" title="<?php echo html_encode(getBareImageTitle()); ?>"><?php echo html_encode(getFullWidth()); ?>x<?php echo html_encode(getFullHeight()); ?></a></span>
					<h3><a href="<?php echo html_encode(getImageURL()); ?>" title="<?php echo html_encode(getBareImageTitle()); ?>">
					<?php echo html_encode(getBareImageTitle()); ?></a></h3>
				</li>
				<?php
			endwhile;
			if ($hasImage) {
				echo '				</ul>
							</div><div style="clear:left;"></div>
						</div>' .
						printPageListWithNav("&laquo; " . gettext("prev"), gettext("next") . " &raquo;") .
						printTags("links", gettext("<strong>Tags:</strong>") . " ", "taglist", "").
						$adBoxBottom.'
					</div>
				';
			}

			$noImages = true;
			while (next_album()):
				if ($noImages == true) {
					?>
					<div class="subPadbox">
						<h2>Albums</h2>
						<div id="albums">
					<?php
				}
				?>
						<div class="album">
							<div class="thumb">
								<a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle(); ?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a><br>
								<h3><a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle(); ?>"><?php printAlbumTitle(); ?></a></h3>
							</div>
							<p style="clear: both; "></p>
						</div>
				<?php if ($noImages == true) { ?>
						</div><br style="clear:left;">
					</div>
						<?php
					}
					$noImages = false;
				endwhile;
				?>
			<?php
			if (function_exists('printRelatedItems')) {
				printRelatedItems(8, "albums", null, null, true);
			}
			?>
			<div class="halfWidth">
				<?php
				$albumDescription = getBareAlbumDesc();
				if (!empty($albumDescription)) {
					?>
					<div class="subPadbox">
						<h2>About</h2>
						<span><?php printAlbumDesc(true); ?></span>
					</div>
					<?php
				}
				?>
				<div class="subPadbox">
					<h2>
						<?php
						if ($isOfficialCategory) {
							echo 'Category';
						} else {
							echo 'User';
						} ?> Rating
					</h2>
					<?php
					if (function_exists('printRating')) {
						printRating();
					}
					if (function_exists('printAddToFavorites')) {
						echo '<div style="margin-top:10px;">';
						printAddToFavorites($_zp_current_album);
						echo '</div>';
					}
					?>
				</div>
			</div>
			<?php if (function_exists('printCommentForm')) { ?>
				<div class="halfWidth">
					<div class="right">
						<div class="subPadbox commentsContainer">
							<h2>Comments</h2>
							<div id="disqus_thread"></div>
							<script>
								(function() {
								var d = document, s = d.createElement('script');
								s.src = 'https://betadualmonitorbackgrounds.disqus.com/embed.js';
								s.setAttribute('data-timestamp', +new Date());
								(d.head || d.body).appendChild(s);
								})();
							</script>
							<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
						</div>
					</div>
				</div>
			<?php
			}
			?>
			<br style="clear:left;">
		</div>
		<?php
		getFooter(true, $isOfficialCategory ? 'The&nbsp;' . getBareAlbumTitle() . '&nbsp;category' : 'Profile&nbsp;of&nbsp;' . getBareAlbumTitle());
		zp_apply_filter('theme_body_close');
		include('includes/piwik.php');
		?>
	</body>
</html>
