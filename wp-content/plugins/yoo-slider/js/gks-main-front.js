
function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var temp = array[i];
        array[i] = array[j];
        array[j] = temp;
    }
}

function gksShowNoResult(sliderId)
{
    if (jQuery("#gks-content-"+sliderId+" .gks-wrapper").hasClass('gks-wrapper-catalog') && jQuery.isEmptyObject(jQuery("#gks-content-" + sliderId + " .gks-wrapper .ftg-items").html())) {
        jQuery("#gks-content-" + sliderId + " .gks-wrapper .ftg-items").html('<div class="catalog-empty-result">No result found</div>');
        jQuery("#gks-content-" + sliderId).animate({height: 300}, 200);
    }
}

function gks_AdjustSlider(slider) {
    if (slider.width() <= 600) {
        slider.addClass('gks-slider-mobile');
        jQuery(".gks-slider-overlay-caption", slider).each(function(i, elem){
            if (!jQuery(elem).hasClass('gks-info-opened')) {
                if ((jQuery(".gks-slider-title", elem).length > 0 && jQuery(".gks-slider-title", elem)[0].scrollHeight > jQuery(".gks-slider-title", elem)[0].offsetHeight + 2) ||
                    (jQuery(".gks-slider-desc", elem).length > 0 && jQuery(".gks-slider-desc", elem)[0].scrollHeight > jQuery(".gks-slider-desc", elem)[0].offsetHeight + 2)) {
                    jQuery(".gks-slider-info-toggle", elem).removeClass('gks-slider-info-hidden');
                } else {
                    jQuery(".gks-slider-info-toggle", elem).addClass('gks-slider-info-hidden');
                }
            }
        });
    } else {
        slider.removeClass('gks-slider-mobile');
        jQuery(".gks-slider-info-toggle", slider).removeClass('gks-slider-info-hidden');
    }
}
