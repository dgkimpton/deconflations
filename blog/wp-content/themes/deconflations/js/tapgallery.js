

function EnsureID(suspectedID) {
	if (suspectedID.lastIndexOf('#', 0) === 0)
		return suspectedID;
	else
		return '#' + suspectedID;
}

function Gallery(containerID, descriptionID, previousID, nextID, galleryWidth, vPadding, hPadding) {
	this.Images = new Array();
	this.CurrentImageIndex = 0;
	this.GalleryWidth = galleryWidth;
	this.VPadding = vPadding;
	this.HPadding = hPadding;

	this.ContainerID = EnsureID(containerID);
	this.DescriptionID = EnsureID(descriptionID);
	this.NextButtonID = EnsureID(previousID);
	this.PreviousButtonID = EnsureID(nextID);
}



Gallery.prototype.AddImage = function (src, title) {
	var image = new ImageInformation();
	image.Src = src;
	image.Title = title;
	this.Images.push(image);
}

Gallery.prototype.ShowFirst = function () {
	if(this.Images.length == 0)
	{
		$j(this.ContainerID).append($j('<p></p>')).append('[No Images]');
		$j(this.ContainerID).css('text-align', 'center');
		return;
	}
	
	this.CurrentIMG = '#leftImage';
	this.NextIMG = '#rightImage';

	$j(this.ContainerID).css('position', 'relative');

	var basicImgTag = '<img />';

	$j(this.ContainerID).append($j(basicImgTag).attr('id', this.CurrentIMG.substr(1)));
	$j(this.CurrentIMG).css('float', 'left');
	$j(this.CurrentIMG).css('position', 'absolute');
	$j(this.CurrentIMG).css('padding', '0px');
	$j(this.CurrentIMG).css('display', 'none');
	
	$j(this.ContainerID).append($j(basicImgTag).attr('id', this.NextIMG.substr(1)));
	$j(this.NextIMG).css('float', 'left');
	$j(this.NextIMG).css('position', 'absolute');
	$j(this.NextIMG).css('padding', '0px');
	$j(this.NextIMG).css('display', 'none');

	$j(this.DescriptionID).append('<div id="tap_Gallery_content">&nbsp;</div>');

	// Load & display
	this.CurrentImageIndex = 0;
	this.__UnbindLinks();
	var newImage = this.Images[this.CurrentImageIndex].Load(this.GalleryWidth - this.HPadding, this, 'DirectDisplay');
	
	var i = 1;
	for(i = 1; i < this.Images.length; ++i)
	{
	    this.Images[i].Load(this.GalleryWidth - this.HPadding, null, null);
	}
}

Gallery.prototype.__SpecifyImage = function (id, src, width, height, top, left, title) {
	$j(id).css('display', 'none');
	$j(id).css('padding', '0px');

	$j(id).attr("src", src);
	$j(id).css('width', width + 'px');
	$j(id).css('height', height + 'px');
	$j(id).css('top', top + 'px');
	$j(id).css('left', left + 'px');

	$j(id).attr('alt', title);
}

Gallery.prototype.NextImage = function () {
	this.__UnbindLinks();

   this.Images[++this.CurrentImageIndex].Load(this.GalleryWidth - this.HPadding, this, '__AnimateToNext')
}

Gallery.prototype.PreviousImage = function () {
	this.__UnbindLinks();

	this.Images[--this.CurrentImageIndex].Load(this.GalleryWidth - this.HPadding, this, '__AnimateToPrevious')
}

Gallery.prototype.__AnimateToNext = function(newImage) {
	this.___AnimateTransition(newImage, false);
}
Gallery.prototype.__AnimateToPrevious = function(newImage) {
	this.___AnimateTransition(newImage, true);
}

Gallery.prototype.DirectDisplay = function (newImage) {
	$j(this.ContainerID).css('width', this.GalleryWidth + 'px');
	$j(this.ContainerID).css('height', (newImage.Height + this.VPadding) + 'px');

	this.__SpecifyImage(this.CurrentIMG,
						newImage.Src,
						newImage.Width,
						newImage.Height,
						this.VPadding,
						((this.GalleryWidth - newImage.Width) / 2),
						newImage.Title);

	var gallery = this;
	new Effect.Appear(this.CurrentIMG.substr(1), { afterFinish: function () {
	    $j('#tap_Gallery_content').replaceWith('<div id="tap_Gallery_content">' + newImage.Title + '</div>');
		gallery.__BindLinks();
	}
	});
}

