<?php

$gks_sid = 0;

if(isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])){
    $gks_action = 'edit';
    $gks_sid = (int)$_GET['id'];
}else if(isset($_GET['action']) && $_GET['action'] === 'create'){
    $gks_action = 'create';
}

global $gks_theme;

?>

<div class="gks-slider-header">

    <div class="gks-three-parts gks-fl">
        <a class='gks-back-btn button-secondary slider-button gks-glazzed-btn gks-glazzed-btn-dark' href="<?php echo "?page={$gks_adminPage}"; ?>">
            <div class='gks-icon gks-slider-button-icon'><i class="fa gks-fa fa-long-arrow-left"></i></div>
        </a>
    </div>

    <div class="gks-three-parts gks-fl gks-title-part"><input id="gks-slider-title" class="gks-slider-title" name="slider-title" maxlength="250" placeholder="Enter slider title" type="text"></div>

    <div class="gks-three-parts gks-fr">
        <a id="gks-save-slider-button" class='button-secondary slider-button gks-glazzed-btn gks-glazzed-btn-green gks-fr' href="#">
            <div class='gks-icon gks-slider-button-icon'><i class="fa gks-fa fa-save fa-fw"></i></div>
        </a>
        <a id="gks-slider-options-button" class='button-secondary slider-button gks-glazzed-btn gks-glazzed-btn-orange gks-fr' href="#" onclick="onSliderOptions()">
            <div class='gks-icon gks-slider-button-icon'><i class="fa gks-fa fa-cog fa-fw"></i></div>
        </a>
    </div>
</div>

<hr />

<div class="gks-empty-slide-list-alert">
    <h3>You don't have any items in the slider yet!</h3>
</div>

