<script language="javascript" type="text/javascript">
/* tinyMCEPopup.requireLangPack(); */

var ZenpageDialog = {
	init : function(ed) {
		tinyMCEPopup.resizeToInnerSize();
	},

	insert : function(imgurl,imgname,imgtitle,albumtitle,fullimage,type, wm_thumb, wm_img,video) {

		var ed = tinyMCEPopup.editor, dom = ed.dom;
		var imglink = '';
		var includetype = '';
		var imagesize = '';
		var linkpart1 = '';
		var linkpart2 = '';
		var linktype = '';
		var textwrap = '';
		var textwrap_float = '';
		var titlewrap1 = '';
		var titlewrap2 = '';
		var cssclass = '';
		var albumname = '<?php if(isset($_GET["album"]))  { echo sanitize($_GET["album"]); } else { $_GET["album"] = ""; } ?>';
		var webpath = '<?php echo WEBPATH; ?>'
		var modrewrite = '<?php echo MOD_REWRITE; ?>';
		var modrewritesuffix = '<?php echo getOption("mod_rewrite_image_suffix"); ?>';
		<?php 
		chdir(SERVERPATH.'/'.ZENFOLDER.'/'.PLUGIN_FOLDER.'/flowplayer3');
		$filelist = safe_glob('flowplayer-*.swf');
		$swf = array_shift($filelist);
		$flowplayerpath = pathurlencode(WEBPATH . '/' . ZENFOLDER . '/'.PLUGIN_FOLDER . '/flowplayer3/'.$swf);
		?>
		var flowplayerpath = '<?php echo $flowplayerpath; ?>';
		// getting the image size checkbox values
		if($('#thumbnail:checked').val() == 1) {
			imagesize = '&amp;s=<?php echo getOption("thumb_size"); ?>&amp;cw=<?php echo getOption("thumb_crop_width"); ?>&amp;ch=<?php echo getOption("thumb_crop_height"); ?>&amp;t=true';
			if (wm_thumb) {
				imagesize += '&ampwmk='+wm_thumb;
			}
			cssclass ='zenpage_thumb';
		}
		if($('#customthumb:checked').val() == 1) {
			imagesize = '&amp;s='+$('#cropsize').val()+'&amp;cw='+$('#cropwidth').val()+'&amp;ch='+$('#cropheight').val()+'&amp;t=true';
			if (wm_thumb) {
				imagesize += '&ampwmk='+wm_thumb;
			}
			cssclass ='zenpage_customthumb';
		}

		if($('#sizedimage:checked').val() == 1) {
			imagesize = '&amp;s=<?php echo getOption("image_size"); ?>';
			if (wm_img) {
				imagesize += '&ampwmk='+wm_img;
			}
			cssclass ='zenpage_sizedimage';
		}
		if($('#customsize:checked').val() == 1) {
			imagesize = '&amp;s='+$('#size').val();
			if (wm_img) {
				imagesize += '&ampwmk='+wm_img;
			}
			cssclass ='zenpage_customimage';
		}

		// getting the text wrap checkbox values
		// Customize the textwrap variable if you need specific CSS
		if($('#nowrap:checked').val() == 1) {
			textwrap = 'class=\''+cssclass+'\'';
			textwrap_title = '';
			textwrap_title_add = '';
		}
		if($('#rightwrap:checked').val() == 1) {
			// we don't need (inline) css attached to the image/link it they are wrapped for the title, the div does the wrapping!
			if($('#showtitle:checked').val() != 1) {
				textwrap_float = ' style=\'float: left;\'';
			}
			textwrap = 'class=\''+cssclass+'_left\''+textwrap_float;
			textwrap_title = ' style=\'float: left;\' ';
			textwrap_title_add = '_left';
		}
		if($('#leftwrap:checked').val() == 1) {
			// we don't need (inline) css attached to the image/link it they are wrapped for the title, the div does the wrapping!
			if($('#showtitle:checked').val() != 1) {
				textwrap_float = ' style=\'float: right;\'';
			}
			textwrap = 'class=\''+cssclass+'_right\''+textwrap_float;
			textwrap_title = ' style=\'float: right;\' ';
			textwrap_title_add = '_right';
		}
		// getting the link type checkbox values
		if($('#imagelink:checked').val() == 1) {
			if(modrewrite == '1') {
				linkpart1 = '<a href=\''+webpath+'/'+albumname+'/'+imgname+modrewritesuffix+'\' title=\''+imgtitle+'\' class=\'zenpage_imagelink\'>';
			} else {
				linkpart1 = '<a href=\''+webpath+'/index.php?album='+albumname+'&amp;image='+imgname+'\' title=\''+imgtitle+'\' class=\'zenpage_imagelink\'>';
			}
			linkpart2 = '</a>';
		}
		if($('#fullimagelink:checked').val() == 1) {
				linkpart1 = '<a href=\''+fullimage+'\' title=\''+imgtitle+'\' class=\'zenpage_fullimagelink\'>';
				linkpart2 = '</a>';
		}
		if($('#albumlink:checked').val() == 1) {
			if(modrewrite == '1') {
				linkpart1 = '<a href=\''+webpath+'/'+albumname+'\' title=\''+albumtitle+'\' class=\'zenpage_albumlink\'>';
			} else {
				linkpart1 = '<a href=\''+webpath+'/index.php?album='+albumname+'\' title=\''+albumtitle+'\' class=\'zenpage_albumlink\'>';
			}
			linkpart2 = '</a>';
		}
		if($('#customlink:checked').val() == 1) {
			linkpart1 = '<a href=\''+$('#linkurl').val()+'\' title=\''+linktype+'\' '+textwrap+' class=\'zenpage_customlink\'>';
			linkpart2 = '</a>';
		}
		// getting the include type checkbox values
		if($('#image:checked').val() == 1) {
			includetype = '<img src=\''+imgurl+imagesize+'\' alt=\''+imgtitle+'\' '+textwrap+' />';
			if($('#showtitle:checked').val() == 1) {
				titlewrap1 = '<div class=\'zenpage_wrapper'+textwrap_title_add+'\''+textwrap_title+'>';
				if($('#albumlink:checked').val() == 1) {
					titlewrap2 = '<div class=\'zenpage_title\'>'+albumtitle+'</div></div>';
				} else {
					titlewrap2 = '<div class=\'zenpage_title\'>'+imgtitle+'</div></div>';
				}
			}
		}
		if($('#imagetitle:checked').val() == 1) {
			includetype = html_encode(imgtitle);
		}
		if($('#albumtitle:checked').val() == 1) {
			includetype = html_encode(albumtitle);
		}
		if($('#customtext:checked').val() == 1) {
			includetype = $('#text').val();
		}

		// building the final item to include
		if(type == "zenphoto") {
			if(video == 'video' && ($('#sizedimage:checked').val() == 1 || $('#customsize:checked').val() == 1)) {
				imglink = titlewrap1+'<object '+textwrap+' width="480" height="340" id="undefined" name="undefined" data="'+flowplayerpath+'" type="application/x-shockwave-flash"><param name="movie" value="'+flowplayerpath+'" /><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="flashvars" value=\'config={"clip":{"url":"'+fullimage+'"}}\' /></object>'+titlewrap2;
			}	else {
				imglink = titlewrap1+linkpart1+includetype+linkpart2+titlewrap2;
			}
		} else {
			if(type == "pages") {
				if(modrewrite == '1') {
					imglink = '<a href=\''+webpath+'/'+imgurl+'\' title=\''+imgtitle+'\'>'+imgtitle+'</a>';
				} else {
					imglink = '<a href=\''+webpath+'/index.php?p=pages&amp;title='+imgname+'\' title=\''+imgtitle+'\'>'+imgtitle+'</a>';
				}
			}
			if(type == "articles") {
				if(modrewrite == '1') {
					imglink = '<a href=\''+webpath+'/'+imgurl+'\' title=\''+imgtitle+'\'>'+imgtitle+'</a>';
				} else {
					imglink = '<a href=\''+webpath+'/index.php?p=news&amp;title='+imgname+'\' title=\''+imgtitle+'\'>'+imgtitle+'</a>';
				}
			}
			if(type == "categories") {
				if(modrewrite == '1') {
					imglink = '<a href=\''+webpath+'/'+imgurl+'\' title=\''+imgtitle+'\'>'+imgtitle+'</a>';
				} else {
					imglink = '<a href=\''+webpath+'/index.php?p=news&amp;category='+imgname+'\' title=\''+imgtitle+'\'>'+imgtitle+'</a>';
				}
			}
		}
		tinyMCEPopup.execCommand('mceInsertContent', false, imglink);
	}
};

tinyMCEPopup.onInit.add(ZenpageDialog.init, ZenpageDialog);
</script>