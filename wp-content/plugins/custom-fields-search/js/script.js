(function( $ ) {
	$( document ).ready( function() {
		$( '#cstmfldssrch_div_select_all' ).show( 0, function() {
			var select_all			= $( '.cstmfldssrch-form-table input#cstmfldssrch_select_all' ),
				checkboxes			= $( '.cstmfldssrch-form-table input[name="cstmfldssrch_fields_array[]"]:enabled' ),
				checkboxes_total	= checkboxes.size(),
				checkboxes_selected	= checkboxes.filter(':checked').size();
			if ( checkboxes_total == checkboxes_selected ) {
				select_all.attr( 'checked', true );
			}
		});
		$( '.cstmfldssrch-form-table input' ).bind( 'change click select', function() {
			var	select_all					= $( '.cstmfldssrch-form-table input#cstmfldssrch_select_all' ),
				checkboxes					= $( '.cstmfldssrch-form-table input[name="cstmfldssrch_fields_array[]"]:enabled' ),
				checkboxes_size				= checkboxes.size(),
				checkboxes_selected_size	= checkboxes.filter( ':checked' ).size();
			if ( $( this ).attr( 'id' ) == select_all.attr( 'id' ) ) {
				if ( select_all.is( ':checked' ) ) {
					checkboxes.attr( 'checked', true );
				} else {
					checkboxes.attr( 'checked', false );
				}
			} else {
				if ( checkboxes_size == checkboxes_selected_size ) {
					select_all.attr( 'checked', true );
				} else {
					select_all.attr( 'checked', false );
				}
			}
		});
	});
})( jQuery );