<div class="resolutionPreferencesContainer">
	<?php
	echo $resolutionPreferences;
	$strongClose = "";
	$multiplier = 2;
	if (str_contains($_SERVER['SERVER_NAME'], 'triple')) {
		$multiplier = 3;
	} else if (str_contains($_SERVER['SERVER_NAME'], 'quad')) {
		$multiplier = 4;
	}
	?>
	<span class="AfterImagesBreak"></span>
	<div id="ResolutionPreferencesOptions">
		<strong style="display:block;margin-bottom:5px;">Choose your preferred image resolution:</strong>
		<?php if ($disableImageResizing) { ?>
			<a href="?userwidth=all&amp;userheight=all"><?php if (empty($userResolution)) { echo '<strong>'; $strongClose = '</strong>'; } ?>Everything<?php echo $strongClose; $strongClose = ""; ?></a> Show all images<br>
		<?php } else { ?>
			<a href="?userwidth=all&amp;userheight=all"><?php if (empty($userResolution)) { echo '<strong>'; $strongClose = '</strong>'; } ?>Original<?php echo $strongClose; $strongClose = ""; ?></a> Show original sizes<br>
		<?php
		}

		$resolutions = array(
			(object) [
				'width' => 3840,
				'height' => 2160
			],
			(object) [
				'width' => 2880,
				'height' => 1800
			],
			(object) [
				'width' => 2560,
				'height' => 1440
			],
			(object) [
				'width' => 1920,
				'height' => 1200
			],
			(object) [
				'width' => 1920,
				'height' => 1080
			],
			(object) [
				'width' => 1680,
				'height' => 1050
			],
			(object) [
				'width' => 1600,
				'height' => 1200
			],
			(object) [
				'width' => 1600,
				'height' => 900
			],
			(object) [
				'width' => 1440,
				'height' => 900
			],
			(object) [
				'width' => 1366,
				'height' => 768
			],
			(object) [
				'width' => 1280,
				'height' => 1024
			],
			(object) [
				'width' => 1280,
				'height' => 800
			],
			(object) [
				'width' => 1024,
				'height' => 768
			]
		);
		$resolutionsHtml = "";
		foreach ($resolutions as $resolution) {
			$fullWidth = $resolution->width * $multiplier;
			$resolutionsHtml .= "<a href=\"?userwidth=".$fullWidth."&amp;userheight=".$resolution->height."\">";
			$isResolutionSelected = false;
			if ($userResolution == $fullWidth."x".$resolution->height) {
				$isResolutionSelected = true;
			}
			if ($isResolutionSelected) {
				$resolutionsHtml .= "<strong>";
			}
			$resolutionsHtml .= $fullWidth."x".$resolution->height;
			if ($isResolutionSelected) {
				$resolutionsHtml .= "</strong>";
			}
			$resolutionsHtml .= "</a> (".$resolution->width."x".$resolution->height."x".$multiplier.")<br>";
		}
		echo $resolutionsHtml;
		?>
		<strong style="display:block;margin:10px 0 5px 0;">Or enter a <?php if (isset($_COOKIE['DisableImageResizing'])) { ?>minimum <?php } ?>resolution: <span style="font-weight:normal;">(max: <?php echo $resolutions[0]->width * $multiplier; ?>x<?php echo $resolutions[0]->height; ?>)</span></strong>
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
