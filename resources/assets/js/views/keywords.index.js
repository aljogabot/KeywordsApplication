function KeywordsIndex()
{
	this.construct();
};

KeywordsIndex.prototype = {

	construct : function()
	{
		this.init_main_form();
		this.init_events();
	},

	init_main_form : function()
	{
		var $self = this;

		$( 'form[name=keywords-form]' ).submit(
			function( $event )
			{
				$event.preventDefault();
				var $form = $( this );

				var $data = new FormData( $form[0] );

				$http.postUpload( $form.attr( 'action' ), $data,
					function( $json_response ) {
						if( $json_response.success ) {
							$BootstrapModalService.setContent( $json_response.content ).load(
								function()
								{
									$self.init_multiply_form();
								}
							);
						} else {
							$FormMessageService.error( $json_response.message );
						}
					}
				);
			}
		);
	},

	init_events : function()
	{
		$( '.upload' ).change(
			function()
			{
				$( '#file_label' ).val( $( this ).val() );
			}
		);
	},

	init_multiply_form : function()
	{
		$( 'form[name=keywords-preview-form]' ).submit(
			function( $event )
			{
				$event.preventDefault();
				var $form = $( this );
				var $data = $form.serialize();

				$FormMessageService.setElement( $form );
				$FormMessageService.notify( 'Processing ...' );

				$http.post( $form.attr( 'action' ), $data,
					function( $json_response ) {
						if( $json_response.success ) {
							$BootstrapModalService.setContent( $json_response.content ).load();
						} else {
							$FormMessageService.error( $json_response.message );
						}
					}
				);
			}
		);
	}

};

var $KeywordsIndex;

$( document ).ready(
	function()
	{
		$KeywordsIndex = new KeywordsIndex();
	}
);