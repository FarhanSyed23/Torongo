var el = wp.element.createElement,
    registerBlockType = wp.blocks.registerBlockType;

registerBlockType( 'yooslider/yooslider-block', {
    title: 'Yoo Slider',

    icon: 'slides',

    category: 'common',

    attributes: {
        content: {
            type: 'string',
            source: 'html',
            selector: 'div'
        },
        gridId: {
            type: 'string',
            source: 'attribute',
            selector: 'div',
            attribute: 'data-gks-id'
        }
    },

    edit: function( props ) {
        var updateFieldValue = function( val ) {
            props.setAttributes( { content: '[yooslider id='+val+']', gridId: val } );
        };
        var options = [];

        if (gks_shortcodes.length > 0) {
          options.push({label: 'Choose one of your sliders!', value: ''})

          for (var i in gks_shortcodes) {
              options.push({label: gks_shortcodes[i].title + '   [yooslider id=' + gks_shortcodes[i].id + ']', value: gks_shortcodes[i].id})
          }
        } else {
          options.push({label: 'You do not have any sliders!', value: ''})
        }

        return el('div', {
            className: props.className
        }, [
            el( 'div', {className: 'gks-block-box'}, [ el( 'div', {className: 'gks-block-label'}, 'Select slider' ), el( 'div', {className: 'gks-block-logo'} )] ),
            el(
                wp.components.SelectControl,
                {
                    label: '',
                    value: props.attributes.gridId,
                    onChange: updateFieldValue,
                    options: options
                }
            )
        ]);
    },
    save: function( props ) {
        return el( 'div', {'data-gks-id': props.attributes.gridId}, props.attributes.content);
    }
} );
