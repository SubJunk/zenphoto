/* jquery.slidinglabels.js 3.2.1 */
(function(e){e.fn.slidinglabels=function(t,n){var r={className:"form-slider",topPosition:"5px",leftPosition:"5px",axis:"x",speed:"fast"},t=e.extend(r,t),i=this.find("."+r.className+""),s=i.find("label");return s.each(function(){obj=e(this);var t=obj.parents("."+r.className+"");t.css({position:"relative"});obj.css({position:"absolute",top:r.topPosition,left:r.leftPosition,display:"inline","z-index":99});var n=e(this).next().val(),i=e(this).width(),s=i+5+"px",o=e(this).height();if(n!==""){if(r.axis=="x"){obj.stop().animate({left:"-"+s},1)}else if(r.axis=="y"){obj.stop().animate({top:"-"+o},1)}}e("input, textarea").focus(function(){var t=e(this).prev("label"),n=t.width(),i=t.height(),s=n+5+"px",o=i+"px",u=e(this).val();if(u==""){if(r.axis=="x"){t.stop().animate({left:"-"+s},r.speed)}else if(r.axis=="y"){t.stop().animate({top:"-"+o},r.speed)}}else{if(r.axis=="x"){t.css({left:"-"+s})}else if(r.axis=="y"){t.css({top:"-"+o})}}}).blur(function(){var t=e(this).prev("label"),n=e(this).val();if(n==""){if(r.axis=="x"){t.stop().animate({left:r.leftPosition},r.speed)}else if(r.axis=="y"){t.stop().animate({top:r.topPosition},r.speed)}}})})}})(jQuery);

