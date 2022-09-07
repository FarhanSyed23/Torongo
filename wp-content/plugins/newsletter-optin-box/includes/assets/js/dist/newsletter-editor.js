!function(t){var e={};function n(o){if(e[o])return e[o].exports;var i=e[o]={i:o,l:!1,exports:{}};return t[o].call(i.exports,i,i.exports,n),i.l=!0,i.exports}n.m=t,n.c=e,n.d=function(t,e,o){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:o})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var i in t)n.d(o,i,function(e){return t[e]}.bind(null,i));return o},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=26)}({26:function(t,e,n){var o;o=jQuery,window.noptinNewsletterEditor=n(27).default,o(document).ready((function(){noptinNewsletterEditor.init(),o(".noptin-newsletter-schedule-control .edit-schedule").on("click",(function(t){t.preventDefault();var e=o(this).closest(".noptin-newsletter-schedule-control");e.find(".noptin-schedule").slideDown(),e.find(".edit-schedule").fadeOut(),e.find(".scheduled").show(),e.find(".not-scheduled").hide(),e.find(".scheduled-date").hide()}));var t=function(t){if(t.find(".noptin-schedule").slideUp(),t.find(".edit-schedule").fadeIn(),"scheduled"==t.data("status")){if(t.find(".scheduled-date").show(),t.find(".scheduled").show(),t.find(".not-scheduled").hide(),t.data("schedules")){var e=t.data("schedules");o("#".concat(e)).val(o("#".concat(e)).data("scheduled"))}}else if(t.find(".scheduled-date").hide(),t.find(".scheduled").hide(),t.find(".not-scheduled").show(),t.data("schedules")){var n=t.data("schedules");o("#".concat(n)).val(o("#".concat(n)).data("not-scheduled"))}};t(o(".noptin-newsletter-schedule-control")),o(".noptin-newsletter-schedule-control .save-timestamp").on("click",(function(e){e.preventDefault();var n=o(this).closest(".noptin-newsletter-schedule-control"),i=n.find(".noptin-schedule-input-date").val(),r=n.find(".noptin-schedule-input-time").val(),a="".concat(i," ").concat(r);n.find(".scheduled-date").text(a),n.find(".noptin-schedule-selected-date").val(a),n.data("status","scheduled"),t(n)})),o(".noptin-newsletter-schedule-control .cancel-timestamp").on("click",(function(e){e.preventDefault(),t(o(this).closest(".noptin-newsletter-schedule-control"))})),o(".noptin-schedule-input-date").flatpickr({dateFormat:"Y-m-d",minDate:"today",altInput:!0,altFormat:"F j, Y"}),o(".noptin-schedule-input-time").flatpickr({enableTime:!0,noCalendar:!0,dateFormat:"H:i",time_24hr:!0})}))},27:function(t,e,n){"use strict";n.r(e);var o=n(3);function i(t,e,n){return e in t?Object.defineProperty(t,e,{value:n,enumerable:!0,configurable:!0,writable:!0}):t[e]=n,t}e.default={initial_form:null,init:function(){var t=jQuery;t(".noptin-create-new-automation-campaign").on("click",this.create_automation),t(document).on("click",".noptin-automation-type-select.enabled",this.select_automation),t("#wp-noptinemailbody-media-buttons").append('&nbsp;<a class="button noptin-send-test-email"><span class="wp-menu-image dashicons-before dashicons-email-alt"></span>Send a test email</a>'),t(".noptin-send-test-email").on("click",this.send_test_email),t(".noptin-filter-recipients").on("click",this.filter_recipients),t(".noptin-filter-post-notifications-post-types").on("click",this.new_post_notifications_filter_post_types),t(".noptin-filter-post-notifications-taxonomies").on("click",this.new_post_notifications_filter_taxonomies),t(".noptin-delete-campaign").on("click",this.delete_campaign)},create_automation:function(t){t.preventDefault(),Swal.fire({html:jQuery("#noptin-create-automation").html(),showConfirmButton:!1,showCloseButton:!0,width:600})},select_automation:function(t){var e;t.preventDefault();var n=jQuery(this).find(".noptin-automation-type-setup-form").clone().find("form").attr("id","noptinCurrentForm").parent(),r=n.html();n.remove(),Swal.fire((i(e={html:r,showCloseButton:!0,width:800,showCancelButton:!0,confirmButtonText:"Continue",showLoaderOnConfirm:!0},"showCloseButton",!0),i(e,"focusConfirm",!1),i(e,"allowOutsideClick",(function(){return!Swal.isLoading()})),i(e,"preConfirm",(function(){var t=o.a.getFormData(jQuery("#noptinCurrentForm"));return t.action="noptin_setup_automation",jQuery.post(noptin_params.ajaxurl,t).done((function(t){window.location=t})).fail((function(t){Swal.fire({type:"error",title:"Error",text:"There was an error creating your automation",showCloseButton:!0,confirmButtonText:"Close",confirmButtonColor:"#9e9e9e",footer:"<code>Status: ".concat(t.status," &nbsp; Status text: ").concat(t.statusText,"</code>")})})),jQuery.Deferred()})),e))},delete_campaign:function(t){t.preventDefault();var e=jQuery(this).closest("tr"),n={id:jQuery(this).data("id"),_wpnonce:noptin_params.nonce,action:"noptin_delete_campaign"};Swal.fire({titleText:"Are you sure?",text:"You are about to permanently delete this campaign.",type:"warning",showCancelButton:!0,confirmButtonColor:"#d33",cancelButtonColor:"#9e9e9e",confirmButtonText:"Yes, delete it!",showLoaderOnConfirm:!0,showCloseButton:!0,focusConfirm:!1,allowOutsideClick:function(){return!Swal.isLoading()},preConfirm:function(){return jQuery.get(noptin_params.ajaxurl,n).done((function(){jQuery(e).remove(),Swal.fire("Success","Your campaign was deleted","success")})).fail((function(){Swal.fire("Error","Unable to delete your campaign. Try again.","error")})),jQuery.Deferred()}})},send_test_email:function(t){t.preventDefault(),tinyMCE.triggerSave();var e=o.a.getFormData(jQuery(this).closest("form"));Swal.fire({titleText:"Send a test email to:",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Send",showLoaderOnConfirm:!0,showCloseButton:!0,input:"email",inputValue:noptin_params.admin_email,inputPlaceholder:noptin_params.admin_email,allowOutsideClick:function(){return!Swal.isLoading()},preConfirm:function(t){return e.email=t,e.action="noptin_send_test_email",jQuery.post(noptin_params.ajaxurl,e).done((function(t){t.success?Swal.fire("Success",t.data,"success"):Swal.fire({type:"error",title:"Error!",text:t.data,showCloseButton:!0,confirmButtonText:"Close",confirmButtonColor:"#9e9e9e",footer:'<a href="https://noptin.com/guide/sending-emails/troubleshooting/">How to troubleshoot this error.</a>'})})).fail((function(t){Swal.fire({type:"error",title:"Unable to connect",text:"This might be a problem with your server or your internet connection",showCloseButton:!0,confirmButtonText:"Close",confirmButtonColor:"#9e9e9e",footer:"<code>Status: ".concat(t.status," &nbsp; Status text: ").concat(t.statusText,"</code>")})})),jQuery.Deferred()}})},filter_recipients:function(t){t.preventDefault(),jQuery("#noptin_recipients_filter_div").length||Swal.fire({titleText:"Addon Needed!",html:"Install the <strong>Ultimate Addons Pack</strong> to filter recipients by their sign up method/form, tags or the time in which they signed up.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Install Addon",showCloseButton:!0}).then((function(t){t.value&&(window.location.href="https://noptin.com/product/ultimate-addons-pack")}))},new_post_notifications_filter_post_types:function(t){t.preventDefault(),Swal.fire({titleText:"Addon Needed!",html:"Install the <strong>Ultimate Addons Pack</strong> to send new post notifications to other post types.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Install Addon",showCloseButton:!0}).then((function(t){t.value&&(window.location.href="https://noptin.com/product/ultimate-addons-pack")}))},new_post_notifications_filter_taxonomies:function(t){t.preventDefault(),Swal.fire({titleText:"Addon Needed!",html:"Install the <strong>Ultimate Addons Pack</strong> to limit new post notifications to specific categories, tags or other taxonomies.",showCancelButton:!0,confirmButtonColor:"#3085d6",cancelButtonColor:"#d33",confirmButtonText:"Install Addon",showCloseButton:!0}).then((function(t){t.value&&(window.location.href="https://noptin.com/product/ultimate-addons-pack")}))}}},3:function(t,e,n){"use strict";e.a={templateData:function(t){var e={};if(noptinEditor&&noptinEditor.templates[t]){var n=noptinEditor.templates[t].data;Object.keys(n).forEach((function(t){e[t]=n[t]}))}return e},applyTemplate:function(t,e){Object.keys(t).forEach((function(n){e[n]=t[n]})),e.hideFields=!1,e.gdprCheckbox=!1,this.updateFormSizes(e)},updateFormSizes:function(t){return"sidebar"==t.optinType?(t.formHeight="400px",t.formWidth="300px",void(t.singleLine=!1)):"popup"==t.optinType?(t.formWidth="620px",void(t.formHeight="280px")):"slide_in"==t.optinType?(t.formWidth="400px",void(t.formHeight="280px")):(t.formHeight="280px",void(t.formWidth="620px"))},updateCustomCss:function(t){jQuery("#formCustomCSS").text(t)},getColorThemeOptions:function(){var t=[];return Object.keys(noptinEditor.color_themes).forEach((function(e){var n={text:e,value:noptinEditor.color_themes[e],imageSrc:noptin_params.icon};t.push(n)})),t},getColorTheme:function(t){return t.colorTheme.split(" ")},changeColorTheme:function(t){var e=this.getColorTheme(t);e.length&&(t.noptinFormBg=e[0],t.noptinFormBorderColor=e[2],t.noptinButtonColor=e[0],t.noptinButtonBg=e[1],t.titleColor=e[1],t.descriptionColor=e[1],t.noteColor=e[1])},getFormData:function(t){var e={},n=jQuery(t).serializeArray();return jQuery.each(n,(function(t,n){e[n.name]=n.value})),e}}}});