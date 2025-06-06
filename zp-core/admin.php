<?php
/**
 * admin.php is the main script for administrative functions.
 * @package zpcore\admin
 */
// force UTF-8 Ø

/* Don't put anything before this line! */
define('OFFSET_PATH', 1);

require_once(dirname(__FILE__) . '/admin-globals.php');
require_once(SERVERPATH . '/' . ZENFOLDER . '/functions/functions-reconfigure.php');

ignoreSetupRunRequest();

if (isset($_GET['_zp_login_error'])) {
	$_zp_login_error = sanitize($_GET['_zp_login_error']);
}

if (!isset($_GET['action']) || (isset($_GET['action']) && sanitize($_GET['action']) != 'ignore_setup')) {
	checkInstall();
}
if(!getOption('setup_unprotected_by_adminrequest')) {
	protectSetupFiles();
}
if (time() > getOption('last_garbage_collect') + 864000) {
	$_zp_gallery->garbageCollect();
}
if (isset($_GET['report'])) {
	$class = 'messagebox';
	$msg = sanitize($_GET['report']);
} else {
	$msg = '';
}
if (extensionEnabled('zenpage')) {
	require_once(dirname(__FILE__) . '/' . PLUGIN_FOLDER . '/zenpage/zenpage-admin-functions.php');
}
$redirected_from = NULL;
if (zp_loggedin() && !empty($_zp_admin_menu)) {
	if (!$_zp_current_admin_obj->getID() || empty($msg) && !zp_loggedin(OVERVIEW_RIGHTS)) {
		// admin access without overview rights, redirect to first tab
		$tab = array_shift($_zp_admin_menu);
		$link = $tab['link'];
		redirectURL($link);
	}
} else {
	if (isset($_GET['from'])) {
		$redirected_from = sanitizeRedirect($_GET['from']);
	} else {
		$redirected_from = urldecode(currentRelativeURL());
	}
}

if (zp_loggedin()) { /* Display the admin pages. Do action handling first. */
	if (isset($_GET['action'])) {
		$action = sanitize($_GET['action']);
		if ($action == 'external') {
			$needs = ALL_RIGHTS;
		} else {
			$needs = ADMIN_RIGHTS;
		}
		if (zp_loggedin($needs)) {
			switch ($action) {
				/** clear the image cache **************************************************** */
				/*				 * *************************************************************************** */
				case "clear_cache":
					XSRFdefender('clear_cache');
					Gallery::clearCache();
					$class = 'messagebox';
					$msg = gettext('Image cache cleared.');
					break;

				/** clear the RSScache ********************************************************** */
				/*				 * *************************************************************************** */
				case "clear_rss_cache":
					if (class_exists('RSS')) {
						XSRFdefender('clear_cache');
						$RSS = new RSS(array('rss' => 'null'));
						$RSS->clearCache();
						$class = 'messagebox';
						$msg = gettext('RSS cache cleared.');
					}
					break;

				/** clear the HTMLcache ****************************************************** */
				/*				 * *************************************************************************** */
				case 'clear_html_cache':
					XSRFdefender('ClearHTMLCache');
					require_once(SERVERPATH . '/' . ZENFOLDER . '/' . PLUGIN_FOLDER . '/static_html_cache.php');
					static_html_cache::clearHTMLCache();
					$class = 'messagebox';
					$msg = gettext('HTML cache cleared.');
					break;
					/** clear the search cache ****************************************************** */
				/*				 * *************************************************************************** */
				case 'clear_search_cache':
					XSRFdefender('ClearSearchCache');
					SearchEngine::clearSearchCache();
					$class = 'messagebox';
					$msg = gettext('Search cache cleared.');
					break;
				/** restore the setup files ************************************************** */
				/*				 * *************************************************************************** */
				case 'restore_setup':
					XSRFdefender('restore_setup');
					unprotectSetupFiles();
					zp_apply_filter('log_setup', true, 'protect', gettext('enabled'));
					setOption('setup_unprotected_by_adminrequest', 1, true, null);
					$class = 'messagebox';
					$msg = gettext('Setup files restored.');
					break;

				/** protect the setup files ************************************************** */
				/*				 * *************************************************************************** */
				case 'protect_setup':
					XSRFdefender('protect_setup');
					protectSetupFiles();
					setOption('setup_unprotected_by_adminrequest', 0, true, null);
					$class = 'messagebox';
					$msg = gettext('Setup files protected.');
					break;

				/** external script return *************************************************** */
				/*				 * *************************************************************************** */
				case 'external':
					if (isset($_GET['error'])) {
						$class = sanitize($_GET['error']);
						if (empty($class)) {
							$class = 'errorbox';
						}
					} else {
						$class = 'messagebox';
					}
					if (isset($_GET['msg'])) {
						$msg = sanitize($_GET['msg']);
					} else {
						$msg = '';
					}
					break;
			}
		} else {
			$class = 'errorbox';
			$actions = array(
					'clear_cache' => gettext('purge Image cache'),
					'clear_rss_cache' => gettext('purge RSS cache'),
					'reset_hitcounters' => gettext('reset all hitcounters'),
					'clear_search_cache' => gettext('purge search cache')
			);
			if (array_key_exists($action, $actions)) {
				$msg = $actions[$action];
			} else {
				$msg = '<em>' . html_encode($action) . '</em>';
			}
			$msg = sprintf(gettext('You do not have proper rights to %s.'), $msg);
		}
	} else {
		if (!is_null($redirected_from)) {
			$class = 'errorbox';
			$msg = sprintf(gettext('You do not have proper rights to access %s.'), html_encode(sanitize($redirected_from)));
		}
	}

	/*	 * ********************************************************************************* */
	/** End Action Handling ************************************************************ */
	/*	 * ********************************************************************************* */
}