/* TipTip 1.3 from https://github.com/drewwilson/TipTip/blob/master/jquery.tipTip.minified.js */
(function($){$.fn.tipTip=function(options){var defaults={activation:"hover",keepAlive:false,maxWidth:"200px",edgeOffset:3,defaultPosition:"bottom",delay:400,fadeIn:200,fadeOut:200,attribute:"title",content:false,enter:function(){},exit:function(){}};var opts=$.extend(defaults,options);if($("#tiptip_holder").length<=0){var tiptip_holder=$('<div id="tiptip_holder" style="max-width:'+opts.maxWidth+';"></div>');var tiptip_content=$('<div id="tiptip_content"></div>');var tiptip_arrow=$('<div id="tiptip_arrow"></div>');$("body").append(tiptip_holder.html(tiptip_content).prepend(tiptip_arrow.html('<div id="tiptip_arrow_inner"></div>')))}else{var tiptip_holder=$("#tiptip_holder");var tiptip_content=$("#tiptip_content");var tiptip_arrow=$("#tiptip_arrow")}return this.each(function(){var org_elem=$(this);if(opts.content){var org_title=opts.content}else{var org_title=org_elem.attr(opts.attribute)}if(org_title!=""){if(!opts.content){org_elem.removeAttr(opts.attribute)}var timeout=false;if(opts.activation=="hover"){org_elem.hover(function(){active_tiptip()},function(){if(!opts.keepAlive){deactive_tiptip()}});if(opts.keepAlive){tiptip_holder.hover(function(){},function(){deactive_tiptip()})}}else if(opts.activation=="focus"){org_elem.focus(function(){active_tiptip()}).blur(function(){deactive_tiptip()})}else if(opts.activation=="click"){org_elem.click(function(){active_tiptip();return false}).hover(function(){},function(){if(!opts.keepAlive){deactive_tiptip()}});if(opts.keepAlive){tiptip_holder.hover(function(){},function(){deactive_tiptip()})}}function active_tiptip(){opts.enter.call(this);tiptip_content.html(org_title);tiptip_holder.hide().removeAttr("class").css("margin","0");tiptip_arrow.removeAttr("style");var top=parseInt(org_elem.offset()['top']);var left=parseInt(org_elem.offset()['left']);var org_width=parseInt(org_elem.outerWidth());var org_height=parseInt(org_elem.outerHeight());var tip_w=tiptip_holder.outerWidth();var tip_h=tiptip_holder.outerHeight();var w_compare=Math.round((org_width-tip_w)/2);var h_compare=Math.round((org_height-tip_h)/2);var marg_left=Math.round(left+w_compare);var marg_top=Math.round(top+org_height+opts.edgeOffset);var t_class="";var arrow_top="";var arrow_left=Math.round(tip_w-12)/2;if(opts.defaultPosition=="bottom"){t_class="_bottom"}else if(opts.defaultPosition=="top"){t_class="_top"}else if(opts.defaultPosition=="left"){t_class="_left"}else if(opts.defaultPosition=="right"){t_class="_right"}var right_compare=(w_compare+left)<parseInt($(window).scrollLeft());var left_compare=(tip_w+left)>parseInt($(window).width());if((right_compare&&w_compare<0)||(t_class=="_right"&&!left_compare)||(t_class=="_left"&&left<(tip_w+opts.edgeOffset+5))){t_class="_right";arrow_top=Math.round(tip_h-13)/2;arrow_left=-12;marg_left=Math.round(left+org_width+opts.edgeOffset);marg_top=Math.round(top+h_compare)}else if((left_compare&&w_compare<0)||(t_class=="_left"&&!right_compare)){t_class="_left";arrow_top=Math.round(tip_h-13)/2;arrow_left=Math.round(tip_w);marg_left=Math.round(left-(tip_w+opts.edgeOffset+5));marg_top=Math.round(top+h_compare)}var top_compare=(top+org_height+opts.edgeOffset+tip_h+8)>parseInt($(window).height()+$(window).scrollTop());var bottom_compare=((top+org_height)-(opts.edgeOffset+tip_h+8))<0;if(top_compare||(t_class=="_bottom"&&top_compare)||(t_class=="_top"&&!bottom_compare)){if(t_class=="_top"||t_class=="_bottom"){t_class="_top"}else{t_class=t_class+"_top"}arrow_top=tip_h;marg_top=Math.round(top-(tip_h+5+opts.edgeOffset))}else if(bottom_compare|(t_class=="_top"&&bottom_compare)||(t_class=="_bottom"&&!top_compare)){if(t_class=="_top"||t_class=="_bottom"){t_class="_bottom"}else{t_class=t_class+"_bottom"}arrow_top=-12;marg_top=Math.round(top+org_height+opts.edgeOffset)}if(t_class=="_right_top"||t_class=="_left_top"){marg_top=marg_top+5}else if(t_class=="_right_bottom"||t_class=="_left_bottom"){marg_top=marg_top-5}if(t_class=="_left_top"||t_class=="_left_bottom"){marg_left=marg_left+5}tiptip_arrow.css({"margin-left":arrow_left+"px","margin-top":arrow_top+"px"});tiptip_holder.css({"margin-left":marg_left+"px","margin-top":marg_top+"px"}).attr("class","tip"+t_class);if(timeout){clearTimeout(timeout)}timeout=setTimeout(function(){tiptip_holder.stop(true,true).fadeIn(opts.fadeIn)},opts.delay)}function deactive_tiptip(){opts.exit.call(this);if(timeout){clearTimeout(timeout)}tiptip_holder.fadeOut(opts.fadeOut)}}})}})(jQuery);

