<div id="gallerytitle">
  <?php
	$logoAffix = 'd';
	if (str_contains($_SERVER['SERVER_NAME'], 'triple')) {
	  $logoAffix = 't';
	} else if (str_contains($_SERVER['SERVER_NAME'], 'quad')) {
	  $logoAffix = 'q';
	}
	?>
  <a href="/" id="Logo" style="background-image: url(/themes/mmg/images/logo-<?php echo $logoAffix; ?>mb.png);"></a>
  <div class="registerOrLoginLinks">
    <?php
    callUserFunction('registerUser::printLink', gettext('Register'), '', ' | ');
    callUserFunction('printUserLogin_out', '', ' ', NULL, ' ');
    ?>
  </div>
  <?php
  if (getOption('Allow_search')) {
    printSearchForm('', 'search', '', ' ');
  }
  ?>
</div>
