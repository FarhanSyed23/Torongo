var _GKS_LAST_GENERATED_ID = 100000;
function gks_generateId(){
    return "tmsid_" + (++_GKS_LAST_GENERATED_ID).toString();
}

var gksUids = [];
function gks_generateUniqueId() {
    var uid = new Date().valueOf() + Math.floor(Math.random() * 11);
    if (jQuery.inArray(uid, gksUids) != -1) {
        return gks_generateUniqueId();
    }
    gksUids.push(uid);
    return uid;
}

function gks_showSpinner() {
    jQuery("#gks-spinner").css('display', 'block');
    jQuery("#gks-spinner-background").css('display', 'block');
}

function gks_hideSpinner() {
    setTimeout(function(){
        jQuery("#gks-spinner").css('display', 'none');
        jQuery("#gks-spinner-background").css('display', 'none');
    }, 1000);
}

function gks_openMediaUploader( callback, multipleSelection, notSelectedCallback, type ) {
	'use strict';

    multipleSelection = typeof multipleSelection !== 'undefined' ? multipleSelection : false;
    var uploader, imgData, json;

	if ( undefined !== uploader ) {
		uploader.open();
		return;
	}

	var params = {
        frame:    'post',
        state:    'insert',
        multiple: multipleSelection
    };
	if (typeof type == 'undefined') {
       type = 'image';
    }
    params.library = {
        type: [ type ]
    };
	uploader = wp.media.frames.file_frame = wp.media(params);

    if (typeof notSelectedCallback != 'undefined') {
        uploader.on('close', function () {
            var selection = uploader.state('insert').get('selection');
            if (!selection.length) {
                notSelectedCallback();
            }
        });
    }

	uploader.on( 'insert', function() {
        var selections = uploader.state().get( 'selection').toJSON();
        var picInfos = [];

        for(var sIdx = 0; sIdx < selections.length; sIdx++){
            var json = selections[sIdx];
            if ( 0 > jQuery.trim( json.url.length ) ) {
                continue;
            }

            var picInfo = {};
            picInfo.id = json.id;
            if (json.type == 'image') {
                picInfo.src = json.sizes.full.url;

                if (json.sizes.medium) {
                    picInfo.src = json.sizes.medium.url;
                }
            } else if(json.type == 'video') {
                picInfo.src = json.url;
                picInfo.thumb = gksPluginUrl + '/images/general/video_default.jpg';
                // if (json.thumb.src) {
                //     picInfo.thumb = json.thumb.src;
                // } else {
                //     picInfo.thumb = json.icon;
                // }
            }
            picInfos.push(picInfo);
        }

        if(multipleSelection){
            callback(picInfos);
        }else{
            callback(picInfos.length > 0 ? picInfos[0] : null);
        }
	});
	uploader.open();
}

function gks_isJSArray(obj){
    return (Object.prototype.toString.call( obj ) === '[object Array]')
}

function gks_truncateIfNeeded(text, maxLength){
    if(text){
        if(text.length > 3 && text.length > maxLength - 3){
            text = text.substring(0,maxLength - 3);
            text += "..."
        }
    }
    return text;
}

function gks_loadHref(href, blank){
    if(!blank){
        window.location.href = href;
    }else{
        window.open(href, '_blank');
    }
}

function gks_mgfCloseButtonMarkup(){

    var html = "";
    html += "<button class='mfp-close'>";
    html +=     "x"; //"<img class='mfp-close-img'/>";
    html += "</button>"

    return html;
}


var GksBase64 = {

// private property
_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

// public method for encoding
encode : function (input) {
    var output = "";
    var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
    var i = 0;

    if(!input) return output;
    input = GksBase64._utf8_encode(input);

    while (i < input.length) {

        chr1 = input.charCodeAt(i++);
        chr2 = input.charCodeAt(i++);
        chr3 = input.charCodeAt(i++);

        enc1 = chr1 >> 2;
        enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
        enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
        enc4 = chr3 & 63;

        if (isNaN(chr2)) {
            enc3 = enc4 = 64;
        } else if (isNaN(chr3)) {
            enc4 = 64;
        }

        output = output +
        this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
        this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

    }

    return output;
},

// public method for decoding
decode : function (input) {
    var output = "";
    var chr1, chr2, chr3;
    var enc1, enc2, enc3, enc4;
    var i = 0;

    if(!input) return output;
    input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

    while (i < input.length) {

        enc1 = this._keyStr.indexOf(input.charAt(i++));
        enc2 = this._keyStr.indexOf(input.charAt(i++));
        enc3 = this._keyStr.indexOf(input.charAt(i++));
        enc4 = this._keyStr.indexOf(input.charAt(i++));

        chr1 = (enc1 << 2) | (enc2 >> 4);
        chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
        chr3 = ((enc3 & 3) << 6) | enc4;

        output = output + String.fromCharCode(chr1);

        if (enc3 != 64) {
            output = output + String.fromCharCode(chr2);
        }
        if (enc4 != 64) {
            output = output + String.fromCharCode(chr3);
        }

    }

    output = GksBase64._utf8_decode(output);

    return output;

},

// private method for UTF-8 encoding
_utf8_encode : function (string) {
    string = string.replace(/\r\n/g,"\n");
    var utftext = "";

    for (var n = 0; n < string.length; n++) {

        var c = string.charCodeAt(n);

        if (c < 128) {
            utftext += String.fromCharCode(c);
        }
        else if((c > 127) && (c < 2048)) {
            utftext += String.fromCharCode((c >> 6) | 192);
            utftext += String.fromCharCode((c & 63) | 128);
        }
        else {
            utftext += String.fromCharCode((c >> 12) | 224);
            utftext += String.fromCharCode(((c >> 6) & 63) | 128);
            utftext += String.fromCharCode((c & 63) | 128);
        }

    }

    return utftext;
},

// private method for UTF-8 decoding
_utf8_decode : function (utftext) {
    var string = "";
    var i = 0;
    var c = c1 = c2 = 0;

    while ( i < utftext.length ) {

        c = utftext.charCodeAt(i);

        if (c < 128) {
            string += String.fromCharCode(c);
            i++;
        }
        else if((c > 191) && (c < 224)) {
            c2 = utftext.charCodeAt(i+1);
            string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
            i += 2;
        }
        else {
            c2 = utftext.charCodeAt(i+1);
            c3 = utftext.charCodeAt(i+2);
            string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
            i += 3;
        }

    }

    return string;
}

}
function gks_insertParam(url, key, value)
{
    key = encodeURI(key);
    value = encodeURI(value);
    var kvp = url.substr(1).split('&');
    var i = kvp.length;
    var x;
    while(i--) {
        x = kvp[i].split('=');

        if (x[0]==key) {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }

    if (i<0) {
        kvp[kvp.length] = [key,value].join('=');
    }

    return kvp.join('&');
}
