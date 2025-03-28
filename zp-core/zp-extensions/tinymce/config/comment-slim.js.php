<?php
/**
 * The configuration functions for TinyMCE 4.x.
 *
 * Zenphoto plugin default light configuration
 */
/**
 * Filter used by "file manager" plugins to attach themselves to tinyMCE.
 *
 * @package filters
 * @subpackage zenpage
 */
$filehandler = zp_apply_filter('tinymce_zenpage_config', NULL);
global $_zp_rtl_css;
?>
<script src="<?php echo WEBPATH . "/" . ZENFOLDER . "/" . PLUGIN_FOLDER; ?>/tinymce/tinymce.min.js"></script>
<script>
	tinymce.init({
		license_key: 'gpl',
		selector: "textarea.textarea_inputbox,textarea.texteditor_comments",
		promotion: false,
		language: "<?php echo $locale; ?>",
		entity_encoding: '<?php echo getOption('tinymce_entityencoding'); ?>',
		resize: true,
		<?php if(!empty(trim(strval(getOption('tinymce_entities'))))) { ?>
			entities: '<?php echo getOption('tinymce_entities'); ?>',
		<?php } ?>
		<?php if (getOption('tinymce_textfield-height')) { ?>
			min_height: <?php echo getOption('tinymce_textfield-height'); ?>,
		<?php } ?>
		<?php if (getOption('tinymce_browser-spellcheck')) { ?>
			browser_spellcheck: true,
		<?php } ?>
		<?php if (getOption('tinymce_browser-menu')) { ?>
			contextmenu: false,
		<?php } ?>
		directionality: "<?php echo $_zp_rtl_css ? 'rtl' : 'ltr'; ?>",
		relative_urls: false,
		image_advtab: true,
		content_css: "<?php echo FULLWEBPATH . '/' . ZENFOLDER . '/' . PLUGIN_FOLDER; ?>/tinymce/config/content.css",
		importcss_append: true,
		<?php if ($filehandler) { ?>
			file_picker_callback: <?php echo $filehandler; ?>,
		<?php } ?>
		toolbar_mode: 'sliding',
		plugins: 'advlist autolink lists link charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime wordcount codesample',
		menubar: false,
		toolbar: 'bold italic underline strikethrough | undo redo| blocks | align numlist bullist | outdent indent | link | code fullscreen preview | codesample | charmap emoticons',
		setup: function(ed) {
			ed.on('change', function(e) {
				$('.dirty-check').addClass('dirty');
			});
		}
	});
</script>