function uris_clone_run(post_id){
	if(confirm("Are you sure want to create clone of this slider?")){
		var formData = {
			'action': 'uris_clone_slider',
			'ursi_clone_post_id': post_id,
		};
		
		jQuery.ajax({
			type: "post",
			dataType: "json",
			url: uris_ajax_object.ajax_url,
			data: formData,
			success: function(response){
				//console.log('Got this from the server: ' + response);
				//jQuery('.uris-clone-success').show().fadeOut(4000, 'linear');
				jQuery('.uris-clone-success').show();
			}
		});
	}
}