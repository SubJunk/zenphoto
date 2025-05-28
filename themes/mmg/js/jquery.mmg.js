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
			var thumbnailContainerList = null;
			var h3List                 = null;
			var imagesPerRow           = null;
			var totalSpaceMinusMargins = null;
			var correctWidth           = null;
			var totalWidth             = null;
			var whichContainer         = null;
			var didFirstContainer      = null;

			// Do the main margins
			whichContainer = "images";
			container = document.getElementById("images");
			if (container == null) {
				container = document.getElementById("albums");
				whichContainer = "albums";
			}
			if (container != null) {
				imageList = container.getElementsByTagName("img");
				thumbnailContainerList = container.getElementsByTagName("li");
				h3List = container.getElementsByTagName("h3");
				imagesPerRow = "";
				totalSpaceMinusMargins = "";
				correctWidth = null;

				totalWidth = container.offsetWidth;
				if (totalWidth > 7295) {
					imagesPerRow = 20;
				} else if (totalWidth > 6910) {
					imagesPerRow = 19;
				} else if (totalWidth > 6525) {
					imagesPerRow = 18;
				} else if (totalWidth > 6140) {
					imagesPerRow = 17;
				} else if (totalWidth > 5755) {
					imagesPerRow = 16;
				} else if (totalWidth > 5370) {
					imagesPerRow = 15;
				} else if (totalWidth > 4985) {
					imagesPerRow = 14;
				} else if (totalWidth > 4600) {
					imagesPerRow = 13;
				} else if (totalWidth > 4215) {
					imagesPerRow = 12;
				} else if (totalWidth > 3830) {
					imagesPerRow = 11;
				} else if (totalWidth > 3445) {
					imagesPerRow = 10;
				} else if (totalWidth > 3060) {
					imagesPerRow = 9;
				} else if (totalWidth > 2675) {
					imagesPerRow = 8;
				} else if (totalWidth > 2290) {
					imagesPerRow = 7;
				} else if (totalWidth > 1905) {
					imagesPerRow = 6;
				} else if (totalWidth > 1520) {
					imagesPerRow = 5;
				} else if (totalWidth > 1135) {
					imagesPerRow = 4;
				} else if (totalWidth > 750) {
					imagesPerRow = 3;
				} else {
					imagesPerRow = 2;
				}

				if (imageList.length >= imagesPerRow) {
					for(i = 0; i < imageList.length; i++) {
						if (correctWidth == null) {
							totalSpaceMinusMargins = totalWidth - (20 * (imagesPerRow - 1));
							correctWidth = (totalSpaceMinusMargins / imagesPerRow) - 0.1;
						}

						h3List[i].style.width    = correctWidth+"px";
						imageList[i].style.width = correctWidth+"px";

						if (!((i + 1) % imagesPerRow === 0)) {
							thumbnailContainerList[i].style.marginRight = "20px";
						} else {
							thumbnailContainerList[i].style.marginRight = "0";
						}

						// Hide/display thumbnails that don't fit nicely into the user's resolution
						if (whichContainer == "albums") {
							if (imagesPerRow < 5 && i > 11) {
								imageList[i].style.display = "none";
								h3List[i].style.display    = "none";
							} else {
								imageList[i].style.display = "block";
								h3List[i].style.display    = "block";
							}
						}
					}
				}
				didFirstContainer = true;
			}

			// Do the user margins
			container = document.getElementById("albumsusersinner");
			if (container != null) {
				imageList = container.getElementsByTagName("img");
				thumbnailContainerList = container.getElementsByTagName("li");
				h3List = container.getElementsByTagName("h3");

				if (imageList.length >= imagesPerRow || didFirstContainer) {
					for(i = 0; i < imageList.length; i++) {
						h3List[i].style.width    = correctWidth+"px";
						imageList[i].style.width = correctWidth+"px";
						if (!((i + 1) % imagesPerRow === 0)) {
							thumbnailContainerList[i].style.marginRight = "20px";
						} else {
							thumbnailContainerList[i].style.marginRight = "0";
						}

						// Hide/display thumbnails that don't fit nicely into the user's resolution
						if (whichContainer == "albums") {
							if (imagesPerRow < 5 && i > 11) {
								imageList[i].style.display = "none";
								h3List[i].style.display    = "none";
							} else {
								imageList[i].style.display = "block";
								h3List[i].style.display    = "block";
							}
						}
					}
				}
			}

			// Do the official category margins
			container = document.getElementById("OfficialCategories");
			if (container != null) {
				imageList = container.getElementsByTagName("img");
				thumbnailContainerList = container.getElementsByTagName("li");
				h3List = container.getElementsByTagName("h3");

				for(i = 0; i < imageList.length; i++) {
					h3List[i].style.width    = correctWidth+"px";
					imageList[i].style.width = correctWidth+"px";
					if (!((i + 1) % imagesPerRow === 0)) {
						thumbnailContainerList[i].style.marginRight = "20px";
					} else {
						thumbnailContainerList[i].style.marginRight = "0";
					}
				}
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

	var currentDomain = 'beta.triplemonitorbackgrounds.com';

	$(".DisableImageResizing").click(function () {
		$.cookie('DisableImageResizing', 'yes', {expires: 30, path: '/', domain: currentDomain});
		location.reload();
	});

	$(".EnableImageResizing").click(function () {
		$.cookie('DisableImageResizing', null, {path: '/', domain: currentDomain});
		location.reload();
	});

	$(".ShrinkWelcomeText").click(function () {
		$('#WelcomeTextLower').slideUp('slow', function() { });
		$.cookie('ShrinkWelcomeText', 'yes', {expires: 30, path: '/', domain: currentDomain});
	});

	$(".ExpandWelcomeText").click(function () {
		$('#WelcomeTextLower').slideDown('slow', function() { });
		$.cookie('ShrinkWelcomeText', null, {path: '/', domain: currentDomain});
		location.reload();
	});

	$(".EnableNSFW").click(function () {
		$.cookie('EnableNSFW', 'yes', {expires: 30, path: '/', domain: currentDomain});
		location.reload();
	});

	$(".DisableNSFW").click(function () {
		$.cookie('EnableNSFW', null, {path: '/', domain: currentDomain});
		location.reload();
	});

	$('input.EnableImageResizing').attr('checked', false);
	$('input.DisableNSFW').attr('checked', true);
	$('input.DisableImageResizing').attr('checked', true);
	$('input.EnableNSFW').attr('checked', false);

	$("#ExplainImageResizing").tipTip({maxWidth:"400px"});
	$("#ExplainNSFW").tipTip({maxWidth:"400px"});

	$(window).bind('load resize', $.ImageMargins.changeMargins);
});
