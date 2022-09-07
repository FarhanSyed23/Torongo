(function() {
  (function($) {
    'use strict';
    $.fn.paperCollapse = function(options) {
      var settings;
      settings = $.extend({}, $.fn.paperCollapse.defaults, options);

      $(this).on('click', function(event) {
        //Triky hack :). Not good, but works
        if(!$(event.target).closest(".gks-options-section").hasClass("gks-options-section") ){
            if ($(this).hasClass('active')) {
                settings.onHide.call(this);
                $(this).removeClass('active');
                $(this).find('.body').slideUp(settings.animationDuration, settings.onHideComplete);
            } else {
                settings.onShow.call(this);
                $(this).addClass('active');
                $(this).find('.body').slideDown(settings.animationDuration, settings.onShowComplete);
            }
        }
      });

      /*
      $(this).click(function() {
        if ($(this).hasClass('active')) {
          settings.onHide.call(this);
          $(this).removeClass('active');
          $(this).find('.body').slideUp(settings.animationDuration, settings.onHideComplete);
        } else {
          settings.onShow.call(this);
          $(this).addClass('active');
          $(this).find('.body').slideDown(settings.animationDuration, settings.onShowComplete);
        }
      });
      */

      return this;
    };
    $.fn.paperCollapse.defaults = {
      animationDuration: 400,
      easing: 'swing',
      onShow: function() {},
      onHide: function() {},
      onShowComplete: function() {},
      onHideComplete: function() {}
    };
  })(jQuery);

  (function($) {
    $(function() {
      $('.collapse-card').paperCollapse({});
    });
  })(jQuery);

}).call(this);
