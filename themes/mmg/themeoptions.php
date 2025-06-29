<?php

// force UTF-8 Ø

/* Plug-in for theme option handling
 * The Admin Options page tests for the presence of this file in a theme folder
 * If it is present it is linked to with a require_once call.
 * If it is not present, no theme options are displayed.
 *
 */

require_once(dirname(__FILE__) . '/functions.php');

class ThemeOptions {

	function __construct() {
		$me = basename(dirname(__FILE__));
		setThemeOptionDefault('Allow_search', true);
		setThemeOptionDefault('Theme_colors', 'light');
		setThemeOptionDefault('albums_per_row', 6);
		setThemeOptionDefault('image_use_side', 'width');
		setThemeOptionDefault('thumb_crop_width', 0);
		setThemeOptionDefault('thumb_crop', 1);
		setThemeOptionDefault('thumb_transition', 1);

		if (str_contains($_SERVER['SERVER_NAME'], 'dual')) {
			setThemeOptionDefault('albums_per_page', 30);
			setThemeOptionDefault('images_per_page', 24);
			setThemeOptionDefault('images_per_row', 6);
			setThemeOptionDefault('image_size', 7680);
			setThemeOptionDefault('thumb_size', 240);
			setThemeOptionDefault('thumb_crop_height', 32.9);
		} else if (str_contains($_SERVER['SERVER_NAME'], 'triple')) {
			setThemeOptionDefault('albums_per_page', 20);
			setThemeOptionDefault('images_per_page', 16);
			setThemeOptionDefault('images_per_row', 4);
			setThemeOptionDefault('image_size', 11520);
			setThemeOptionDefault('thumb_size', 371);
			setThemeOptionDefault('thumb_crop_height', 38.4);
		} else if (str_contains($_SERVER['SERVER_NAME'], 'quad')) {
			setThemeOptionDefault('albums_per_page', 20);
			setThemeOptionDefault('images_per_page', 15);
			setThemeOptionDefault('images_per_row', 4);
			setThemeOptionDefault('image_size', 15360);
			setThemeOptionDefault('thumb_size', 501);
			setThemeOptionDefault('thumb_crop_height', 41.2);
		}

		setOptionDefault('colorbox_' . $me . '_album', 1);
		setOptionDefault('colorbox_' . $me . '_image', 1);
		setOptionDefault('colorbox_' . $me . '_search', 1);
		if (class_exists('cacheManager')) {
			cacheManager::deleteCacheSizes($me);
			cacheManager::addDefaultThumbSize();
			cacheManager::addDefaultSizedImageSize();
		}
	}

	function getOptionsSupported() {
		return array(gettext('Allow search') => array(
						'key' => 'Allow_search',
						'type' => OPTION_TYPE_CHECKBOX,
						'desc' => gettext('Check to enable search form.')),
				gettext('Theme colors') => array(
						'key' => 'Theme_colors',
						'type' => OPTION_TYPE_CUSTOM,
						'desc' => gettext('Select the colors of the theme'))
		);
	}

  function getOptionsDisabled() {
  	return array('custom_index_page');
  }

	function handleOption($option, $currentValue) {
		global $themecolors;
		if ($option == 'Theme_colors') {
			echo '<select id="EF_themeselect_colors" name="' . $option . '"' . ">\n";
			generateListFromArray(array($currentValue), $themecolors, false, false);
			echo "</select>\n";
		}
	}

}

?>
