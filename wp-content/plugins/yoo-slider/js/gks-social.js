
function gksOpenTwitterDialog(datasource){
	var url = "https://twitter.com/intent/tweet?url=" + encodeURI(datasource.url) + "&text=" + encodeURI(datasource.caption);
    var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
    w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
}

function gksOpenFBDialog(datasource){
    var url = "https://www.facebook.com/dialog/feed?app_id=277340239486765";
    if (datasource.image != '') {
        url += "&link=" + encodeURI(datasource.image);
        url += "&picture=" + encodeURI(datasource.image);
    } else {
        url += "&link=" + datasource.url;
    }

    url += "&caption=" + encodeURI(datasource.caption) + "&description=" + encodeURI(datasource.message);

	//Outdated version
    /*
    var url = "http://www.facebook.com/sharer.php?u=" + encodeURI(datasource.url) + "&t=" + encodeURI(datasource.caption);
    if (datasource.image) {
    	url += ("&p[images][0]=" + gksQualifiedURL(datasource.image));
    };
    */

    var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
    w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
}

function gksOpenGPlusDialog(datasource){
	var url = "https://plus.google.com/share?url=" + encodeURI(datasource.url);

    var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
    w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
}

function gksOpenPinterestDialog(datasource){
    var url = "http://pinterest.com/pin/create/button/?url=" + encodeURI(datasource.url) + "&description=" + encodeURI(datasource.caption)+ "&media=" + encodeURI(datasource.image);
    if (datasource.image) {
        url += ("&picture=" + gksQualifiedURL(datasource.image));
    }

    var w = window.open(url, "ftgw", "location=1,status=1,scrollbars=1,width=600,height=400");
    w.moveTo((screen.width / 2) - (300), (screen.height / 2) - (200));
}

function gksQualifiedURL(url) {
    var img = document.createElement('img');
    img.src = url; // set string url
    url = img.src; // get qualified url
    img.src = null; // no server request
    return url;
}

function gksConfigureSocialButtons()
{
    jQuery( '.ic-share i' ).off().on( 'click', function( evt ) {
        evt.preventDefault();

        var target = jQuery(this).parent();
        var datasource = jQuery(target.attr("data-datasource"));

        var caption =  jQuery.trim(datasource.attr("data-caption") || document.title);
        var message = jQuery.trim(datasource.attr("data-message"));
        var url = jQuery.trim( datasource.attr("data-url") || location.href.split('#')[0]);
        var image = jQuery.trim( datasource.attr("data-image"));

        var datasource = {
            caption: caption,
            message: message,
            url: url,
            image: image,
        };console.log(datasource);

        if(target.hasClass("ic-twitter")){
            gksOpenTwitterDialog(datasource);
        }else if(target.hasClass("ic-facebook")){
            gksOpenFBDialog(datasource);
        }else if(target.hasClass("ic-plus")){
            gksOpenGPlusDialog(datasource);
        }else if(target.hasClass("ic-pinterest")){
            gksOpenPinterestDialog(datasource);
        }
    });
}

//Perform some actions when window is ready
jQuery(window).load(function () {
    gksConfigureSocialButtons();
});