/* Our JavaScript */
$(function(){
	$('#LoginFormProper').slidinglabels({
		className    : 'slider',
		topPosition  : '5px',
		leftPosition : '8px'
	});

	$.ImageMargins = {
		changeMargins: function() {
			// Initialise variables
			var container              = null;
			var imageList              = null;
			var h3List                 = null;
			var imagesPerRow           = null;
			var imagesTotal            = null;
			var totalSpaceMinusMargins = null;
			var correctWidth           = null;
			var correctHeight          = null;
			var totalWidth             = null;
			var whichContainer         = null;
			var didFirstContainer      = null;
			var displayRightAd         = false;

			let imagesPerRowWidth = 300;
			let thumbnailAspectRatio = 2.872;
			let imagesPerRowThreshold = 3;
			let imagesPerRowMultiplier = 4;
			if (window.location.href.includes('triple')) {
				imagesPerRowWidth = 450;
				thumbnailAspectRatio = 4.175;
				imagesPerRowThreshold = 2;
				imagesPerRowMultiplier = 4;
			} else if (window.location.href.includes('quad')) {
				imagesPerRowWidth = 535;
				thumbnailAspectRatio = 5.578;
				imagesPerRowThreshold = 2;
				imagesPerRowMultiplier = 5;
			}

			// Do the main margins
			if (document.getElementById("images") !== null) {
				container = document.getElementById("images");
				whichContainer = "images";
			} else if (document.getElementById("relateditems") !== null) {
				container = document.getElementById("relateditems");
				whichContainer = "relateditems";
			} else if (document.getElementById("albums") !== null) {
				container = document.getElementById("albums");
				whichContainer = "albums";
			} else if (document.getElementById("albumsSearch") !== null) {
				container = document.getElementById("albumsSearch");
				whichContainer = "albumsSearch";
			}

			if (container !== null) {
				imageList = container.getElementsByTagName("img");
				h3List = container.getElementsByTagName("h3");
				imagesPerRow = "";
				totalSpaceMinusMargins = "";
				correctWidth  = null;
				correctHeight = null;

				totalWidth = container.offsetWidth - 40;
				if ($('#AdBoxTopRight ins').length && (whichContainer === "albums" || whichContainer === "images")) {
					totalWidth = totalWidth - 320;
					displayRightAd = true;
				}

				imagesPerRow = Math.round(totalWidth / imagesPerRowWidth);

				if (imagesPerRow < imagesPerRowThreshold) {
					totalWidth = container.offsetWidth - 40;
					imagesPerRow = Math.round(totalWidth / imagesPerRowWidth);
					displayRightAd = false;
				}

				imagesTotal  = imagesPerRow * imagesPerRowMultiplier;

				if (imageList.length >= imagesPerRow) {
					if (correctWidth == null) {
						totalSpaceMinusMargins = totalWidth - (20 * (imagesPerRow - 1));
						correctWidth = (totalSpaceMinusMargins / imagesPerRow) - 0.1;
						correctHeight = correctWidth / thumbnailAspectRatio;
					}

					for (i = 0; i < imageList.length; i++) {
						h3List[i].style.maxWidth  = correctWidth + "px";
						imageList[i].style.width  = correctWidth + "px";
						imageList[i].style.height = correctHeight + "px";

						// Hide/display thumbnails that don't fit nicely into the user's resolution
						if (whichContainer == "albums") {
							if (i >= imagesTotal) {
								imageList[i].style.display = "none";
								h3List[i].style.display    = "none";
							} else {
								imageList[i].style.display = "block";
								h3List[i].style.display    = "inlineBlock";
							}
						} else if (whichContainer == "relateditems") {
							if (i > (imagesPerRow - 1)) {
								imageList[i].style.display = "none";
								h3List[i].style.display    = "none";
							} else {
								imageList[i].style.display = "block";
								h3List[i].style.display    = "inlineBlock";
							}
						}
					}
				}
				didFirstContainer = true;
			}

			// Do the user margins
			if (document.getElementById("albumsusersinner") !== null) {
				container = document.getElementById("albumsusersinner");

				totalWidth = container.offsetWidth - 40;
				imagesPerRow = Math.round(totalWidth / imagesPerRowWidth);
				imagesTotal  = imagesPerRow * 4;

				imageList = container.getElementsByTagName("img");
				h3List = container.getElementsByTagName("h3");
				correctWidth = null;
				correctHeight = null;

				if (imageList.length >= imagesPerRow || didFirstContainer) {
					if (correctWidth == null) {
						totalSpaceMinusMargins = totalWidth - (20 * (imagesPerRow - 1));
						correctWidth = (totalSpaceMinusMargins / imagesPerRow) - 0.1;
						correctHeight = correctWidth / thumbnailAspectRatio;
					}

					for (i = 0; i < imageList.length; i++) {
						h3List[i].style.maxWidth  = correctWidth + "px";
						imageList[i].style.width  = correctWidth + "px";
						imageList[i].style.height = correctHeight + "px";

						// Hide/display thumbnails that don't fit nicely into the user's resolution
						if (whichContainer == "albums") {
							if (i >= imagesTotal) {
								imageList[i].style.display = "none";
								h3List[i].style.display    = "none";
							} else {
								imageList[i].style.display = "block";
								h3List[i].style.display    = "inlineBlock";
							}
						}
					}
				}
			}

			// Do the official category margins
			if (document.getElementById("OfficialCategories") !== null) {
				container = document.getElementById("OfficialCategories");
				imageList = container.getElementsByTagName("img");
				h3List = container.getElementsByTagName("h3");

				for (i = 0; i < imageList.length; i++) {
					h3List[i].style.maxWidth  = correctWidth + "px";
					imageList[i].style.width  = correctWidth + "px";
					imageList[i].style.height = correctHeight + "px";
				}
			}

			if (displayRightAd) {
				var thumbnailsTotalHeight = $('.thumbnails.topRow ul').innerHeight();
				if (thumbnailsTotalHeight < 600) {
					$("#padbox").css("min-height", 600);
				} else {
					$("#AdBoxTopRight").css("min-height", thumbnailsTotalHeight);
				}
				$("#AdBoxTopRight").css("display", "block");
			} else {
				$("#padbox").css("min-height", 0);
				$("#AdBoxTopRight").css("display", "none");
			}
		}
	};

	$("#ResolutionPreferencesLink").click(function () {
		$('#ResolutionPreferencesLink'   ).slideUp  ('slow', function() { });
		$('#ResolutionPreferencesOptions').slideDown('slow', function() { });
	});

	$("#CloseResolutionPreferencesOptions").click(function () {
		$('#ResolutionPreferencesLink'   ).slideDown('slow', function() { });
		$('#ResolutionPreferencesOptions').slideUp  ('slow', function() { });
	});

	$(".DisableImageResizing").click(function () {
		$.cookie('DisableImageResizing', 'yes', {expires: 30, path: '/'});
		location.reload();
	});

	$(".EnableImageResizing").click(function () {
		$.removeCookie('DisableImageResizing', {path: '/'});
		location.reload();
	});

	$(".ShrinkWelcomeText").click(function () {
		$('#WelcomeTextLower').toggle();
		$('#ExpandWelcomeTextContainer').toggle();
		$.removeCookie('ShowWelcomeText', {path: '/'});
	});

	$(".ExpandWelcomeText").click(function () {
		$('#WelcomeTextLower').toggle();
		$('#ExpandWelcomeTextContainer').toggle();
		$.cookie('ShowWelcomeText', 'yes', {expires: 30, path: '/'});
	});

	$(".EnableNSFW").click(function () {
		$.cookie('EnableNSFW', 'yes', {expires: 30, path: '/'});
		location.reload();
	});

	$(".DisableNSFW").click(function () {
		$.removeCookie('EnableNSFW', {path: '/'});
		location.reload();
	});

	$(".thumbnails.topRow li").hover(function () {
		$(this).children("span.imageResolutionContainer").animate({width: 'toggle'}, {duration: 200});
		$(this).children("h3").slideToggle(200);
	});

	$('input.EnableImageResizing').attr('checked', false);
	$('input.DisableNSFW').attr('checked', true);
	$('input.DisableImageResizing').attr('checked', true);
	$('input.EnableNSFW').attr('checked', false);

	$("#ExplainImageResizing").tipTip({maxWidth:"400px"});
	$("#ExplainNSFW").tipTip({maxWidth:"400px"});

	$(window).bind('load resize', $.ImageMargins.changeMargins);
});
