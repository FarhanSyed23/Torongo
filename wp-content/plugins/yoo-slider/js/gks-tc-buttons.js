(function() {
    tinymce.PluginManager.add('gks_tc_buttons', function( editor, url ) {
        var menuItems = new Array();
        for (var i = 0; i < gks_shortcodes.length; i++){
            var shortcode = gks_shortcodes[i];

            item = {
               text: shortcode.title,
               value: shortcode.shortcode,
               onclick: function() {
                   editor.insertContent(this.value());
               }
            };
            menuItems.push(item);
        }

        editor.addButton( 'gks_insert_tc_button', {
            text: 'Yoo Slider',
            icon: 'icon dashicons-before dashicons-slider',
            type: 'menubutton',
            menu: menuItems
        });
    });
})();
