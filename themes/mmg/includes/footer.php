<?php

function getFooter($profilePage=false, $contactSubject='') {
	?>
		<div id="Footer">
			<div class="news">
				<div>
					<h2>News</h2>
					<a href="https://www.facebook.com/DualMonitorBackgrounds" title="dmb on Facebook">News via Facebook</a>
				</div>
			</div>
			<div class="pages">
				<div>
					<h2>Pages</h2>
					<a href="/users/" title="All Users">User List</a><br>
					<a href="/page/random/" title="Random Images">Random Images</a><br>
					<a href="/page/register/" title="Register">Register</a><br>
					<?php
						if ($profilePage) {
							printRSSLink('Album', '', gettext('RSS'), '');
							echo '<br>';
						} else {
							echo '
								<a href="/index.php?rss&amp;lang=en_US" title="Latest images RSS" rel="nofollow">RSS <img src="/zp-core/images/rss.png" alt="RSS Feed"></a><br>
							';
						}
					?>
					<a href="/page/contact/?subject=<?php echo $contactSubject; ?>" title="Contact us">Contact us</a><br>
					<a href="/page/faq" title="Frequently Asked Questions">FAQ</a>
				</div>
			</div>
			<div class="links">
				<div>
					<h2>Links</h2>
					<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=3HMB8YGFHEEVN" title="Donate to qmb">Donate to qmb</a><br>
					<a href="http://www.dualmonitorbackgrounds.com" title="Dual Monitor Backgrounds">Dual Monitor Backgrounds</a><br>
					<a href="http://www.triplemonitorbackgrounds.com" title="Triple Monitor Backgrounds">Triple Monitor Backgrounds</a><br>
					<a href="http://www.zenphoto.org" title="A simpler web album">zenphoto</a>
				</div>
			</div>
			<br style="clear:left;">
		</div>
	<?php
}
?>