Gallery.prototype.___AnimateTransition = function (newImage, goPrevious) {
    var currentTop = parseFloat($j(this.CurrentIMG).css('top'));
    var currentHeight = parseFloat($j(this.CurrentIMG).css('height'));

    var vStart = currentTop + (currentHeight / 2);
    vCenter = newImage.Height / 2 + this.VPadding;
    hPadding = (this.GalleryWidth - newImage.Width) / 2;

    // Load & reset next image
    this.__SpecifyImage(this.NextIMG,
						newImage.Src,
						0,
						0,
						vStart,
						((goPrevious) ? 0 : this.GalleryWidth),
						newImage.Title);

    var shrinkStyling = " width: " + 0 + "px;"
						+ " height: " + 0 + "px;"
						+ " left: " + ((goPrevious) ? this.GalleryWidth : 0) + "px;"
						+ " top: " + vCenter + "px;";

    var growStyling = " width: " + newImage.Width + "px;"
					   + " height: " + newImage.Height + "px;"
					   + " left: " + hPadding + "px;"
					   + " top: " + this.VPadding + "px;";

    // Run animations
    var cuurentID = this.CurrentIMG.substr(1);
    var nextID = this.NextIMG.substr(1);

    $j('#tap_Gallery_content').replaceWith('<div id="tap_Gallery_content">&nbsp;</div>');


    new Effect.Morph(this.ContainerID.substr(1), { style: " height: " + (newImage.Height + this.VPadding) + "px;" });

    new Effect.Fade(cuurentID);
    new Effect.Morph(cuurentID, { style: shrinkStyling });

    new Effect.Appear(nextID);
    var gallery = this;
    new Effect.Morph(nextID, { style: growStyling,
        afterFinish: function () {
            // Confgire for next click
            var temp = gallery.CurrentIMG;
            gallery.CurrentIMG = gallery.NextIMG;
            gallery.NextIMG = temp;
            $j('#tap_Gallery_content').replaceWith('<div id="tap_Gallery_content">' + newImage.Title + '</div>');
            gallery.__BindLinks();
        }
    });
}

Gallery.prototype.__UnbindLinks = function () {
   	$j('#previousImageLink').unbind('click');
   	$j('#nextImageLink').unbind('click');
   
	$j('#nextImageLink').css('cursor', 'default');
	$j('#previousImageLink').css('cursor', 'default');
	$j('#nextImageLink').css('color', '#404040');
	$j('#previousImageLink').css('color', '#404040');
}


Gallery.prototype.__BindLinks = function () {
	var gallery = this;

	if(this.CurrentImageIndex + 1 < this.Images.length)
	{
		$j('#nextImageLink').click(function(){gallery.NextImage();});
		$j('#nextImageLink').css('color', 'white');
		$j('#nextImageLink').css('cursor', 'pointer');
	}

	if (this.CurrentImageIndex > 0)
	{
		$j('#previousImageLink').click(function(){gallery.PreviousImage();});
		$j('#previousImageLink').css('color', 'white');
		$j('#previousImageLink').css('cursor', 'pointer');
	}
}


function ImageInformation() {
	this.Src = "";
	this.Width = 0;
	this.Height = 0;
	this.Image = new Image();
}

ImageInformation.prototype.Load = function (maxWidth, callbackObject, action) {
	var Img = this;

	if (this.Image.complete && this.Width != 0 && this.Height != 0) {
		if(callbackObject != null) {callbackObject[action](Img);}
		return;
	}

	this.Image.onload = function () {
		var scaleX = 1;
		if (Img.Image.width > maxWidth) {
			scaleX = maxWidth / Img.Image.width;
		}

		var scaleY = 1;
		if (Img.Image.height > maxWidth) {
			scaleY = maxWidth / Img.Image.height;
		}

		var scale = Math.min(scaleX, scaleY);

		Img.Width = Img.Image.width * scale;
		Img.Height = Img.Image.height * scale;

		if(callbackObject != null) {callbackObject[action](Img);}
		Img.onload = null;
	}

	this.Image.src = this.Src;
}