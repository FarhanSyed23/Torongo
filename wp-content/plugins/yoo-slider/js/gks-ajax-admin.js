
function gksAjaxGetSliderWithId(sid){
    if(!sid){
        return null;
    }

    var result;
    var sendData = {
        action: 'gks_get_slider',
        id: sid,
    };
    jQuery.ajax ( {
            type		:	'get',
            data        :   sendData,
            url			: 	GKS_AJAX_URL,
            dataType	: 	'json',
            async       :   false,
            success		: 	function( response ) {
                result = gksAjaxResponseValidate(response);
                if(result){
                    var slider = response.slider;
                    result = response.slider;
                }
            },
            error:function( response ) {
                alert(JSON.stringify(response));
                result = null;
            }
     } );

    return result;
}


function gksAjaxSaveSlider(slider){
    if(!slider){
        return null;
    }

    var result;
    var sendData = {
        action: 'gks_save_slider',
        slider: JSON.stringify(slider),
    };
    jQuery.ajax ( {
            type		:	'post',
            data        :   sendData,
            url			: 	GKS_AJAX_URL,
            dataType	: 	'html',
            async       :   false,
            success		: 	function( response ) {
                try{
                    result = JSON.parse(response)
                    result = gksAjaxResponseValidate(result);
                }catch(error){
                    result = null;
                }
            },
            error:function( response ) {
                alert(JSON.stringify(response));
                result = null;
            }
     } );

     return result;
}

function gksAjaxGetOptionsWithPid(sid){
    if(!sid){
        return null;
    }

    var result;
    var sendData = {
        action: 'gks_get_options',
        id: sid,
    };
    jQuery.ajax ( {
            type		:	'get',
            data        :   sendData,
            url			: 	GKS_AJAX_URL,
            dataType	: 	'json',
            async       :   false,
            success		: 	function( response ) {
                result = gksAjaxResponseValidate(response);
                if(result){
                    result = response.options;
                }
            },
            error:function( response ) {
                alert(JSON.stringify(response));
                result = null;
            }
     } );

    return result;
}


function gksAjaxSaveOptionsWithPid(options, sid){
    if(!options || !sid){
        return null;
    }

    var result;
    var sendData = {
        action: 'gks_save_options',
        options: options,
        sid: sid
    };
    jQuery.ajax ( {
            type		:	'post',
            data        :   sendData,
            url			: 	GKS_AJAX_URL,
            dataType	: 	'html',
            async       :   false,
            success		: 	function( response ) {
                try{
                    result = JSON.parse(response)
                    result = gksAjaxResponseValidate(result);
                }catch(error){
                    result = null;
                }
            },
            error:function( response ) {
                alert(JSON.stringify(response));
                result = null;
            }
     } );

     return result;
}

//Helper functions
function gksAjaxResponseValidate(response){
    if(!response) return null;

    if(response.status != 'success'){
        alert(JSON.stringify(response.errormsg));
        return null;
    }

    return response;
}
