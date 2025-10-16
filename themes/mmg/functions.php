<?php
zp_register_filter('themeSwitcher_head', 'switcher_head');
zp_register_filter('themeSwitcher_Controllink', 'switcher_controllink');
zp_register_filter('theme_head', 'css_head', 0);
enableExtension('zenpage', 0, false); //	we do not support it

$curdir = getcwd();
chdir(SERVERPATH . "/themes/" . basename(dirname(__FILE__)) . "/styles");
$filelist = safe_glob('*.css');
$themecolors = array();
foreach ($filelist as $file) {
	$themecolors[] = stripSuffix(filesystemToInternal($file));
}
chdir($curdir);

function css_head($ignore) {
	global $themecolors, $zenCSS, $themeColor, $_zp_themeroot;
	if (!$themeColor) {
		$themeColor = getThemeOption('Theme_colors');
	}
	$zenCSS = $_zp_themeroot . '/styles/' . $themeColor . '.css';
	$unzenCSS = str_replace(WEBPATH, '', $zenCSS);
	if (!file_exists(SERVERPATH . internalToFilesystem($unzenCSS))) {
		$zenCSS = $_zp_themeroot . "/styles/light.css";
	}
	return $ignore;
}

function switcher_head($ignore) {
	global $personalities, $themecolors, $themeColor;
	$themeColor = getOption('themeSwitcher_default_color');
	if (isset($_GET['themeColor'])) {
		$new = $_GET['themeColor'];
		if (in_array($new, $themecolors)) {
			setOption('themeSwitcher_default_color', $new);
			$themeColor = $new;
		}
	}
	?>
	<script type="text/javascript">
		// <!-- <![CDATA[
		window.onload = function() {
			$('#themeSwitcher_zenpage').html('');
		}
		function switchColors() {
			personality = $('#themeColor').val();
			window.location = '?themeColor=' + personality;
		}
		// ]]> -->
	</script>
	<?php
	return $ignore;
}

function switcher_controllink($ignore) {
	global $themecolors;
	$color = getOption('themeSwitcher_default_color');
	if (!$color) {
		$color = getOption('Theme_colors');
	}
	?>
	<span title="<?php echo gettext("Default theme color scheme."); ?>">
		<?php echo gettext('Theme Color'); ?>
		<select name="themeColor" id="themeColor" onchange="switchColors();">
			<?php generateListFromArray(array($color), $themecolors, false, false); ?>
		</select>
	</span>
	<?php
	return $ignore;
}

function my_checkPageValidity($request, $gallery_page, $page) {
	switch ($gallery_page) {
		case 'gallery.php':
			$gallery_page = 'index.php'; //	same as an album gallery index
			break;
		case 'index.php':
			if (extensionEnabled('zenpage')) {
				if (getOption('zenpage_zp_index_news')) {
					$gallery_page = 'news.php'; //	really a news page
					break;
				}
				if (getOption('zenpage_homepage')) {
					return $page == 1; // only one page if zenpage enabled.
				}
			}
			break;
		case 'news.php':
		case 'album.php':
		case 'search.php':
		case 'favorites.php':
			break;
		case 'users.php':
      return $page;
		default:
			if ($page != 1) {
				return false;
			}
	}
	return checkPageValidity($request, $gallery_page, $page);
}

if (!OFFSET_PATH) { 
	$_zp_page_check = 'my_checkPageValidity';
}
?>