<div class="gks-gallery-wrapper">
  <div id="gks-toolbar">
      <a id="gks-add-picture-button" href="#">
        <div class="gks-toolbar-btn gks-toolbar-add-pic-btn">
          <div class="gks-toolbar-btn-content">
            <div class="gks-toolbar-btn-icon gks-add-picture-icon"></div>
            <h3 class="gks-toolbar-btn-title">IMAGE</h3>
            <div class="gks-toolbar-btn-overlay"></div>
          </div>
        </div>
      </a>

      <a id="gks-add-youtube-button" href="#">
        <div class="gks-toolbar-btn gks-toolbar-add-youtube-btn <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? "gks-free" : "gks-premium"; ?>">
          <div class="gks-toolbar-btn-content">
            <div class="gks-toolbar-btn-icon gks-add-youtube-icon"></div>
            <h3 class="gks-toolbar-btn-title">YOUTUBE</h3>
            <div class="gks-toolbar-btn-overlay"></div>
            <?php if (GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?>
              <div class="gks-premium-badge">
                PREMIUM
              </div>
            <?php endif; ?>
          </div>
        </div>
      </a>

      <a id="gks-add-vimeo-button" href="#">
        <div class="gks-toolbar-btn gks-toolbar-add-vimeo-btn <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? "gks-free" : "gks-premium"; ?>">
          <div class="gks-toolbar-btn-content">
            <div class="gks-toolbar-btn-icon gks-add-vimeo-icon"></div>
            <h3 class="gks-toolbar-btn-title">VIMEO</h3>
            <div class="gks-toolbar-btn-overlay"></div>
            <?php if (GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?>
              <div class="gks-premium-badge">
                PREMIUM
              </div>
            <?php endif; ?>
          </div>
        </div>
      </a>

      <a id="gks-add-video-button" href="#">
        <div class="gks-toolbar-btn gks-toolbar-add-video-btn <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? "gks-free" : "gks-premium"; ?>">
          <div class="gks-toolbar-btn-content">
            <div class="gks-toolbar-btn-icon gks-add-video-icon"></div>
            <h3 class="gks-toolbar-btn-title">VIDEO</h3>
            <div class="gks-toolbar-btn-overlay"></div>
            <?php if (GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?>
              <div class="gks-premium-badge">
                PREMIUM
              </div>
            <?php endif; ?>
          </div>
        </div>
      </a>

      <a id="gks-add-html-button" href="#">
        <div class="gks-toolbar-btn gks-toolbar-add-html-btn <?php echo GKS_PKG_TYPE == GKS_PKG_TYPE_FREE ? "gks-free" : "gks-premium"; ?>">
          <div class="gks-toolbar-btn-content">
            <div class="gks-toolbar-btn-icon gks-add-html-icon"></div>
            <h3 class="gks-toolbar-btn-title">HTML</h3>
            <div class="gks-toolbar-btn-overlay"></div>
            <?php if (GKS_PKG_TYPE == GKS_PKG_TYPE_FREE): ?>
              <div class="gks-premium-badge">
                PREMIUM
              </div>
            <?php endif; ?>
          </div>
        </div>
      </a>

      <hr />
  </div>

    <!-- <div class="gks-add-item-boxes"> -->
       <!-- <div class="gks-add-item-box"><a id="gks-add-picture-button" class='button-secondary gks-add-slide-button gks-glazzed-btn gks-glazzed-btn-green' href='#' title='Add new picture'>+ Add picture</a></div>
       <div class="gks-add-item-box"><a id="gks-add-video-button" class='button-secondary gks-add-slide-button gks-glazzed-btn gks-glazzed-btn-green' href='#' title='Add new video'>+ Add video</a></div>
       <div class="gks-add-item-box"><a id="gks-add-youtube-button" class='button-secondary gks-add-slide-button gks-glazzed-btn gks-glazzed-btn-green' href='#' title='Add new youtube video'>+ Add youtube video</a></div>
       <div class="gks-add-item-box"><a id="gks-add-vimeo-button" class='button-secondary gks-add-slide-button gks-glazzed-btn gks-glazzed-btn-green' href='#' title='Add new vimeo video'>+ Add vimeo video</a></div>
       <div class="gks-add-item-box"><a id="gks-add-iframe-button" class='button-secondary gks-add-slide-button gks-glazzed-btn gks-glazzed-btn-green' href='#' title='Add new iframe'>+ Add iframe</a></div>
     </div> -->


    <table id="gks-gallery-slide-list">
    </table>
</div>

<?php require_once "gks-admin-dialogs.php"; ?>

<script>

var _GKS_LAST_GENERATED_INT_ID = 100000;
function gks_generateIntId(){
    return ++_GKS_LAST_GENERATED_ID;
}

//Show loading while the page is being complete loaded
gks_showSpinner();

//Configure javascript vars passed PHP
var gks_adminPage = "<?php echo $gks_adminPage ?>";
var gks_action = "<?php echo $gks_action ?>";
var gks_attachmentTypePicture = '<?php echo GKSAttachmentType::PICTURE; ?>';
var gks_attachmentTypeVideo = '<?php echo GKSAttachmentType::VIDEO; ?>';
var gks_attachmentTypeYoutube = '<?php echo GKSAttachmentType::YOUTUBE; ?>';
var gks_attachmentTypeVimeo = '<?php echo GKSAttachmentType::VIMEO; ?>';
var gks_attachmentTypeIframe = '<?php echo GKSAttachmentType::IFRAME; ?>';
var gks_attachmentTypeHTML = '<?php echo GKSAttachmentType::HTML; ?>';

var gksPluginUrl = '<?php echo GKS_PLUGIN_URL; ?>';

//Configure slider model
var gks_slider = {};
gks_slider.id = "<?php echo $gks_sid ?>";
gks_slider.slides = {};
gks_slider.corder = [];
gks_slider.deletions = [];
gks_slider.isDraft = true;
gks_slider.all_cats = [];

jQuery(".gks-empty-slide-list-alert").show();

//Perform some actions when window is ready
jQuery(window).load(function () {
    //Setup sortable lists and grids
    jQuery('.sortable').sortable();
    jQuery('.handles').sortable({
//        handle: 'span'
    });
    jQuery("#gks-gallery-slide-list").sortable({items: 'tr'});



    //In case of edit we sould perform ajax call and retrieve the specified slider for editing
    if(gks_action == 'edit'){
        gks_slider = gksAjaxGetSliderWithId(gks_slider.id);
        //NOTE: The validation and moderation is very important thing. Here could be not expected conversion
        //from PHP to Javascript JSON objects. So here we will validate, if needed we will do changes
        //to meet our needs
        gks_slider = validatedSlider(gks_slider);
        //This slider is already exists on server, so it's not draft item
        gks_slider.isDraft = false;
    }

    jQuery('#gks-gallery-slide-list').sortable().bind('sortupdate', function(e, ui) {
        //ui.item contains the current dragged element.
        //Triggered when the user stopped sorting and the DOM position has changed.
        gks_updateModel();
        gks_updateSlideNumbers();
    });

    jQuery("#gks-save-slider-button").on( 'click', function( evt ){
        evt.preventDefault();

        //Apply last changes to the model
        gks_updateModel();

        //Validate saving
        if(!gks_slider.title){
            alert("Oops! You're trying to save a slider without title.");
            return;
        }

        //Show spinner
        gks_showSpinner();

        //Perform Ajax calls
        gks_result = gksAjaxSaveSlider(gks_slider);

        //Get updated model from the server
        gks_slider = gksAjaxGetSliderWithId(gks_result['sid']);
        gks_slider = validatedSlider(gks_slider);
        gks_slider.isDraft = false;

        gks_selectedSlideId = 0;

        //Update UI
        gks_updateUI();
        jQuery("#gks-slide-list").scrollTop(0);

        //Hide spinner
        gks_hideSpinner();
    });


    jQuery("#gks-add-picture-button").on( 'click', function( evt ){
        evt.preventDefault();

        gks_openMediaUploader( function callback(picInfoArr){
            if(picInfoArr && picInfoArr.length > 0) {
                for (var pi = 0; pi < picInfoArr.length; pi++) {
                    gks_addSlide(picInfoArr[pi]);
                }
            }
        }, true );
    });

    <?php if (GKS_PKG_TYPE == GKS_PKG_TYPE_PREMIUM): ?>
      gksInitializeVideoDialog();
      gksInitializeYoutubeDialog();
      gksInitializeVimeoDialog();
      gksInitializeIframeDialog();

      jQuery("#gks-add-video-form").submit(function(){
          var mode = jQuery(this).data('mode');
          if (mode =='edit') {
              var slideId = jQuery(this).data('slide-id');
              gks_changeSlideCover(slideId, {video:  JSON.parse(jQuery("#gks-video-data-val").val()), thumb: gksGetVideoThumbObj()}, gks_attachmentTypeVideo);
          } else {
              gks_addSlide({video:  JSON.parse(jQuery("#gks-video-data-val").val()), thumb: gksGetVideoThumbObj()},gks_attachmentTypeVideo);
          }
          jQuery("#gks-video-dialog").dialog('close');
          return false;
      });

      jQuery("#gks-add-youtube-form").submit(function(){
          var mode = jQuery(this).data('mode');
          if (mode =='edit') {
              var slideId = jQuery(this).data('slide-id');
              gks_changeSlideCover(slideId, {youtube_id:  jQuery("#gks-youtube-id-val").val(), thumb: gksGetYoutubeThumbObj()}, gks_attachmentTypeYoutube);
          } else {
              gks_addSlide({youtube_id: jQuery("#gks-youtube-id-val").val(), thumb: gksGetYoutubeThumbObj()}, gks_attachmentTypeYoutube);
          }
          jQuery("#gks-youtube-dialog").dialog('close');
          return false;
      });

      jQuery("#gks-add-iframe-form").submit(function(){
          if (!gks_isValidUrl(jQuery("#gks-iframe-src-val").val())) {
              alert('Please enter a valid url');
              return false;
          }
          var mode = jQuery(this).data('mode');
          if (mode =='edit') {
              var slideId = jQuery(this).data('slide-id');
              gks_changeSlideCover(slideId, {iframe_src:  jQuery("#gks-iframe-src-val").val(), thumb: gksGetIframeThumbObj()}, gks_attachmentTypeIframe);
          } else {
              gks_addSlide({iframe_src: jQuery("#gks-iframe-src-val").val(), thumb: gksGetIframeThumbObj()}, gks_attachmentTypeIframe);
          }
          jQuery("#gks-iframe-dialog").dialog('close');
          return false;
      });

      jQuery("#gks-add-vimeo-form").submit(function(){
          var mode = jQuery(this).data('mode');
          if (mode =='edit') {
              var slideId = jQuery(this).data('slide-id');
              gks_changeSlideCover(slideId, {vimeo_id:  jQuery("#gks-vimeo-id-val").val(), thumb: gksGetVimeoThumbObj()}, gks_attachmentTypeVimeo);
          } else {
              gks_addSlide({vimeo_id: jQuery("#gks-vimeo-id-val").val(), thumb: gksGetVimeoThumbObj()}, gks_attachmentTypeVimeo);
          }
          jQuery("#gks-vimeo-dialog").dialog('close');
          return false;
      });

      jQuery("#gks-add-html-button").on( 'click', function( evt ){
          evt.preventDefault();

          gks_openMediaUploader(function callback(picInfo) {
              gks_addSlide({html: GksBase64.encode(""), thumb: picInfo}, gks_attachmentTypeHTML);
          }, false);
      });
    <?php endif; ?>

    jQuery(document).keypress(function(event) {
        //cmd+s or control+s
        if (event.which == 115 && (event.ctrlKey||event.metaKey)|| (event.which == 19)) {
            event.preventDefault();

            jQuery( "#gks-save-slider-button" ).trigger( "click" );
            return false;
        }
        return true;
    });

    //Update UI based on retrieved/(just create) model
    gks_updateUI();

    //When the page is ready, hide loading spinner
    gks_hideSpinner();
});

function gks_addSlide(picInfo, type){

    //Create new draft slide
    var gks_slide = {};
    gks_slide.id = gks_generateIntId();
    gks_slide.title = '';
    gks_slide.description = '';
    gks_slide.url = '';
    gks_slide.isDraft = true;
    gks_slide.categories = [];
    gks_slide.cover = picInfo;

    gks_slider.slides[gks_slide.id] = gks_slide;
    gks_slider.corder.unshift(gks_slide.id);

    gks_addSlideItem(gks_slide, type);
    jQuery(".gks-empty-slide-list-alert").hide();
    jQuery("#gks-gallery-slide-list").scrollTop(0);
}

function gks_addSlideItem(gks_slide, type)
{
    type = (typeof type != 'undefined') ? type : gks_attachmentTypePicture;
    var badge = type == gks_attachmentTypeYoutube ?
        '<i class="fa gks-fa fa-youtube-play"></i>' :
        (type == gks_attachmentTypeVimeo ?
            '<i class="fa gks-fa fa-vimeo-square"></i>' :
            (type == gks_attachmentTypeVideo ?
                '<i class="fa gks-fa fa-video-camera"></i>' :
                (type == gks_attachmentTypeIframe ?
                    '<i class="fa gks-fa fa-code"></i>' :
                        (type == gks_attachmentTypeHTML ?
                            '<i class="fa gks-fa fa-code"></i>' :
                            '<i class="fa gks-fa fa-image"></i>'))));
    var html = '';

    var previewIframeContent = '<html><body style="width: calc(100% - 4px); margin: 0px; padding: 0px;"></body></html>';
    var previewIframe = "<iframe style='display:none;' srcdoc='" + previewIframeContent + "'></iframe>";
    var previewIframeBtn = "<a id='gks-preview-iframe-button' class='button-secondary slider-button gks-glazzed-btn gks-glazzed-btn-green' onclick='gks_previewHTML(this)' data-slide-id='" + gks_slide.id + "' href='#'>SHOW HTML PREVIEW</a>";

    html +=
        '<tr id="gks-gallery-slide-' + gks_slide.id + '" data-id="' + gks_slide.id + '" class="gks-gallery-slide">' +
            '<td class="gks-draggable">' +
              '<i class="fa gks-fa fa-reorder"></i>' +
              '<p class="gks-slide-number"></p>' +
            '</td>' +
            '<td class="gks-attachment">' +
                '<div>' +
                    '<div class="gks-attachment-img">' +
                        '<div class="gks-attachment-img-overlay" onclick="gks_onSlideEdit(\'' + gks_slide.id + '\',\'' + type + '\')"><i class="fa gks-fa fa-pencil"></i></div>' +
                    '</div>' +
                    '<input type="hidden" class="gks-slide-cover-src" name="slide.cover" value="" />' +
                    '<div class="gks-slide-pic-type">'+badge+'</div>'+
                '</div>' +
            '</td>' +
            '<td class="gks-content">' +
                '<div class="gks-content-box"><input type="text" placeholder="Slide title" name="slide.title" value=""></div>' +
                '<div class="gks-content-box ' + (type == gks_attachmentTypeHTML ? "gks-hidden" : "" )+ '"><input type="text" placeholder="Slide link (http://domain.com)" name="slide.url" value=""></div>' +
                '<div class="gks-content-box ' + (type == gks_attachmentTypeHTML ? "gks-hidden" : "" )+ '"><textarea rows=4 placeholder="Slide details" name="slide.description"></textarea></div>' +
                '<div class="gks-content-box ' + (type != gks_attachmentTypeHTML ? "gks-hidden" : "" )+ '"><textarea onchange="onCoverHTMLChanged(this)" oninput="gks_updateHTMLSlidePreview(this)" data-slide-id="'+ gks_slide.id +'" rows=5 placeholder="<div>HTML</div>" name="slide.html"></textarea></div>' +
                (type == gks_attachmentTypeHTML ? previewIframeBtn + previewIframe : "" ) +
            '</td>' +
            '<td class="gks-gallery-delete-proj"><i class="fa gks-fa fa-trash-o" onclick="onDeleteSlide(\'' + gks_slide.id + '\')"></i></td>' +
        '</tr>';
    html = jQuery(html);
    jQuery("input[name='slide.title']", html).val(gks_slide.title);
    jQuery("input[name='slide.cover']", html).val(gks_slide.cover);
    jQuery("textarea[name='slide.description']", html).val(gks_slide.description);
    jQuery("input[name='slide.url']", html).val(gks_slide.url);
    if (type == gks_attachmentTypeHTML) {
      jQuery("textarea[name='slide.html']", html).val(GksBase64.decode(gks_slide.cover.html));
    }
    jQuery("#gks-gallery-slide-list").prepend(html);
    gks_changeSlideCover(gks_slide.id, gks_slide.cover, type);

    if (type == gks_attachmentTypeHTML) {
      jQuery("iframe", html).load(function (iframe) {
        jQuery("#gks-gallery-slide-" + gks_slide.id + " iframe").contents().find('body').html(GksBase64.decode(gks_slide.cover.html));
      });
    }

    gks_updateSlideNumbers();
}

function gks_updateSlideNumbers() {
  jQuery(".gks-slide-number").each(function( index, value ) {
    jQuery(this).html("Slide #" + (index + 1));
  });
}


var gks_hiddenElements = {};
function gks_previewHTML(target) {
  var slideId = jQuery(target).data('slide-id');
  var hide = gks_hiddenElements.hasOwnProperty("display-none") ? false : true;

  if (hide) {
    jQuery(target).html("CLOSE HTML PREVIEW");

    gks_hiddenElements["display-none"] = true;

    gks_hiddenElements["gks-toolbar"] = jQuery("#gks-toolbar").css("display");
    jQuery("#gks-toolbar").css("display", "none");

    gks_hiddenElements["gks-draggable"] = jQuery(".gks-draggable").css("display");
    jQuery(".gks-draggable").css("display", "none");

    gks_hiddenElements["gks-attachment"] = jQuery(".gks-attachment").css("display");
    jQuery(".gks-attachment").css("display", "none");

    gks_hiddenElements["gks-gallery-delete-proj"] = jQuery(".gks-gallery-delete-proj").css("display");
    jQuery(".gks-gallery-delete-proj").css("display", "none");

    gks_hiddenElements["gks-content-input"] = jQuery(".gks-content input[type='text']").css("display");
    jQuery(".gks-content input[type='text']").css("display", "none");

    gks_hiddenElements["gks-gallery-slide"] = jQuery("#gks-gallery-slide-" + slideId).css("display");
    jQuery( "#gks-gallery-slide-list .gks-gallery-slide" ).not( "#gks-gallery-slide-" + slideId ).css("display", "none");

    gks_hiddenElements["gks-html-rows"] = jQuery(".gks-content textarea[name='slide.html']").attr("rows");
    jQuery(".gks-content textarea[name='slide.html']").attr("rows", 15);

    jQuery("#gks-gallery-slide-" + slideId + " iframe").css("display", "block");

    jQuery(target).addClass("gks-active-iframe-btn");
    jQuery(".gks-back-btn").css("visibility", "hidden");

  } else {
    jQuery(target).html("SHOW HTML PREVIEW");

    jQuery("#gks-toolbar").css("display", gks_hiddenElements["gks-toolbar"]);
    jQuery(".gks-draggable").css("display", gks_hiddenElements["gks-draggable"]);
    jQuery(".gks-attachment").css("display", gks_hiddenElements["gks-attachment"]);
    jQuery(".gks-gallery-delete-proj").css("display", gks_hiddenElements["gks-gallery-delete-proj"]);
    jQuery(".gks-content input[type='text']").css("display", gks_hiddenElements["gks-content-input"]);
    jQuery(".gks-gallery-slide" ).css("display", gks_hiddenElements["gks-gallery-slide"]);
    jQuery("#gks-gallery-slide-" + slideId + " iframe").css("display", "none");
    jQuery(".gks-content textarea[name='slide.html']").attr("rows", gks_hiddenElements["gks-html-rows"]);
    jQuery(target).removeClass("gks-active-iframe-btn");
    jQuery(".gks-back-btn").css("visibility", "visible");

    gks_hiddenElements = {};
  }
}

function onCoverHTMLChanged(target){
  var slideId = jQuery(target).data('slide-id');

  var coverInfo = JSON.parse(jQuery("#gks-gallery-slide-" + slideId + " .gks-slide-cover-src").val());
  coverInfo.html = GksBase64.encode(jQuery(target).val());

  gks_changeSlideCover(slideId, coverInfo, gks_attachmentTypeHTML);
}

function gks_updateHTMLSlidePreview(target){
  var slideId = jQuery(target).data('slide-id');
  jQuery("#gks-gallery-slide-" + slideId + " iframe").contents().find('body').html(jQuery(target).val());
}

function gks_changeSlideCover(slideId, info, type) {
    var thumb_img = "<?php echo ($gks_theme == 'dark') ? '/general/glazzed-image-placeholder_dark.png' : '/general/glazzed-image-placeholder.png'; ?>";

    type = (typeof type == 'undefined') ? gks_attachmentTypePicture : type;
    if(info) {
        info.type = type;
    }
    if (type == gks_attachmentTypePicture) {
        var bgImage = (info ? info.src : GKS_IMAGES_URL + thumb_img);
    } else if (type == gks_attachmentTypeYoutube) {
        if (info.thumb.type == gks_attachmentTypeYoutube) {
            var bgImage = gksGetYoutubeThumb(info.youtube_id);
        } else {
            var bgImage = info.thumb.src.src;
        }
    } else if (type == gks_attachmentTypeVideo) {
        if (info.thumb.type == gks_attachmentTypeVideo) {
            var bgImage = info.video.thumb;
        } else {
            var bgImage = info.thumb.src.src;
        }
    } else if (type == gks_attachmentTypeIframe) {
        if (info.thumb.type == gks_attachmentTypeIframe) {
            var bgImage = gksGetIframeThumb();
        } else {
            var bgImage = info.thumb.src.src;
        }
    } else if (type == gks_attachmentTypeVimeo ) {
        if (info.thumb.type == gks_attachmentTypeVimeo) {
            var bgImage = gksGetVimeoThumb(info.vimeo_id);
        } else {
            var bgImage = info.thumb.src.src;
        }
    } else if (type == gks_attachmentTypeHTML ) {
      var bgImage = (info ? info.thumb.src : GKS_IMAGES_URL + thumb_img);
    } else {
        var bgImage = info.thumb.src.src;
    }

    jQuery("#gks-gallery-slide-"+slideId+" .gks-slide-cover-src").val(JSON.stringify(info));
    jQuery("#gks-gallery-slide-"+slideId+" .gks-attachment-img").css('background', 'url('+bgImage+') center center / cover no-repeat');
}

function gks_onSlideEdit(slideId, type) {
    if (type == gks_attachmentTypeYoutube) {
        var picInfo = JSON.parse(jQuery("#gks-gallery-slide-"+slideId+" .gks-slide-cover-src").val());
        jQuery("#gks-add-youtube-form").data('mode', 'edit');
        jQuery("#gks-add-youtube-form").data('slide-id', slideId);
        jQuery("#gks-youtube-id-val").val(picInfo.youtube_id).change();
        jQuery("#gks-add-youtube-form [name='thumb'][value='"+picInfo.thumb.type+"']").prop("checked", true);
        if(picInfo.thumb.type == 'custom') {
            jQuery("#gks-youtube-preview").html(gksYoutubeThumbPreview(picInfo.thumb.src.src, slideId, 'custom'));
            jQuery("#gks-youtube-thumb-val").val(JSON.stringify(picInfo.thumb));
        }
        jQuery("#gks-youtube-dialog").dialog('open');
    } else if (type == gks_attachmentTypeIframe) {
        var picInfo = JSON.parse(jQuery("#gks-gallery-slide-"+slideId+" .gks-slide-cover-src").val());
        jQuery("#gks-add-iframe-form").data('mode', 'edit');
        jQuery("#gks-add-iframe-form").data('slide-id', slideId);
        jQuery("#gks-iframe-src-val").val(picInfo.iframe_src).change();
        jQuery("#gks-add-iframe-form [name='thumb'][value='"+picInfo.thumb.type+"']").prop("checked", true);
        if(picInfo.thumb.type == 'custom') {
            jQuery("#gks-iframe-preview").html(gksIframeThumbPreview(picInfo.thumb.src.src, slideId, 'custom'));
            jQuery("#gks-iframe-thumb-val").val(JSON.stringify(picInfo.thumb));
        }
        jQuery("#gks-iframe-dialog").dialog('open');
    } else if (type == gks_attachmentTypeVideo) {
        var picInfo = JSON.parse(jQuery("#gks-gallery-slide-"+slideId+" .gks-slide-cover-src").val());
        jQuery("#gks-add-video-form").data('mode', 'edit');
        jQuery("#gks-add-video-form").data('slide-id', slideId);
        jQuery("#gks-video-data-val").val(JSON.stringify(picInfo.video));

        var filename = gks_getFilenameFromSrc(picInfo.video.src);
        jQuery("#gks-video-preview").html(gksVideoThumbPreview(picInfo.video.thumb, filename));
        jQuery("#gks-add-video-form [name='thumb'][value='"+picInfo.thumb.type+"']").prop("checked", true);
        if(picInfo.thumb.type == 'custom') {
            jQuery("#gks-video-preview").html(gksVideoThumbPreview(picInfo.thumb.src.src, filename, slideId, 'custom'));
            jQuery("#gks-video-thumb-val").val(JSON.stringify(picInfo.thumb));
        }
        jQuery("#gks-video-dialog").dialog('open');
    } else if (type == gks_attachmentTypeVimeo) {
        var picInfo = JSON.parse(jQuery("#gks-gallery-slide-"+slideId+" .gks-slide-cover-src").val());
        jQuery("#gks-add-vimeo-form").data('mode', 'edit');
        jQuery("#gks-add-vimeo-form").data('slide-id', slideId);
        jQuery("#gks-vimeo-id-val").val(picInfo.vimeo_id).change();
        jQuery("#gks-add-vimeo-form [name='thumb'][value='"+picInfo.thumb.type+"']").prop("checked", true);
        if(picInfo.thumb.type == 'custom') {
            jQuery("#gks-vimeo-preview").html(gksVimeoThumbPreview(picInfo.thumb.src.src, slideId, 'custom'));
            jQuery("#gks-vimeo-thumb-val").val(JSON.stringify(picInfo.thumb));
        }
        jQuery("#gks-vimeo-dialog").dialog('open');
    } else if (type == gks_attachmentTypeHTML) {
        var coverInfo = JSON.parse(jQuery("#gks-gallery-slide-"+slideId+" .gks-slide-cover-src").val());
        gks_openMediaUploader(function callback(picInfo) {
            coverInfo.thumb = picInfo;
            gks_changeSlideCover(slideId, coverInfo, gks_attachmentTypeHTML);
        }, false);
    } else {
        gks_openMediaUploader(function callback(picInfo) {
            gks_changeSlideCover(slideId, picInfo);
        }, false);
    }
}

function gks_updateUI(){

    if(gks_slider.title){
        jQuery("#gks-slider-title").attr( "value", gks_slider.title );
    }

    jQuery("#gks-gallery-slide-list").empty();
    if(gks_slider.slides && gks_slider.corder){
        for(var gks_slideIndex = 0; gks_slideIndex < gks_slider.corder.length; gks_slideIndex++){

            var gks_slideId = gks_slider.corder[gks_slider.corder.length - gks_slideIndex-1];
            if(!gks_slider.slides[gks_slideId]){
                continue;
            }
            var cItem = gks_slider.slides[gks_slideId];
            cItem.title = GksBase64.decode(cItem.title);
            cItem.description = GksBase64.decode(cItem.description);
            cItem.cover = cItem.cover ? JSON.parse(GksBase64.decode(cItem.cover)) : null;
            var type = (!cItem.cover || typeof cItem.cover.type == 'undefined') ? gks_attachmentTypePicture : cItem.cover.type;
            gks_addSlideItem(cItem, type);

            jQuery(".gks-empty-slide-list-alert").hide();
        }
    }
}

function gks_updateModel(){
    //To make sure it's valid JS object
    gks_slider = validatedSlider(gks_slider);

    gks_slider.title = jQuery("#gks-slider-title").attr( "value" );
    gks_slider.corder = jQuery("#gks-gallery-slide-list").sortable("toArray", {attribute: 'data-id'});
    gks_slider.extoptions = {
        all_cats: {},
        type: '<?php echo GKSLayoutType::SLIDER; ?>'
    };

    jQuery(".gks-gallery-slide").each(function(key, elem){
        elem = jQuery(elem);
        gks_selectedSlideId = elem.attr('data-id');
        var gks_activeSlide = gks_slider.slides[gks_selectedSlideId];

        gks_activeSlide.title = GksBase64.encode(jQuery("input[name='slide.title']", elem).val());
        gks_activeSlide.cover = GksBase64.encode(jQuery("input[name='slide.cover']", elem).val());
        gks_activeSlide.description = GksBase64.encode(jQuery("textarea[name='slide.description']", elem).val());
        gks_activeSlide.url = jQuery("input[name='slide.url']", elem).val();
        gks_activeSlide.categories = [];
        gks_activeSlide.pics = gks_activeSlide.cover;

        gks_slider.slides[gks_selectedSlideId] = gks_activeSlide;
    });
}

function validatedSlider(slider){
    if (!slider) {
      slider = {};
    }

    //NOTE: We use assoc array for slides, so if it's null/undefined or Array,
     //then we should change it as an Object to treat it as an assoc array
    if(!slider.slides || (slider.slides && gks_isJSArray(slider.slides))){
        slider.slides = {};
    }

    if(!slider.deletions || !(slider.deletions && gks_isJSArray(slider.deletions))){
        slider.deletions = [];
    }

    return slider;
}

function onDeleteSlide(gks_slideId){
    if(!gks_slideId) return;

    if(!confirm('Are you sure you want to delete?')) {
        return;
    }

    //Remove from slides assoc array and add in deletions list
    delete gks_slider.slides[gks_slideId];
    gks_slider.deletions.push(gks_slideId);

    //Remove from ordered list
    var gks_oi = gks_slider.corder.indexOf(gks_slideId);
    if(gks_oi >= 0){
        gks_slider.corder.splice(gks_oi,1);
    }

    jQuery("#gks-gallery-slide-"+gks_slideId).remove();

}

function onSliderOptions(){
    if(gks_slider.isDraft){
        alert("Save the draft slider before changing the view options");
    }else{
        var href = "?page=" + gks_adminPage + "&action=options&id=" + gks_slider.id+'&type=<?php echo GKSLayoutType::SLIDER; ?>';
        gks_loadHref(href);
    }
}

function onYoutubeThumbTypeChange(elem) {
    if (jQuery(elem).val() == 'custom') {
        var slideId = jQuery("#gks-add-youtube-form").data('slide-id');
        onYoutubeCustomThumbUpload(slideId);
    } else {
        jQuery("#gks-youtube-preview").html(gksYoutubeThumbPreview(gksGetYoutubeThumb(jQuery("#gks-youtube-id-val").val()), slideId, 'youtube'));
        jQuery("#gks-youtube-thumb-val").val('');
    }
}

function onIframeThumbTypeChange(elem) {
    if (jQuery(elem).val() == 'custom') {
        var slideId = jQuery("#gks-add-iframe-form").data('slide-id');
        onIframeCustomThumbUpload(slideId);
    } else {
        jQuery("#gks-iframe-preview").html(gksIframeThumbPreview(gksGetIframeThumb(), slideId, 'iframe'));
        jQuery("#gks-iframe-thumb-val").val('');
    }
}


function onVideoThumbTypeChange(elem) {
    if (jQuery(elem).val() == 'custom') {
        var slideId = jQuery("#gks-add-video-form").data('slide-id');
        onVideoCustomThumbUpload(slideId);
    } else {
        var dataVal = JSON.parse(jQuery("#gks-video-data-val").val());
        jQuery("#gks-video-preview").html(gksVideoThumbPreview(dataVal.thumb, gks_getFilenameFromSrc(dataVal.src), slideId, 'video'));
        jQuery("#gks-video-thumb-val").val('');
    }
}

function onVimeoThumbTypeChange(elem) {
    if (jQuery(elem).val() == 'custom') {
        var slideId = jQuery("#gks-add-vimeo-form").data('slide-id');
        onVimeoCustomThumbUpload(slideId);
    } else {
        jQuery("#gks-vimeo-preview").html(gksVimeoThumbPreview(gksGetVimeoThumb(jQuery("#gks-vimeo-id-val").val()), slideId, 'vimeo'));
        jQuery("#gks-vimeo-thumb-val").val('');
    }
}

function onVideoCustomThumbUpload(slideId) {
    gks_openMediaUploader(function(picInfo) {
        var filename = gks_getFilenameFromSrc(JSON.parse(jQuery("#gks-video-data-val").val()).src);
        jQuery("#gks-video-preview").html(gksVideoThumbPreview(picInfo.src, filename, slideId, 'custom'));
        jQuery("#gks-video-thumb-val").val(JSON.stringify(picInfo));
    }, false, function(){
        if(jQuery(".gks-video-thumb").attr('data-type') == 'video') {
            jQuery("#gks-add-video-form [name='thumb'][value='" + gks_attachmentTypeVideo + "']").prop("checked", true).trigger("change");
        }
    });
}

function onYoutubeCustomThumbUpload(slideId) {
    gks_openMediaUploader(function(picInfo) {
        jQuery("#gks-youtube-preview").html(gksYoutubeThumbPreview(picInfo.src, slideId, 'custom'));
        jQuery("#gks-youtube-thumb-val").val(JSON.stringify(picInfo));
    }, false, function(){
        if(jQuery(".gks-youtube-thumb").attr('data-type') == 'youtube') {
            jQuery("#gks-add-youtube-form [name='thumb'][value='" + gks_attachmentTypeYoutube + "']").prop("checked", true).trigger("change");
        }
    });
}

function onIframeCustomThumbUpload(slideId) {
    gks_openMediaUploader(function(picInfo) {
        jQuery("#gks-iframe-preview").html(gksIframeThumbPreview(picInfo.src, slideId, 'custom'));
        jQuery("#gks-iframe-thumb-val").val(JSON.stringify(picInfo));
    }, false, function(){
        if(jQuery(".gks-iframe-thumb").attr('data-type') == 'iframe') {
            jQuery("#gks-add-iframe-form [name='thumb'][value='" + gks_attachmentTypeIframe + "']").prop("checked", true).trigger("change");
        }
    });
}

function onVimeoCustomThumbUpload(slideId) {
    gks_openMediaUploader(function(picInfo) {
        jQuery("#gks-vimeo-preview").html(gksVimeoThumbPreview(picInfo.src, slideId, 'custom'));
        jQuery("#gks-vimeo-thumb-val").val(JSON.stringify(picInfo));
    }, false, function(){
        if(jQuery(".gks-vimeo-thumb").attr('data-type') == 'vimeo') {
            jQuery("#gks-add-vimeo-form [name='thumb'][value='" + gks_attachmentTypeVimeo + "']").prop("checked", true).trigger("change");
        }
    });
}

</script>