// Print our header
printAdminHeader('overview');
?>
<script src="<?php echo WEBPATH . '/' . ZENFOLDER; ?>/js/jquery.masonry.min.js"></script>
<script>
	$(function() {
		$('#overviewboxes').masonry({
			// options
			itemSelector: '.overview-utility',
			columnWidth: 520
		});
	});
</script>
<?php
echo "\n</head>";
if (!zp_loggedin()) {
	// If they are not logged in, display the login form and exit
	?>
	<body style="background-image: none">
		<?php $_zp_authority->printLoginForm($redirected_from); ?>
	</body>
	<?php
	echo "\n</html>";
	exitZP();
}
?>
<body>
	<?php
	/* Admin-only content safe from here on. */
	printLogoAndLinks();
	?>
	<div id="main">
		<?php printTabs(); ?>
		<div id="content">
			<?php
			/*			 * * HOME ************************************************************************** */
			/*			 * ********************************************************************************* */
			if (!empty($msg)) {
				?>
				<div class="<?php echo html_encode($class); ?> fade-message">
					<h2><?php echo html_encode($msg); ?></h2>
				</div>
				<?php
			}
			update::printNotice();
			zp_apply_filter('admin_note', 'Overview', NULL);
			$buttonlist = array();

			$curdir = getcwd();
			chdir(SERVERPATH . "/" . ZENFOLDER . '/' . UTILITIES_FOLDER . '/');
			$filelist = safe_glob('*' . 'php');
			sortArray($filelist);
			foreach ($filelist as $utility) {
				$utilityStream = file_get_contents($utility);
				$s = strpos($utilityStream, '$buttonlist');
				if ($s !== false) {
					$e = strpos($utilityStream, ';', $s);
					if ($e) {
						$str = substr($utilityStream, $s, $e - $s) . ';';
						eval($str);
					}
				}
			}
			$buttonlist = zp_apply_filter('admin_utilities_buttons', $buttonlist);
			foreach ($buttonlist as $key => $button) {
				if (zp_loggedin($button['rights'])) {
					if (!array_key_exists('category', $button)) {
						$buttonlist[$key]['category'] = gettext('Misc');
					}
				} else {
					unset($buttonlist[$key]);
				}
			}
			if (hasPrimaryScripts() && zp_loggedin(ADMIN_RIGHTS)) {
				//	button to restore setup files if needed
				if (isSetupProtected()) {
					$buttonlist[] = array(
							'XSRFTag' => 'restore_setup',
							'category' => gettext('Admin'),
							'enable' => true,
							'button_text' => gettext('Setup » restore scripts'),
							'formname' => 'restore_setup',
							'action' => FULLWEBPATH . '/' . ZENFOLDER . '/admin.php?action=restore_setup',
							'icon' => FULLWEBPATH . '/' . ZENFOLDER . '/images/lock_open.png',
							'alt' => '',
							'title' => gettext('Restores setup files so setup can be run.'),
							'hidden' => '<input type="hidden" name="action" value="restore_setup" />',
							'rights' => ADMIN_RIGHTS
					);
					
				} else {
					$buttonlist[] = array(
							'XSRFTag' => 'protect_setup',
							'category' => gettext('Admin'),
							'enable' => true,
							'button_text' => gettext('Setup » protect scripts'),
							'formname' => 'restore_setup',
							'action' => FULLWEBPATH . '/' . ZENFOLDER . '/admin.php?action=protect_setup',
							'icon' => FULLWEBPATH . '/' . ZENFOLDER . '/images/lock_2.png',
							'alt' => '',
							'title' => gettext('Protects setup files so setup cannot be run.'),
							'hidden' => '<input type="hidden" name="action" value="protect_setup" />',
							'rights' => ADMIN_RIGHTS
					);
					
				}
			}
			if (zp_loggedin(ADMIN_RIGHTS)) {
				$buttonlist[] = array(
						'category' => gettext('Admin'),
						'enable' => true,
						'button_text' => gettext('Run setup'),
						'formname' => 'run_setup',
						'action' => FULLWEBPATH . '/' . ZENFOLDER . '/setup.php',
						'icon' => FULLWEBPATH . '/' . ZENFOLDER . '/images/Zp.png',
						'alt' => '',
						'title' => gettext('Run the setup script.'),
						'hidden' => '',
						'rights' => ADMIN_RIGHTS
				);
			}


			$buttonlist = sortMultiArray($buttonlist, array('category', 'button_text'), false);
															
			if (zp_loggedin(OVERVIEW_RIGHTS)) {
				if ((zp_loggedin(ADMIN_RIGHTS)) && !isSetupProtected()) {
					?>
					<div class="warningbox">
							<h2><?php echo gettext('Your Setup scripts are not protected.'); ?></h2>
							<?php echo gettext('The Setup environment is not totally secure, you should protect the scripts to thwart hackers. Use the <strong>Setup » protect scripts</strong> button in the <em>Admin</em> section of the <em>Utility functions</em>.'); ?>
						</div>
					<?php 
				} ?>
				<div id="overviewboxes">

					<?php
					if (zp_loggedin(ADMIN_RIGHTS)) {
						?>
						<div class="box overview-utility overview-install-info">
							<h2 class="h2_bordered"><?php echo gettext("Installation information"); ?></h2>
							<ul>
								<?php
								if (hasPrimaryScripts()) {
									$source = '';
								} else {
									$clone = clonedFrom();
									$official .= ' <em>' . gettext('clone') . '<em>';
									$base = substr(SERVERPATH, 0, -strlen(WEBPATH));
									if (strpos($base, $clone) == 0) {
										$base = substr($clone, strlen($base));
										$link = $base . '/' . ZENFOLDER . '/admin.php';
										$source = '<a href="' . $link . '">' . $clone . '</a>';
									} else {
										$source = $clone;
									}
									$source = '<br />&nbsp;&nbsp;&nbsp;' . sprintf(gettext('source: %s'), $source);
								}

								$graphics_lib = $_zp_graphics->graphicsLibInfo();
								?>
								<li>
									<?php
									printf(gettext('Zenphoto version <strong>%1$s</strong>'), ZENPHOTO_VERSION);
									echo $source;
									if (PRE_RELEASE) {
										?>
										<p class="warningbox">
											<a href="https://github.com/zenphoto/zenphoto/commits/master/" target="_blank" rel="noreferrer noopener">
												<?php echo gettext('This is a pre-release version. Review changes on GitHub.'); ?>
											</a>
										</p>
										<?php
									}
									?>
								</li>
								<li>
									<?php
									if (ZENPHOTO_LOCALE) {
										printf(gettext('Current locale setting: <strong>%1$s</strong>'), ZENPHOTO_LOCALE);
									} else {
										echo gettext('<strong>Locale setting has failed</strong>');
									}
									?>
								</li>
								<li>
									<?php echo gettext('Server path:') . ' <strong>' . SERVERPATH . '</strong>' ?>
								</li>
								<li>
									<?php echo gettext('WEB path:') . ' <strong>' . WEBPATH . '</strong>' ?>
								</li>
								<li>
									<?php echo gettext('PHP Session path:') . ' <strong>' . session_save_path() . '</strong>' ?>
								</li>
								<li>
									<?php
									$themes = $_zp_gallery->getThemes();
									$currenttheme = $_zp_gallery->getCurrentTheme();
									if (array_key_exists($currenttheme, $themes) && isset($themes[$currenttheme]['name'])) {
										$currenttheme = $themes[$currenttheme]['name'];
									}
									printf(gettext('Current gallery theme: <strong>%1$s</strong>'), $currenttheme);
									?>
								</li>
								<li><?php printf(gettext('Server software: <strong>%1$s</strong>'), html_encode($_SERVER['SERVER_SOFTWARE'])); ?></li>
								<li><?php printf(gettext('PHP version: <strong>%1$s</strong>'), phpversion()); ?></li>
								<?php
								$debugmodes_text = array(
												'DEBUG_LOGIN' => DEBUG_LOGIN,
												'DEBUG_ERROR' => DEBUG_ERROR,
												'DEBUG_IMAGE' => DEBUG_IMAGE,
												'DEBUG_IMAGE_ERR' => DEBUG_IMAGE_ERR,
												'DEBUG_404' => DEBUG_404 ,
												'DEBUG_EXIF' => DEBUG_EXIF ,
												'DEBUG_PLUGINS' => DEBUG_PLUGINS,
												'DEBUG_FILTER' => DEBUG_FILTERS,
												'EXPLAIN_SELECTS' => EXPLAIN_SELECTS,
												'DEBUG_LOCALE' => DEBUG_LOCALE,
										);
								$debugmodes_active = array();
								foreach (	$debugmodes_text as $debugmodename => $debugmode_on) {
									if ($debugmode_on) {
										$debugmodes_active[] = $debugmodename;
									}
								}
								if ($debugmodes_active) {
									?>
									<li>
										<p class="notebox">
										<?php 
										$debugmodes_enabled = implode(', ', $debugmodes_active);
										if (TEST_RELEASE) {
											printf(gettext('TEST_RELEASE mode (%s) enabled'), $debugmodes_enabled);
										} else {
											printf(gettext('Debug modes enabled: <strong>%s</strong>'), $debugmodes_enabled); 
										}
										?>
										</p>
									</li>
									<?php
								}
								if (TEST_RELEASE) {
									?>
									<li>
										<?php
										$erToTxt = array(
														E_ERROR						 => 'E_ERROR',
														E_WARNING					 => 'E_WARNING',
														E_PARSE						 => 'E_PARSE',
														E_NOTICE					 => 'E_NOTICE',
														E_CORE_ERROR			 => 'E_CORE_ERROR',
														E_CORE_WARNING		 => 'E_CORE_WARNING',
														E_COMPILE_ERROR		 => 'E_COMPILE_ERROR',
														E_COMPILE_WARNING	 => 'E_COMPILE_WARNING',
														E_USER_ERROR			 => 'E_USER_ERROR',
														E_USER_NOTICE			 => 'E_USER_NOTICE',
														E_USER_WARNING		 => 'E_USER_WARNING',
														E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
														E_DEPRECATED => 'E_DEPRECATED',
														E_USER_DEPRECATED => 'E_USER_DEPRECATED'				 
										);
										if (version_compare(PHP_VERSION, '8.4.0', '<')) {
											$erToText[E_STRICT] =  'E_STRICT'; // equals E_NOTICE level since PHP 8 and deprecated in PHP 8.4+
										}
										$reporting = error_reporting();
										$text = array();
										if (($reporting & E_ALL) == E_ALL) {
											$text[] = 'E_ALL';
										}
										if ((($reporting | E_NOTICE) & E_ALL) == E_ALL) {
											$t = 'E_ALL';
											if ($reporting & E_NOTICE) {
												$t .= ' ^ E_NOTICE';
												$reporting = $reporting ^ E_NOTICE;
											}
											$text[] = $t;
										}
										foreach ($erToTxt as $er => $name) {
											if ($reporting & $er) {
												$text[] = $name;
											}
										}
										printf(gettext('PHP Error reporting: <strong>%s</strong>'), implode(' | ', $text));
										?>
									</li>
									<?php
									if (@ini_get('display_errors')) {
										?>
										<li><p class="warningbox"><?php echo gettext('<em>display_errors</em> is <strong>On</strong>: PHP error messages may be displayed on WEB pages. This may disclose site sensitive information.'); ?></p></li>
										<?php
									} else {
										?>
										<li><?php echo gettext('<em>display_errors</em> is <strong>Off</strong>') ?></li>
										<?php
									}
								}
								?>
								<li>
									<?php printf(gettext("Graphics support: <strong>%s</strong>"), $graphics_lib['Library_desc']); ?>
									<br />&nbsp;&nbsp;&nbsp;
									<?php
									unset($graphics_lib['Library']);
									unset($graphics_lib['Library_desc']);
									foreach ($graphics_lib as $key => $type) {
										if (!$type) {
											unset($graphics_lib[$key]);
										}
									}
									printf(gettext('supporting: %s'), '<em>' . strtolower(implode(', ', array_keys($graphics_lib))) . '</em>');
									?>
								</li>
								<li><?php printf(gettext('PHP memory limit: <strong>%1$s</strong> (Note: Your server might allocate less!)'), INI_GET('memory_limit')); ?></li>
								<li><?php printf(gettext('Database: <strong>%1$s %2$s</strong>'), $_zp_db->getType(), $_zp_db->getVersion()); ?></li>
								<li><?php printf(gettext('Database handler: <strong>%1$s</strong>'), DATABASE_SOFTWARE); ?></li>
								<li><?php printf(gettext('Database client: <strong>%1$s</strong>'), $_zp_db->getClientInfo()); ?></li>									
								<li><?php printf(gettext('Database name: <strong>%1$s</strong>'), $_zp_db->getDBName()); ?></li>
								<li><?php echo sprintf(gettext('Database table prefix: <strong>%1$s</strong>'), $_zp_db->getPrefix()); ?></li>
								<li>
									<?php
									if (isset($_zp_spamFilter)) {
										$filter = $_zp_spamFilter->displayName();
									} else {
										$filter = gettext('No spam filter configured');
									}
									printf(gettext('Spam filter: <strong>%s</strong>'), $filter)
									?>
								</li>
								<?php
								if ($_zp_captcha) {
									?>
									<li><?php printf(gettext('CAPTCHA generator: <strong>%s</strong>'), $_zp_captcha->name) ?></li>
									<?php
								}
								zp_apply_filter('installation_information');
								if (!zp_has_filter('sendmail')) {
									?>
									<li style="color:RED"><?php echo gettext('There is no mail handler configured!'); ?></li>
									<?php
								}
								?>
							</ul>

							<?php
							require_once(SERVERPATH . '/' . ZENFOLDER . '/template-filters.php');
							$plugins = array_keys(getEnabledPlugins());
							$filters = $_zp_filters;
							$c = count($plugins);
							?>
							<h3><a href="javascript:toggle('plugins_hide');toggle('plugins_show');" ><?php printf(ngettext("%u active plugin:", "%u active plugins:", $c), $c); ?></a></h3>
							<div id="plugins_hide" style="display:none">
								<ul class="plugins">
									<?php
									if ($c > 0) {
										sortArray($plugins);
										foreach ($plugins as $extension) {
											$pluginStream = file_get_contents(getPlugin($extension . '.php'));
											$plugin_version = '';
											if ($str = isolate('$plugin_version', $pluginStream)) {
												@eval($str);
											}
											if ($plugin_version) {
												$version = ' v' . $plugin_version;
											} else {
												$version = '';
											}
											$plugin_is_filter = 1;
											if ($str = isolate('$plugin_is_filter', $pluginStream)) {
												@eval($str);
											}
											echo "<li>" . $extension . $version . "</li>";
											preg_match_all('|zp_register_filter\s*\((.+?)\)\s*?;|', $pluginStream, $matches);
											foreach ($matches[1] as $paramsstr) {
												$params = explode(',', $paramsstr);
												if (array_key_exists(2, $params)) {
													$priority = (int) $params[2];
												} else {
													$priority = $plugin_is_filter & PLUGIN_PRIORITY;
												}
												$filter = unQuote(trim($params[0]));
												$function = unQuote(trim($params[1]));
												$filters[$filter][$priority][$function] = array('function' => $function, 'script' => $extension . '.php');
											}
										}
									} else {
										echo '<li>' . gettext('<em>none</em>') . '</li>';
									}
									?>
								</ul>
							</div><!-- plugins_hide -->
							<div id="plugins_show">
								<br />
							</div><!-- plugins_show -->
							<?php
							$c = count($filters);
							?>
							<h3><a href="javascript:toggle('filters_hide');toggle('filters_show');" ><?php printf(ngettext("%u active filter:", "%u active filters:", $c), $c); ?></a></h3>
							<div id="filters_hide" style="display:none">
								<ul class="plugins">
									<?php
									if ($c > 0) {
										ksort($filters, SORT_LOCALE_STRING);
										foreach ($filters as $filter => $array_of_priority) {
											krsort($array_of_priority);
											?>
											<li>
												<em><?php echo $filter; ?></em>
												<ul class="filters">
													<?php
													foreach ($array_of_priority as $priority => $array_of_filters) {
														foreach ($array_of_filters as $data) {
															?>
															<li><em><?php echo $priority; ?></em>: <?php echo $data['script'] ?> =&gt; <?php echo $data['function'] ?></li>
															<?php
														}
													}
													?>
												</ul>
											</li>
											<?php
										}
									} else {
										?>
										<li><?php echo gettext('<em>none</em>'); ?></li>
										<?php
									}
									?>
								</ul>
							</div><!-- filters_hide -->
							<div id="filters_show">
								<br />
							</div><!-- filters_show -->

						</div><!-- overview-info -->
						<?php
					}
					?>
					<div class="box overview-utility">
						<h2 class="h2_bordered"><?php echo gettext("Utility functions"); ?></h2>
						<?php
						$category = '';
						foreach ($buttonlist as $button) {
							$button_category = $button['category'];
							$button_icon = $button['icon'];
							if ($category != $button_category) {
								if ($category) {
									?>
									</fieldset>
									<?php
								}
								$category = $button_category;
								?>
								<fieldset class="utility_buttons_field"><legend><?php echo $category; ?></legend>
									<?php
								}
								?>
								<form name="<?php echo $button['formname']; ?>"	action="<?php echo $button['action']; ?>" class="overview_utility_buttons">
									<?php if (isset($button['XSRFTag']) && $button['XSRFTag']) XSRFToken($button['XSRFTag']); ?>
									<?php echo $button['hidden']; ?>
									<div class="buttons tooltip" title="<?php echo html_encode($button['title']); ?>">
										<button class="fixedwidth <?php echo $button['formname']; ?>" type="submit"<?php if (!$button['enable']) echo 'disabled="disabled"'; ?>>
											<?php
											if (!empty($button_icon)) {
												?>
												<img src="<?php echo $button_icon; ?>" alt="<?php echo html_encode($button['alt']); ?>" />
												<?php
											}
											echo html_encode($button['button_text']);
											?>
										</button>
									</div><!--buttons -->
									<?php if (isset($button['confirmclick']) && !empty($button['confirmclick'])) { ?>
										<script>
											$( document ).ready(function() {
												var element = 'button.<?php echo $button['formname']; ?>';
												var message = '<?php echo js_encode($button['confirmclick']); ?>';
												confirmClick(element, message );
											});
										</script>
									<?php } ?>
								</form>
								<?php
							}
							if ($category) {
								?>
							</fieldset>
							<?php
						}
						?>
					</div><!-- overview-utility -->

					<div class="box overview-utility overiew-gallery-stats">
						<h2 class="h2_bordered"><?php echo gettext("Gallery Stats"); ?></h2>
						<ul>
							<li>
								<?php
								$t = $_zp_gallery->getNumImages();
								$c = $t - $_zp_gallery->getNumImages(true);
								if ($c > 0) {
									printf(ngettext('<strong>%1$u</strong> Image (%2$u un-published)', '<strong>%1$u</strong> Images (<strong>%2$u</strong> un-published)', $t), $t, $c);
								} else {
									printf(ngettext('<strong>%u</strong> Image', '<strong>%u</strong> Images', $t), $t);
								}
								?>
							</li>
							<li>
								<?php
								$t = $_zp_gallery->getNumAlbums(true);
								$c = $t - $_zp_gallery->getNumAlbums(true, true);
								if ($c > 0) {
									printf(ngettext('<strong>%1$u</strong> Album (%2$u un-published)', '<strong>%1$u</strong> Albums (<strong>%2$u</strong> un-published)', $t), $t, $c);
								} else {
									printf(ngettext('<strong>%u</strong> Album', '<strong>%u</strong> Albums', $t), $t);
								}
								?>
							</li>
							<?php if(extensionEnabled('comment_form')) { ?>
								<li>
									<?php
									$t = $_zp_gallery->getNumComments(true);
									$c = $t - $_zp_gallery->getNumComments(false);
									if ($c > 0) {
										printf(ngettext('<strong>%1$u</strong> Comment (%2$u in moderation)', '<strong>%1$u</strong> Comments (<strong>%2$u</strong> in moderation)', $t), $t, $c);
									} else {
										printf(ngettext('<strong>%u</strong> Comment', '<strong>%u</strong> Comments', $t), $t);
									}
									?>
								</li>
							<?php
							}
							if (extensionEnabled('zenpage')) {
								?>
								<li>
									<?php printPagesStatistic(); ?>
								</li>
								<li>
									<?php printNewsStatistic(); ?>
								</li>
								<li>
									<?php printCategoriesStatistic(); ?>
								</li>
								<?php
							}
							?>
						</ul>
					</div><!-- overview-gallerystats -->

					<?php
					zp_apply_filter('admin_overview');
					?>

				</div><!-- boxouter -->
			</div><!-- content -->
			<br class="clearall" />
			<?php
		} else {
			?>
			<div class="errorbox">
				<?php echo gettext('Your user rights do not allow access to administrative functions.'); ?>
			</div>
			<?php
		}
		printAdminFooter();
		/* No admin-only content allowed after point! */
		?>
	</div>
	<!-- main -->
</body>
<?php
// to fool the validator
echo "\n</html>";
?>
