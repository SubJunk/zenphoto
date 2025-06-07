<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die();
$sortBy      = "";
$sortByUsers = "";
if (isset($_GET['sortby'])) {
	$sortBy = $_GET['sortby'];
}
if (isset($_GET['sortbyusers'])) {
	$sortByUsers = $_GET['sortbyusers'];
}

if (!empty($sortBy)) {
	if ($sortBy == "date" || $sortBy == "popularity" || $sortBy == "rating") {
		$inTwoMonths = 60 * 60 * 24 * 60 + time();
		setcookie('sortby', $sortBy, $inTwoMonths);
	}
} else if (!empty($_COOKIE['sortby'])) {
	if ($_COOKIE['sortby'] == "date" || $_COOKIE['sortby'] == "popularity" || $_COOKIE['sortby'] == "rating") {
		$sortBy = $_COOKIE['sortby'];
	}
}

if (!empty($sortByUsers)) {
	if ($sortByUsers == "date" || $sortByUsers == "popularity" || $sortByUsers == "rating") {
		$inTwoMonths = 60 * 60 * 24 * 60 + time();
		setcookie('sortbyusers', $sortByUsers, $inTwoMonths);
	}
} else if (!empty($_COOKIE['sortbyusers'])) {
	if ($_COOKIE['sortbyusers'] == "date" || $_COOKIE['sortbyusers'] == "popularity" || $_COOKIE['sortbyusers'] == "rating") {
		$sortByUsers = $_COOKIE['sortbyusers'];
	}
}

