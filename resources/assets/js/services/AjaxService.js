function AjaxService() {};

AjaxService.prototype = {

	post : function( $url, $data, callback ) {
		$.ajax(
			{
				url	: $url,
				type: 'POST',
				dataType: 'json',
				data: $data,
				headers: {
			        'X-CSRF-Token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
			    },
				success: function( $json_response ) {
					callback( $json_response );
				}
			}
		);
	},

	/**
	 * This method is for Uploading Files ...
	 * @param  {[type]}   $url     [description]
	 * @param  {[type]}   $data    [description]
	 * @param  {Function} callback [description]
	 * @return {[type]}            [description]
	 */
	postUpload : function( $url, $data, callback ) {
		$.ajax(
			{
				url	: $url,
				type: 'POST',
				dataType: 'json',
				data: $data,
				async: false,
				cache: false,
		        contentType: false,
		        processData: false,
				headers: {
			        'X-CSRF-Token': $( 'meta[name="csrf-token"]' ).attr( 'content' )
			    },
				success: function( $json_response ) {
					callback( $json_response );
				}
			}
		);
	},

	get : function( $url, $parameters, callback ) {
		// Some Other Time Baby ...
	}

};

var $http;

$( document ).ready(
	function() {
		$http = new AjaxService();
	}
);