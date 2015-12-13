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