jQuery(document).ready(function($){

	//Global variables
	var _types 				= window.xoo_aff_field_types,
		_sections			= window.xoo_aff_field_sections,
		_fieldsLayout 		= window.xoo_aff_fields_layout;
	window._userFields 		= window.xoo_aff_db_fields || {};
	var required_settings 	= {}; 

	var $selectable 	= $( '.xoo-aff-select-fields-type' ),
		$fieldsDisplay 	= $( '.xoo-aff-main' ),
		$fieldSettings 	= $( '.xoo-aff-field-settings-container' ),
		$fieldSelector 	= $( '.xoo-aff-field-selector' ),
		$container 		= $( '.xoo-aff-settings-container' );


	//Select multiple list
	var MultipleList = function( $field ){
		var self 				= this;
		self.$field 			= $field;
		self.$cont 				= $field.closest('.xoo-aff-select-multiple-container');
		self.$itemList 			= self.$cont.find( 'ul.xoo-aff-multiple-list' );
		self.$select 			= self.$cont.find('.xoo-aff-select-multiple');
		self.$selectedListArea  = self.$cont.find('.xoo-aff-select-multiple-textarea');
		self.$selectedList 		= self.$selectedListArea.find('ul');

		//Methods
		self.getFieldValue = self.getFieldValue.bind(this); 

		//Events
		self.$itemList.on( 'click', 'li', { field: self }, self.onItemSelect );
		self.$selectedList.on( 'click', 'li', { field: self }, self.setDefaultItem );
		self.$selectedListArea.on( 'click', { field: self }, self.openList );
		self.$selectedList.on( 'click', '.xoo-aff-sel-remove', { field: self }, self.removeItem )
		$(document).on( 'click', { field: self }, self.hideList );
	}

	/**
	 * Get field Value.
	 * @return array
	 */
	MultipleList.prototype.getFieldValue = function(){
		return Array.isArray( this.$select.val() ) ? this.$select.val() : []
	}

	MultipleList.prototype.onItemSelect = function(event){
		var field  		= event.data.field,
			select_val 	= field.getFieldValue(),
			item_val 	= $(this).data('value');

		//If item not already selected
		if( $.inArray(item_val, select_val) === -1 ){
			select_val.push( item_val );
			field.$select.val( select_val ).trigger('change');
			field.$selectedList.append('<li data-value="'+item_val+'"><span class="xoo-aff-sel-remove dashicons dashicons-no-alt"></span>'+$(this).text()+'</li>');
		}

		field.$itemList.hide();
	}


	MultipleList.prototype.setDefaultItem = function(event){
		var field  = event.data.field;
		field.$selectedList.find('li.aff-default').add( field.$select.find('option.aff-default') ).removeClass('aff-default');
		field.$select.find('option[value="'+$(this).data('value')+'"]').add($(this)).addClass('aff-default');
		field.$select.trigger('change');
	}


	MultipleList.prototype.hideList = function(event){
		var field  = event.data.field;
		$.each(event.target.classList,function(key,value){
			if(value !== "xoo-aff-multiple-list" && value !== 'xoo-aff-select-multiple-textarea'){
				field.$itemList.hide();
			}
		})
	}


	MultipleList.prototype.openList = function(event){
		event.data.field.$itemList.show();
	}


	MultipleList.prototype.removeItem = function(event){
		var field  	= event.data.field,
			$li 	= $(this).closest('li');
			selVal 	= field.getFieldValue();

		$li.remove();
		selVal.splice( $.inArray( $li.data( 'value') , selVal) , 1 );
		field.$select.val( selVal ).trigger('change');
	}


	MultipleList.onValueChange = function( $field ){

		var $select = $field.closest('.xoo-aff-select-multiple-container').find('.xoo-aff-select-multiple');
			list 	= {};
		$.each( $field.val(), function( index, value ){
			var $option = $select.find('option[value="'+value+'"]');
			list[value] = {
				value: value,
				checked: $option.hasClass('aff-default') ? 'checked' : '',
				label: $option.text(),
			}
		} );

		return list;

	}

	/* ---XXXXX--- */

	//Multiple option
	var MultipleOptions = function( $field ){
		var self 				= this;
		self.$field 			= $field;
		self.$addOption 		= self.$field.find('.xoo-add-option');
		self.$optionsList 		= self.$field.find('.xoo-aff-options-list');
		self.$changeTrigger 	= self.$field.find('.xoo-aff-trigger-change');

		//Events
		self.$optionsList.on( 'click', '.mcb-del', { field: self }, self.deleteOption );
		self.$addOption.on( 'click', { field: self }, self.addOption );
		self.$optionsList.sortable({
			update: function( event, ui ){
				self.$changeTrigger.trigger('change');
			}
		})
	}

	/**
	 * Get field Value.
	 * @param  $field 	Field Element
	 * @return array
	 */
	MultipleOptions.getFieldValue = function( $field ){

		var field_value = {},
			priority 	= 0;

		$field.find('.xoo-aff-options-list li').each( function( index, li){
			var $li_el  	= $(li),
				li_checked  = $li_el.find('.option-check').is(":checked") ? 'checked' : false,
				li_label 	= $li_el.find('.mcb-label').val(),
				li_value 	= $li_el.find('.mcb-value').val();

			if( !li_label || !li_value  ) return true;

			var checkbox_data = {
				checked: li_checked,
				label:  li_label,
				value: li_value,
				priority: priority += 10, 
			};

			field_value[li_value] = checkbox_data;

		} );

		return field_value;
	}

	MultipleOptions.prototype.addOption = function(event){
		event.data.field.$optionsList.find('li:last-of-type')
			.clone()
			.appendTo(event.data.field.$optionsList);
		event.data.field.$changeTrigger.trigger('change');
	}


	MultipleOptions.prototype.deleteOption = function(event){
		var $li = $(this).closest('li');
		if( $li.index() === 0 ) return; //cannot delete first one.
		$li.remove();
		event.data.field.$changeTrigger.trigger('change');
	}

	/* ----- XXXX ---- */

	function generate_field_settings( id_or_type ){

		var field_id = field_type = new_field = false;

		//Already a field
		if( _userFields[ id_or_type ] ){
			field_id 	= id_or_type;
			field_type 	= _userFields[ field_id ]['field_type'];
		}
		else{
			field_type 	= id_or_type;
			new_field 	= true;
			field_id 	= field_type + '_' + random_id();

			//Placeholder for field settings
			_userFields[ field_id ] = {
				field_type: field_type,
				input_type: _types[ field_type ]['type'],
				settings: {},
				priority: 0 //sort fields later
			}
		}

		$(document).trigger( 'xoo_aff_before_generate_setting', [ field_type ] );
		
		if( _fieldsLayout[ field_type ] === undefined ) return;

		var sections = JSON.parse( JSON.stringify ( _fieldsLayout[ field_type ] ) );

		var section_html = '';

		$.each( sections, function( section_id, settings ){

			var fields_html  = '',
				section_data = _sections[ section_id ];

			//Creating settings HTML
			$.each( settings, function( fs_id ,fs_data){

				//Get value
				if( new_field ){
					_userFields[ field_id ]['settings'][fs_id] = fs_data['value'];
				}
				else{
					fs_data.value =  _userFields[ field_id ]['settings'][fs_id];
				}

				var field_setting_template = wp.template('xoo-aff-field-settings');
				fields_html += field_setting_template(fs_data);
			});

			//Creating Section template
			var section_template = wp.template('xoo-aff-field-section');
			var section_template_data = JSON.parse( JSON.stringify ( section_data ) );
				section_template_data["html"] = fields_html;
			section_html += section_template( section_template_data );

		} )


		//Generate field settings Container & Push fields HTML to container
		var fields_settings_container = wp.template('xoo-aff-field-settings-container');
		var fields_settings_container_data = {
			field_id: field_id,
			type_data: _types[field_type],
			fields_html: section_html
		}
		$fieldSettings.html( fields_settings_container( fields_settings_container_data ) );

		//Generate Field display HTML
		display_field( field_id );

		$(document).trigger( 'xoo_aff_setting_generated', [ field_id,  _userFields[ field_id ] ] );
	}

	//Display field row
	function display_field(field_id){
		//If already displayed or Id not found
		if( $fieldsDisplay.find('#'+field_id).length || !_userFields[ field_id ] ) return;
		var type = _userFields[ field_id ].type;
		var field_display_data = {
			field_id: field_id,
			type_data: _types[field_type]
		};
		var field_display_template = wp.template('xoo-aff-field-display');
		$fieldsDisplay.append( field_display_template( field_display_data ) );
	}

	//Set Label
	function set_label(field_id){
		var $label = $('#'+field_id + ' .xoo-aff-label span:last-of-type');
		var label = null;
		if( _userFields[field_id]['settings']['label_text']){

			label = _userFields[field_id]['settings']['label_text'];
		}
		else if( _userFields[field_id]['settings']['placeholder'] ){
			label = _userFields[field_id]['settings']['placeholder'];
		}
		
		$label.html( label === null ? '' :  '- '+ label );
		
	}

	$(document).on('xoo_aff_setting_generated',function(event,field_id){

		//Focus on generated field
		$('body '+'.xoo-aff-fs-display').removeClass('active');
		$('body '+'#'+field_id).addClass('active');

		//Initialize datepicker
		if( $( '.xoo-aff-field-settings#'+field_id ).find('.xoo-aff-datepicker').length ){
			init_datepicker();
		}

		//Set field id
		$('#xoo_aff_uniqueid').val(field_id).trigger('change');

		//All select trigger change
		//$('.xoo-aff-field-settings select').trigger('change');

		$.each( $('select.xoo-aff-select-multiple'), function( index, el){
			new MultipleList( $(el) );
		} )

		$.each( $('.xoo-aff-multiple-options'), function( index, el){
			new MultipleOptions( $(el) );
		} )

		set_label(field_id);
		$fieldSettings.show();
		$fieldsDisplay.show();
		$fieldSelector.hide();

	})

	$('.xoo-aff-add-field').click(function(){
		$('body '+'.xoo-aff-fs-display').removeClass('active');
		$fieldSettings.hide();
		$fieldSelector.show();
	})


	//Initialize Selectable
	$selectable.selectable();

	//On field selection from selector.
	$selectable.on('selectableselected',function(event,ui){

		var $selected = $(ui.selected);
		var type = $selected.data('field');

		generate_field_settings(type);

	})

	//Switch fields
	$('body').on('click','.xoo-aff-fs-display',function(){
		var container_id = $(this).attr('id');
		generate_field_settings(container_id);
	
	});

	//Reset fields
	$('body').on('click','.xoo-aff-reset-field',function(e){
		e.preventDefault();
		if( !confirm("Are you sure.This will remove your custom fields & take you back to default fields settings?") ) return;
		add_notice( 'Resetting.. Please wait...','info' );

		//Ajax reset
		$.ajax({
			url: xoo_aff_localize.ajax_url,
			type: 'POST',
			data: {
				action: 'xoo_aff_reset_settings',
			},
			success: function(response){
				console.log(response);
				if( response.success && response.success == 1){
					add_notice('Reset successfully. Refreshing page...','success');
					window.location.reload();
				}
				else{
					add_notice('Please contact support team','error');
				}
			}
		})

	});


	//Delete fields
	$('body').on('click','.xoo-aff-fsd-cta-del',function(e){

		e.stopPropagation();

		if( !confirm("Are you sure?") ) return;

		var field 		= $(this).parents('.xoo-aff-fs-display'),
			field_id  	= field.attr('id');

		delete window._userFields[field_id];

		//Set focus on next element
		if( field.hasClass('active') &&  $fieldsDisplay.find('.xoo-aff-fs-display').length > 1 ){
			var switch_to_field = field.next().length ? field.next() : field.prev();
			switch_to_field.trigger('click');
		}

		//Remove field
		$('body #'+ field_id).remove();

		//Check if there is any field
		if( $fieldsDisplay.find('.xoo-aff-fs-display').length === 0 ){
			$fieldsDisplay.hide();
			$fieldSelector.show();
		}
	})

	function random_id(){
		return Math.random().toString(36).substr(2, 5);
	}


	//Initialize datepicker
	function init_datepicker(){
		$('.xoo-aff-datepicker').datepicker({
			altFormat: "yy-mm-dd",
			changeMonth: true,
			changeYear: true,
			yearRange: 'c-100:c+10',
		})
	}

	//Verify uniqueness
	function is_id_unique(input_id){

		//check for length
		if( input_id.length <= 8 ){
			add_notice( 'Uniqued ID must be minimum 8 characters', 'error', 6000 );
			return false;
		}

		//Check for uniqueness
		var unique_id = true;
		$.each( window._userFields, function( field_id, field_data ){
			if( field_id === input_id ){
				add_notice( 'Field with the same ID already exists. Please keep it unique', 'error', 6000 );
				unique_id = false;
				return false;
			}
		} )

		return unique_id; //Exit 
		
	}

	//Update unique id
	function update_uniqueid( old_value, new_value ){
		var updated = false,
			updated_userFields = {};
		$.each( _userFields, function( field_id, field_data ){
			if( field_id === old_value ){
				$('.xoo-aff-field-settings#'+field_id+',.xoo-aff-fs-display#'+field_id).attr( 'id', new_value );
				field_id = new_value;
				field_data['settings']['uniqueid'] = new_value;
				updated = true;
			}
			updated_userFields[ field_id ] = field_data;
		} )

		window._userFields = JSON.parse( JSON.stringify ( updated_userFields ) );
		return updated;
	}


	//Save values on input change
	$fieldSettings.on( 'change', 'input, select', function(){

		var _t 				= $(this),
		 	container 		= _t.parents('.xoo-aff-field-settings'),
			field_id 		= container.attr('id'),
			input_id 		= _t.attr('id'),
			value 			= _t.val();

		if( input_id === 'xoo_aff_uniqueid' ){
			if( field_id !== value && !is_id_unique( value ) ) return;
			field_id = update_uniqueid( field_id, value ) ? value : field_id;
		}

		if( _t.attr('type') === 'checkbox' && !_t.is(":checked") ){
			value = '';
		}

		//If multiple checkboxes
		if( _t.closest('.xoo-aff-multiple-options').length ){
			value = MultipleOptions.getFieldValue( _t.closest('.xoo-aff-multiple-options') );
		}

		//If select multiple
		if( _t.parents( '.xoo-aff-select-multiple-container' ).length ){
			value = MultipleList.onValueChange( _t );
		}
			

		var setting_key = input_id.replace('xoo_aff_', '')
		window._userFields[field_id]["settings"][setting_key] = value;
		set_label( field_id );

	})

	function validate_fields_before_saving(){
		var all_ok = true;
		//Required fields are filled
		$.each( _userFields, function( field_id, field_data) {
			var field_type = field_data.type;
			if( required_settings[ field_type ] === undefined ){
				field_required_settings = [];
				$.each( _fieldsLayout[field_type], function( sections, settings ) {
					$.each( settings, function( setting_id, setting_data ){
						if( setting_data['required'] !== "yes" ) return true;
						field_required_settings.push( setting_id );
					} )
				} )
				if( field_required_settings.length > 0 ){
					required_settings[ field_type ] = field_required_settings;
				}
			}

			$.each( field_data.settings, function( field_setting_id, field_setting_value ){
				if( $.inArray( field_setting_id, required_settings[field_type] ) !== -1 && !field_setting_value.trim() ){
					add_notice( 'Please fill the all required (*) options of field ' + field_id + ' ( '+_types[field_type]['title']+' ) ', 'error' );
					all_ok = false;
					return false;
				}
			} )

			if( !all_ok ) return false;
			
		} )

		return all_ok;
	}


	$('#xoo-aff-save').on('click',function(){

		if( !validate_fields_before_saving() ) return;

		add_notice('Saving fields, Please wait....','info');

		//Sort data as per user display fields
		var data_to_save = sort_fields();

		//Ajax Save
		$.ajax({
			url: xoo_aff_localize.ajax_url,
			type: 'POST',
			data: {
				action: 'xoo_aff_save_settings',
				xoo_aff_data: JSON.stringify(data_to_save)
			},
			success: function(response){
				console.log(response);
				if( response.success && response.success == 1){
					add_notice('Saved successfully.','success');
				}
				else{
					add_notice('Please contact support team','error');
				}
			}
		})

	})

	//Sort fields by adding priority
	function sort_fields(){

		var priority = 10;

		$fieldsDisplay.find('li').each(function( index, li ){
			var $li 	 = $( li ),
				field_id = $li.attr('id');
			if( !window._userFields[ field_id ] ) return true;

			_userFields[ field_id ]['priority'] = priority;

			priority = priority + 10;
			
		});

		return _userFields;

	}

	//Notice
	function add_notice(notice,notice_type,duration=5000){
		clear_notice();
		var data = {
			text: notice,
			type: notice_type
		}
		var template = wp.template('xoo-aff-notice');
		$('.xoo-aff-notice-holder').html( template(data) );

		//Hide notice after 5 seconds
		setTimeout(function(){
			clear_notice();
		},duration);
	}

	function clear_notice(){
		$('.xoo-aff-notice-holder').html('');
	}

	//Font Awesome IconPicker
	$('body').on('focus', '.xoo-aff-iconpicker', function(){
		$(this).iconpicker({
			hideOnSelect: true,
		});
	} )

	$('body').on('iconpickerSelected','.xoo-aff-iconpicker',function(){
		$(this).trigger('change');
	})


	//Generate user fields on page load
	$(function(){
		//Check if there are saved fields in database
		if( !_userFields || $.isEmptyObject( _userFields )) return;

		$fieldSettings.addClass('loading');
		add_notice('Loading fields, Please wait....','info',10000);

		//Converting into array type for sorting
		var _userFieldsArray = Object.entries(_userFields);
		_userFieldsArray.sort(sort_by_priority);

		$.each( _userFieldsArray, function( index, field ){
			//field[0] = Field ID
			generate_field_settings( field[0] );
		} )

		$(document).trigger( 'xoo_aff_all_settings_loaded' );

		$fieldSettings.removeClass('loading');
		clear_notice();
		$fieldsDisplay.find('.xoo-aff-fs-display:first-of-type').trigger('click');

	}());


	function sort_by_priority( a , b ){
		if( b[1]['priority'] === a[1]['priority'] ){
			return 0;
		}
		return b[1]['priority'] < a[1]['priority'] ? 1 : -1;  
	}

	//Hide show Choose countries settings
	$container.on( 'change', '#xoo_aff_country_list', function(){
		var value = $(this).val();
		if( value === 'all' ){
			$('.xoo-aff-setting-countries').hide();
		}
		else{
			$('.xoo-aff-setting-countries').show();
		}	
	})

	//Field display sort
	$fieldsDisplay.sortable();
})