include('includes/cookiehandler.php');
include('includes/footer.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<?php zp_apply_filter('theme_head'); ?>
		<title><?php printGalleryTitle(); ?></title>
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
				<?php
					include('includes/resolutionpreferences.php');
					$siteVariantLower = "dual";
					$siteVariantCapital = "Dual";
					$siteNumber = "two";
					if (str_contains($_SERVER['SERVER_NAME'], 'triple')) {
						$siteVariantCapital = "Triple";
						$siteVariantLower = "triple";
						$siteNumber = "three";
					} else if (str_contains($_SERVER['SERVER_NAME'], 'quad')) {
						$siteVariantCapital = "Quad";
						$siteVariantLower = "quad";
						$siteNumber = "four";
					}
				?>
				Welcome to the largest dedicated <?php echo $siteVariantLower ?> monitor backgrounds website on the internet.<br>
				<?php echo $siteVariantCapital ?> monitor backgrounds (AKA <?php echo $siteVariantLower ?> screen wallpapers) are backgrounds that span <?php echo $siteNumber ?> screens.  <?php if (!$welcomeTextDisplay) { ?><span id="ExpandWelcomeTextContainer">(<a href="javascript:void(0);" class="ExpandWelcomeText">Expand</a>)</span><?php } ?>
				<span id="WelcomeTextLower"<?php if ($welcomeTextDisplay) { ?> style="display:inline;"<?php } ?>>
					<br>If you are here it is assumed you have <?php echo $siteNumber ?> monitors. All our <?php echo $siteVariantLower ?> monitor wallpapers are free and many more are added all the time, usually every day.<br>
					New features are always being developed and if you have any <?php echo $siteVariantLower ?> monitor backgrounds you would like to see added to the site just register and upload them.<br>
					So please get involved with the site by rating wallpapers and support the artists (many of whom frequent this site) by commenting on the images. Critique is also encouraged.<br>
					To get started, just click on a category at the bottom of this page or use the search box up top and enjoy our amazing range of <?php echo $siteVariantLower ?> monitor backgrounds! (<a href="javascript:void(0);" class="ShrinkWelcomeText">Collapse</a>)
				</span>
			</div>
			<div id="padbox" class="noAdBottom">
				<?php
					$thumbnailsPerPage = 15;
					$latestPage = 0;
					$previousPage = 1;
					$nextPage = 2;
					$latestPageMultiplier = 0;
					$thumbnailWidth = 608;
					$thumbnailHeight = 109;
					if (isset($_GET['latestImagesPage']) && is_numeric($_GET['latestImagesPage']) && $_GET['latestImagesPage'] > 1) {
						$latestPage = $_GET['latestImagesPage'];
						$latestPageMultiplier = $latestPage - 1;
						$nextPage = $latestPageMultiplier + 2;
						if ($nextPage > 3) {
							$previousPage = $nextPage - 2;
						}
					}
					$offset = $latestPageMultiplier * $thumbnailsPerPage;

					require_once(dirname(dirname(__FILE__)).'/../zp-core/'.PLUGIN_FOLDER.'/image_album_statistics.php');
					if (empty($sortBy) || $sortBy == "date") {
						echo '<h2>Latest Images</h2><div id="albums">';
						echo '<span class="sortBy">Sort by: <a href="?sortby=date" class="selected">Date</a> <a href="?sortby=rating">Rating</a> <a href="?sortby=popularity">Popularity</a> <a href="/page/random/">Random</a></span><br style="clear:left;">';
						echo '<div class="thumbnails topRow">';
						printImageStatistic(
							$thumbnailsPerPage,
							'latest',
							'',
							true,
							false,
							false,
							40,
							'',
							$thumbnailWidth,
							$thumbnailHeight,
							true,
							false,
							false,
							0,
							'desc',
							$offset
						);
					} else if ($sortBy == "popularity") {
						echo '<h2>Most Popular Images</h2><div id="albums">';
						echo '<span class="sortBy">Sort by: <a href="?sortby=date">Date</a> <a href="?sortby=rating">Rating</a> <a href="?sortby=popularity" class="selected">Popularity</a> <a href="/page/random/">Random</a></span><br style="clear:left;">';
						echo '<div class="thumbnails topRow">';
						printImageStatistic(
							$thumbnailsPerPage,
							'popular',
							'',
							true,
							false,
							false,
							40,
							'',
							$thumbnailWidth,
							$thumbnailHeight,
							true,
							false,
							false,
							0,
							'desc',
							$offset
						);
					} else if ($sortBy == "rating") {
						echo '<h2>Top Rated Images</h2><div id="albums">';
						echo '<span class="sortBy">Sort by: <a href="?sortby=date">Date</a> <a href="?sortby=rating" class="selected">Rating</a> <a href="?sortby=popularity">Popularity</a> <a href="/page/random/">Random</a></span><br style="clear:left;">';
						echo '<div class="thumbnails topRow">';
						printImageStatistic(
							$thumbnailsPerPage,
							'toprated',
							'',
							true,
							false,
							false,
							40,
							'',
							$thumbnailWidth,
							$thumbnailHeight,
							true,
							false,
							false,
							0,
							'desc',
							$offset
						);
					}
					echo '</div></div>';
				?>
				<span class="AfterImagesBreak"></span>
				<div class="pagelist">
					<ul class="pagelist">
						<?php if ($nextPage == 2) { ?>
							<li class="prev">
								« prev
							</li>
						<?php } else { ?>
							<li class="prev">
								<a href="/?latestImagesPage=<?php echo $previousPage; ?>">« prev</a>
							</li>
						<?php } ?>
						<li class="next">
							<a href="/?latestImagesPage=<?php echo $nextPage; ?>">next »</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="subPadbox noAd">
				<div id="albumsUsers">
					<?php
						if (empty($sortByUsers) || $sortByUsers == "date") {
							echo '<h2>Latest Users<a href="/page/archive/" title="Click here to see all users" id="UserListLink">(All Users)</a></h2><div id="albumsusersinner">';
							echo '<div class="thumbnails">';
							printAlbumStatistic(
								15,
								'latest',
								true,
								false,
								false,
								40,
								'',
								$thumbnailWidth,
								$thumbnailHeight,
								true,
								'',
								false
							);
							echo '</div>';
							echo '</div>';
						} else if ($sortByUsers == "popularity") {
							echo '<h2>Most Popular Users<a href="/page/archive/" title="Click here to see all users" id="UserListLink">(All Users)</a></h2><div id="albumsusersinner">';
							echo '<div class="thumbnails">';
							printAlbumStatistic(
								15,
								'popular',
								true,
								false,
								false,
								40,
								'',
								$thumbnailWidth,
								$thumbnailHeight,
								true,
								'',
								false
							);
							echo '</div>';
							echo '</div>';
						} else if ($sortByUsers == "rating") {
							echo '<h2>Top Rated Users<a href="/page/archive/" title="Click here to see all users" id="UserListLink">(All Users)</a></h2><div id="albumsusersinner">';
							echo '<div class="thumbnails">';
							printAlbumStatistic(
								15,
								'toprated',
								true,
								false,
								false,
								40,
								'',
								$thumbnailWidth,
								$thumbnailHeight,
								true,
								'',
								false,
								1);
							echo '</div>';
							echo '</div>';
						}
					?>
				</div>
				<span class="AfterImagesBreak"></span>
			</div>
			<?php $imageAppend = "_".$thumbnailWidth."_cw".$thumbnailWidth."_ch".$thumbnailHeight."_thumb.jpg"; ?>
			<div class="subPadbox noAd">
				<div id="OfficialCategories">
					<h2>Categories</h2>
					<div class="thumbnails">
						<ul>
							<li>
								<a href="/abstract/" title="Abstract">
								<img src="/cache/abstract/powerwall<?php echo $imageAppend; ?>" alt="Abstract"></a>
								<h3><a href="/abstract/" title="Abstract">
								Abstract</a></h3>
							</li>
							<li>
								<a href="/animals/" title="Animals">
								<img src="/cache/animals/eatingthornbushes<?php echo $imageAppend; ?>" alt="Animals"></a>
								<h3><a href="/animals/" title="Animals">
								Animals</a></h3>
							</li>
							<li>
								<a href="/astronomy/" title="Astronomy">
								<img src="/cache/astronomy/supernova<?php echo $imageAppend; ?>" alt="Astronomy"></a>
								<h3><a href="/astronomy/" title="Astronomy">
								Astronomy</a></h3>
							</li>
							<li>
								<a href="/celebrities/" title="Celebrities">
								<img src="/cache/celebrities/januaryjones-3<?php echo $imageAppend; ?>" alt="Celebrities"></a>
								<h3><a href="/celebrities/" title="Celebrities">
								Celebrities</a></h3>
							</li>
							<li>
								<a href="/crafted-nature/" title="Crafted Nature">
								<img src="/cache/crafted-nature/wellingtonharbour<?php echo $imageAppend; ?>" alt="Crafted Nature"></a>
								<h3><a href="/crafted-nature/" title="Crafted Nature">
								Crafted Nature</a></h3>
							</li>
							<li>
								<a href="/gaming/" title="Gaming">
								<img src="/cache/gaming/godofwar<?php echo $imageAppend; ?>" alt="Gaming"></a>
								<h3><a href="/gaming/" title="Gaming">
								Gaming</a></h3>
							</li>
							<li>
								<a href="/industrial/" title="Industrial">
								<img src="/cache/industrial/romantheatreinbosra<?php echo $imageAppend; ?>" alt="Industrial"></a>
								<h3><a href="/industrial/" title="Industrial">
								Industrial</a></h3>
							</li>
							<li>
								<a href="/nature/" title="Nature">
								<img src="/cache/nature/mountpilatus<?php echo $imageAppend; ?>" alt="Nature"></a>
								<h3><a href="/nature/" title="Nature">
								Nature</a></h3>
							</li>
							<li>
								<a href="/popular-culture/" title="Popular Culture">
								<img src="/cache/popular-culture/avengers<?php echo $imageAppend; ?>" alt="Popular Culture"></a>
								<h3><a href="/popular-culture/" title="Popular Culture">
								Popular Culture</a></h3>
							</li>
							<li>
								<a href="/science-fiction/" title="Science Fiction / Fantasy">
								<img src="/cache/science-fiction/darkfuturebattle<?php echo $imageAppend; ?>" alt="Science Fiction / Fantasy"></a>
								<h3><a href="/science-fiction/" title="Science Fiction / Fantasy">
								Science Fiction / Fantasy</a></h3>
							</li>
						</ul>
					</div>
				</div>
				<span class="AfterImagesBreak"></span>
			</div>
		</div>
		<?php
		getFooter(false, 'Homepage');
		zp_apply_filter('theme_body_close');
		?>
	</body>
</html>
