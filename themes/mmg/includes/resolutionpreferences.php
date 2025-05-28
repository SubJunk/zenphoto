<div class="resolutionPreferencesContainer">
	<?php
	echo $resolutionPreferences;
	$strongClose = "";
	?>
	<span class="AfterImagesBreak"></span>
	<div id="ResolutionPreferencesOptions">
		<strong style="display:block;margin-bottom:5px;">Choose your preferred image resolution:</strong>
		<?php if ($disableImageResizing) { ?>
			<a href="?userwidth=all&amp;userheight=all"><?php if (empty($userResolution)) { echo '<strong>'; $strongClose = '</strong>'; } ?>Everything<?php echo $strongClose; $strongClose = ""; ?></a> Show all images<br>
		<?php } else { ?>
			<a href="?userwidth=all&amp;userheight=all"><?php if (empty($userResolution)) { echo '<strong>'; $strongClose = '</strong>'; } ?>Original<?php echo $strongClose; $strongClose = ""; ?></a> Show original sizes<br>
		<?php } ?>
		<a href="?userwidth=15360&amp;userheight=2160"><?php if ($userResolution == '15360x2160') { echo '<strong>'; $strongClose = '</strong>'; } ?>15360x2160<?php echo $strongClose; $strongClose = ""; ?></a> (3840x2160x4)<br>
		<a href="?userwidth=11520&amp;userheight=1800"><?php if ($userResolution == '11520x1800') { echo '<strong>'; $strongClose = '</strong>'; } ?>11520x1800<?php echo $strongClose; $strongClose = ""; ?></a> (2880x1800x4)<br>
		<a href="?userwidth=10240&amp;userheight=1440"><?php if ($userResolution == '10240x1440') { echo '<strong>'; $strongClose = '</strong>'; } ?>10240x1440<?php echo $strongClose; $strongClose = ""; ?></a> (2560x1440x4)<br>
		<a href="?userwidth=7680&amp;userheight=1200" ><?php if ($userResolution == '7680x1200' ) { echo '<strong>'; $strongClose = '</strong>'; } ?>7680x1200<?php  echo $strongClose; $strongClose = ""; ?></a> (1920x1200x4)<br>
		<a href="?userwidth=7680&amp;userheight=1080" ><?php if ($userResolution == '7680x1080' ) { echo '<strong>'; $strongClose = '</strong>'; } ?>7680x1080<?php  echo $strongClose; $strongClose = ""; ?></a> (1920x1080x4)<br>
		<a href="?userwidth=6720&amp;userheight=1050" ><?php if ($userResolution == '6720x1050' ) { echo '<strong>'; $strongClose = '</strong>'; } ?>6720x1050<?php  echo $strongClose; $strongClose = ""; ?></a> (1680x1050x4)<br>
		<a href="?userwidth=6400&amp;userheight=1200" ><?php if ($userResolution == '6400x1200' ) { echo '<strong>'; $strongClose = '</strong>'; } ?>6400x1200<?php  echo $strongClose; $strongClose = ""; ?></a> (1600x1200x4)<br>
		<a href="?userwidth=6400&amp;userheight=900"  ><?php if ($userResolution == '6400x900'  ) { echo '<strong>'; $strongClose = '</strong>'; } ?>6400x900<?php   echo $strongClose; $strongClose = ""; ?></a> (1600x900x4)<br>
		<a href="?userwidth=5760&amp;userheight=900"  ><?php if ($userResolution == '5760x900'  ) { echo '<strong>'; $strongClose = '</strong>'; } ?>5760x900<?php   echo $strongClose; $strongClose = ""; ?></a> (1440x900x4)<br>
		<a href="?userwidth=5464&amp;userheight=768"  ><?php if ($userResolution == '5464x768'  ) { echo '<strong>'; $strongClose = '</strong>'; } ?>5464x768<?php   echo $strongClose; $strongClose = ""; ?></a> (1366x768x4)<br>
		<a href="?userwidth=5120&amp;userheight=1024" ><?php if ($userResolution == '5120x1024' ) { echo '<strong>'; $strongClose = '</strong>'; } ?>5120x1024<?php  echo $strongClose; $strongClose = ""; ?></a> (1280x1024x4)<br>
		<a href="?userwidth=5120&amp;userheight=800"  ><?php if ($userResolution == '5120x800'  ) { echo '<strong>'; $strongClose = '</strong>'; } ?>5120x800<?php   echo $strongClose; $strongClose = ""; ?></a> (1280x800x4)<br>
		<a href="?userwidth=4096&amp;userheight=768"  ><?php if ($userResolution == '4096x768'  ) { echo '<strong>'; $strongClose = '</strong>'; } ?>4096x768<?php   echo $strongClose; $strongClose = ""; ?></a> (1024x768x4)<br>
		<strong style="display:block;margin:10px 0 5px 0;">Or enter a <?php if (isset($_COOKIE['DisableImageResizing'])) { ?>minimum <?php } ?>resolution: <span style="font-weight:normal;">(max: 15360x2160)</span></strong>
		<form method="get" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" id="ResolutionForm">
			<input type="text" name="userwidth" class="resolutionFormTextInput">x
			<input type="text" name="userheight" class="resolutionFormTextInput">
			<input type="submit" value="&nbsp;" id="ResolutionFormSubmitButton">
		</form>
		<strong style="display:block;margin-bottom:5px;">Other options:</strong>
		<?php
			if ($disableImageResizing) {
				echo '
					<input type="checkbox" name="imageresizing" value="yes" class="EnableImageResizing">
					<label class="EnableImageResizing">Image resizing</label>
					(<a
						href="javascript:void(0);"
						id="ExplainImageResizing"
						title="
							&lt;strong&gt;With resizing enabled&lt;/strong&gt;, you will see all images on the website and they will be automatically resized and cropped to your resolution.&lt;br&gt;&lt;br&gt;
							&lt;strong&gt;With resizing disabled&lt;/strong&gt;, you will only see the images that were made specifically for your resolution.&lt;br&gt;&lt;br&gt;
							Neither option will do anything unless you have selected your preferred image resolution.
						">What is this?</a>)<br>
				';
			} else {
				echo '
					<input type="checkbox" name="imageresizing" value="yes" class="DisableImageResizing" checked="checked">
					<label class="DisableImageResizing">Image resizing</label>
					(<a
						href="javascript:void(0);"
						id="ExplainImageResizing"
						title="
							&lt;strong&gt;With resizing enabled&lt;/strong&gt;, you will see all images on the website and they will be automatically resized and cropped to your resolution.&lt;br&gt;&lt;br&gt;
							&lt;strong&gt;With resizing disabled&lt;/strong&gt;, you will only see the images that were made specifically for your resolution.&lt;br&gt;&lt;br&gt;
							Neither option will do anything unless you have selected your preferred image resolution.
						">What is this?</a>)<br>
				';
			}
			if ($enableNSFW) {
				echo '
					<input type="checkbox" name="nsfw" value="yes" class="DisableNSFW" checked="checked">
					<label class="DisableNSFW">Show adult content</label>
					(<a
						href="javascript:void(0);"
						id="ExplainNSFW"
						title="
							&lt;strong&gt;With adult content enabled&lt;/strong&gt;, you will see adult images, including nudity.&lt;br&gt;&lt;br&gt;
							&lt;strong&gt;With adult content disabled&lt;/strong&gt;, you will only see images that are family and work-friendly.
						">What is this?</a>)<br><br>
				';
			} else {
				echo '
					<input type="checkbox" name="nsfw" value="yes" class="EnableNSFW">
					<label class="EnableNSFW">Show adult content</label>
					(<a
						href="javascript:void(0);"
						id="ExplainNSFW"
						title="
							&lt;strong&gt;With adult content enabled&lt;/strong&gt;, you will see adult images, including nudity.&lt;br&gt;&lt;br&gt;
							&lt;strong&gt;With adult content disabled&lt;/strong&gt;, you will only see images that are family and work-friendly.
						">What is this?</a>)<br><br>
				';
			}
		?>
		<a href="javascript:void(0);" id="CloseResolutionPreferencesOptions">Close</a>
	</div>
	<span class="AfterImagesBreak"></span>
</div>
